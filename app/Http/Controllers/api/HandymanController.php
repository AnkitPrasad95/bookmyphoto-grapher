<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Helpers\helper;
use App\Models\Setting;
use App\Models\Notification;
use App\Models\Booking;
use App\Models\Handyman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\EmailSendController;

class HandymanController extends Controller
{
   public function login(Request $request)
   {
      if($request->email == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_email')],200);
      }
      if($request->password == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_password')],200);
      }
      if($request->token == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_token')],200);
      }
      
      $checkhandyman = User::where('email',$request->email)->where('type', '=', 3)->where('is_available',1)->first();

      if(!empty($checkhandyman))
      {
         if($checkhandyman->is_available == 1)
         {
            if($checkhandyman->is_verified == 1)
            {
               if(Hash::check($request->password,$checkhandyman->password)) 
               {
                  $update = User::where('email',$request->email)->update(['token'=>$request->token]);
                  $data = User::leftJoin('cities','cities.id','users.city_id')
                     ->select('cities.name as city_name','users.*')
                     ->where('users.email',$request->email)->first();

                  $handymandata = array(
                     'id' => $data->id,
                     'name' => $data->name,
                     'mobile' => $data->mobile,
                     'email' => $data->email,
                     'login_type' => $data->login_type,
                     'about' => strip_tags($data->about),
                     'city_name'=> $data->city_name,
                     'user_type'=> $data->type,
                     'token'=> $data->token,
                     'image_url' => asset('storage/app/public/handyman/'.$data->image)
                  );
                  return response()->json(['status'=>1,'message'=>trans('messages.success'),'providerdata'=>$handymandata],200);
               }else{
                  return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);    
               }
            }else{
               $otp = rand(100000,999999);
         
               //$helper=helper::verificationemail($request->email,$otp);
               $helper = EmailSendController::emailVerification($request->email,$otp);
               if($helper == 1){
                  
                  User::where('email', $request->email)->update(['otp' => $otp]);
                  return response()->json(['status'=>2,'message'=>trans('messages.verify_email'),'otp'=>$otp],200);    
               }else{
                  return response()->json(['status'=>0,'message'=>trans('messages.wrong_while_email')],200);
               }
            }
         }else{
            return response()->json(['status'=>0,'message'=>trans('messages.blocked')],200);    
         }
      }else{
         return response()->json(['status'=>0,'message'=>trans('messages.email_pass_invalid')],200);
      }
   }
   public function dashboard(Request $request)
   {
      if($request->handyman_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_handyman_id')],200);
      }
      $checkhandyman = User::where('id',$request->handyman_id)->where('type',3)->first();
      if(!empty($checkhandyman))
      {
         $appsettings = Setting::select('currency','currency_position')->first();
         $total_bookings = Booking::where('handyman_id',$request->handyman_id)->count();
         $total_completed = Booking::where('handyman_id',$request->handyman_id)->whereIn('status',[3,6])->count();
         $bookings = Booking::leftjoin('services','bookings.service_id','services.id')
                           ->leftjoin('categories','services.category_id','categories.id')
                           ->join('users as customer', function($query) {
                               $query->on('bookings.user_id','=','customer.id')
                               ->where('customer.type', '=', 4);
                            })
                            ->join('booking_addresses', 'booking_addresses.id', '=', 'bookings.address_id')
                           ->select('bookings.booking_id','bookings.service_id','bookings.service_name','bookings.duration as booking_duration','bookings.duration_type as duration_type',
                              'bookings.price','bookings.price_type','categories.name as category_name','bookings.status as booking_status','bookings.handyman_accept', 'bookings.assign_otp', 'bookings.completed_otp','bookings.reason',
                              'customer.name as customer_name','booking_addresses.latitude as customer_latitude', 'booking_addresses.longitude as customer_longitude',
                              DB::raw("CONCAT('".asset('storage/app/public/profile')."/', customer.image) AS user_image_url"),
                              DB::raw("CONCAT('".asset('storage/app/public/service')."/', bookings.service_image) AS image_url"))
                              
                           ->where('bookings.handyman_id',$request->handyman_id)
                           //->where('bookings.handyman_accept','=',1)
                           //->whereIn('bookings.status', [1,2,3,5,6])
                           ->whereIn('bookings.status', [1,2,5])
                           ->orderByDesc('bookings.created_at')
                           ->orderBy('bookings.status')
                           ->get();
         return response()->json(["status"=>1,"message"=>trans('messages.'),'appsettings'=>$appsettings,'total_bookings'=>$total_bookings,'total_completed'=>$total_completed,'bookings'=>$bookings],200);
      }else{
         return response()->json(["status"=>0,"message"=>trans('messages.invalid_user')],200);
      }
   }
   public function bookingdetails(Request $request)
   {
      if($request->handyman_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_handyman_id')],200);
      }
      if($request->booking_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_booking_id')],200);
      }
      $checkbooking = Booking::where('booking_id',$request->booking_id)->where('handyman_id',$request->handyman_id)->first();
      if(!empty($checkbooking)){
         $bookingdata = Booking::join('booking_addresses', 'booking_addresses.id', '=', 'bookings.address_id')
                        ->join('users as customer', function($query) {
                           $query->on('bookings.user_id','=','customer.id')
                           ->where('customer.type', '=', 4);
                        })
                        ->select('bookings.id','bookings.booking_id','bookings.service_id','bookings.service_name','bookings.duration as booking_duration','bookings.duration_type','bookings.price','bookings.price_type','bookings.coupon_code','bookings.discount','bookings.total_amt as total_amount','bookings.payment_type','bookings.date','bookings.time','bookings.status as booking_status','bookings.canceled_by','bookings.note','bookings.handyman_accept','bookings.reason',
                           'customer.id','customer.name as customer_name','customer.email as customer_email','customer.mobile as customer_mobile', DB::raw("CONCAT(booking_addresses.street, ' ', booking_addresses.postcode) as customer_address"), 'booking_addresses.latitude as customer_latitude', 'booking_addresses.longitude as customer_longitude',
                           DB::raw("CONCAT('".asset('storage/app/public/profile')."/', customer.image) AS user_image_url"),
                           DB::raw("CONCAT('".asset('storage/app/public/service')."/', bookings.service_image) AS service_image_url"))
                        ->where('bookings.booking_id',$request->booking_id)
                        ->first();

         return response()->json(["status"=>1,"message"=>trans('messages.success'),'bookingdata'=>$bookingdata],200);
      }else{
         return response()->json(["status"=>0,"message"=>trans('messages.booking_not_exist')],200);
      }
   }
   public function getprofile(Request $request )
   {
      if($request->handyman_id == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_handyman_id')],200);
      }
      $checkhandyman = User::where('id',$request->handyman_id)->where('type', '=', 3)->first();
      
      if(!empty($checkhandyman)){
         $data = array(
            'id' => $checkhandyman->id,
            'name' => $checkhandyman->name,
            'mobile' => $checkhandyman->mobile,
            'email' => $checkhandyman->email,
            'login_type' => $checkhandyman->login_type,
            'image_url' => asset('storage/app/public/handyman/'.$checkhandyman->image)
         );
         return response()->json(['status'=>1,'message'=>trans('messages.success'),'handymandata'=>$data],200);
      } else {
         return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
      }
   }
   public function bookinghistory(Request $request )
   {
      if($request->handyman_id == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_handyman_id')],200);
      }
      $checkhandyman = User::where('id',$request->handyman_id)->where('type', '=', 3)->first();
      if(!empty($checkhandyman)){
         $bookings = Booking::Leftjoin('services','bookings.service_id','services.id')
                        ->Leftjoin('categories','services.category_id','categories.id')
                        ->select('bookings.id','bookings.booking_id','bookings.service_id','bookings.service_name','bookings.duration as booking_duration','bookings.duration_type as duration_type','bookings.date','bookings.time','bookings.price','bookings.price_type','bookings.status as booking_status','categories.name as category_name','bookings.payment_type','bookings.handyman_accept','bookings.reason',
                           DB::raw("CONCAT('".asset('storage/app/public/service')."/', bookings.service_image) AS image_url"))
                        ->where('bookings.handyman_id',$request->handyman_id)
                        ->where(function ($query) {
                           $query->where('bookings.handyman_accept','=',1)
                              ->orWhere('bookings.handyman_accept','=',2);
                           })
                        ->where(function ($query) {
                           $query->where('bookings.status','=',3)
                              //->orWhere('bookings.status','=',3)
                              ->orWhere('bookings.status','=',6);
                           })
                        ->orderByDesc('bookings.updated_at')
                        ->paginate(10);
      return response()->json(["status"=>1,"message"=>trans('messages.success'),"bookings"=>$bookings],200);
      }else{
         return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
      }
   }
   public function bookingaction(Request $request)
   {
      if($request->handyman_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_handyman_id')],200);
      }
      if($request->booking_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_booking_id')],200);
      }
      $checkbooking = Booking::where('booking_id',$request->booking_id)->where('handyman_id',$request->handyman_id)->where('status',2)->first();
      if(!empty($checkbooking)){
         if($request->type != "accept" && $request->type != "reject" && $request->type != "complete"){
            return response()->json(["status"=>0,"message"=>trans('messages.invalid_request')],200);
         }
         
         $provider_id = $checkbooking->provider_id;
         $booking_id = $checkbooking->booking_id;
         if($request->type == "accept"){
            //$helper=helper::assign_handyman($checkbooking->id);
            $helper=EmailSendController::assign_handyman($checkbooking->id);
            if($helper == 1){
               $assign_otp = sprintf("%06d", mt_rand(1, 555555));
               $completed_otp = sprintf("%06d", mt_rand(555556, 999999));
               Booking::where('booking_id',$request->booking_id)->update(['handyman_accept'=>1, 'assign_otp' => $assign_otp, 'assign_status' => 1, 'completed_otp' => $completed_otp]);
               $action = "accept";
               helper::handyman_booking_action_noti($provider_id,$booking_id,$action);   
            }else{
               return response()->json(['status'=>0,'message'=>trans('messages.wrong_while_email')],200);
            }
         }
         if($request->type == "reject"){
            
            if($request->reason == ""){
               return response()->json(["status"=>0,"message"=>trans('messages.enter_reason')],200);
            }
            $action = "reject";
            $reason = $request->reason;
            
            Booking::where('booking_id',$request->booking_id)->update(['handyman_id'=>null,'handyman_accept'=>2,'reason'=>$reason]);
            helper::handyman_booking_action_noti($provider_id,$booking_id,$action);

            Notification::where('booking_id',$booking_id)->where('user_id',$request->handyman_id)->delete();
         }
         if($request->type == "complete"){
            Booking::where('booking_id',$request->booking_id)->where('handyman_id',$request->handyman_id)->update(['status'=>3]);
            helper::complete_booking_noti($checkbooking->user_id,$booking_id,$provider_id);
            if($checkbooking->payment_type != 1 && $checkbooking->payment_type != 2){
               $provider = User::find($provider_id);
               $provider->wallet = $provider->wallet+$checkbooking->total_amt;
               $provider->save();
            }
         }
         
         return response()->json(["status"=>1,"message"=>trans('messages.success')],200);
      }else{
         return response()->json(["status"=>0,"message"=>trans('messages.booking_not_exist')],200);
      }
   }
   
   public function updatelocation(Request $request)
   {
      if($request->handyman_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_handyman_id')],200);
      }
      if($request->latitude == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_latitude')],200);
      }
      if($request->longitude == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_longitude')],200);
      }
      
      $checkhandyman = User::where('id',$request->handyman_id)->where('type', '=', 3)->where('is_available',1)->first();

      if(!empty($checkhandyman))
      {
         $update = User::where('id',$request->handyman_id)->update(['latitude'=>$request->latitude, 'longitude'=>$request->longitude]);
         if($update){
              return response()->json(["status"=>1,"message"=>trans('messages.success')],200);
         }else{
              return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
         }
        
      }else{
         return response()->json(['status'=>0,'message'=>trans('messages.wrong')],200);
      }
   }
   
   public function getlocation(Request $request )
   {
      if($request->handyman_id == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_handyman_id')],200);
      }
      $checkhandyman = User::where('id',$request->handyman_id)->where('type', '=', 3)->first();
      
      if(!empty($checkhandyman)){
         $data = array(
            'id' => $checkhandyman->id,
            'latitude' => $checkhandyman->latitude,
            'longitude' => $checkhandyman->longitude
          );
         return response()->json(['status'=>1,'message'=>trans('messages.success'),'handymandata'=>$data],200);
      } else {
         return response()->json(['status'=>0,'message'=>trans('messages.invalid_user')],200);
      }
   }
   
   public function arrivedPhotographer(Request $request )
   {
       //return $request->input();
      if($request->handyman_id == ""){
         return response()->json(['status'=>0,'message'=>trans('messages.enter_handyman_id')],200);
      }
      
      if($request->booking_id == ""){
         return response()->json(["status"=>0,"message"=>trans('messages.enter_booking_id')],200);
      }
      
    //   if($request->otp == ""){
    //      return response()->json(["status"=>0,"message"=>trans('messages.otp')],200);
    //   }
      //return $request->input();
      if($request->type == 'assign') {
          $checkbooking = Booking::where('booking_id',$request->booking_id)->where('handyman_id',$request->handyman_id)->where('status',2)->where('handyman_accept',1)->where('assign_otp', $request->otp)->first();
          if(!empty($checkbooking)) {
          
              Booking::where('booking_id',$request->booking_id)->update(['status' => 5]);
              helper::arrive_handyman_noti($checkbooking->provider_id, $checkbooking->booking_id);
              return response()->json(['status'=>1,'message'=>trans('Photografer Arrived Successfully')],200);
          } else {
              return response()->json(['status'=>0,'message'=>trans('Please enter your correct otp.')],200);;
          }
      } else if($request->type == 'complete') {
          $checkbooking = Booking::where('booking_id',$request->booking_id)->where('handyman_id',$request->handyman_id)->where('status', 5)->where('handyman_accept',1)->where('completed_otp', $request->otp)->first();
          if(!empty($checkbooking)) {
              Booking::where('booking_id',$request->booking_id)->update(['status' => 3]);
              helper::complete_booking_noti($checkbooking->user_id, $request->booking_id, $request->handyman_id);
              return response()->json(['status'=>1,'message'=>trans('Booking Completed Successfully')],200);
          } else {
              return response()->json(['status'=>0,'message'=>trans('Please enter your correct otp.')],200);
          }
      } else {
          $checkbooking = Booking::where('booking_id',$request->booking_id)->where('handyman_id',$request->handyman_id)->where('handyman_accept',1)->first();
          if(!empty($checkbooking)) {
              Booking::where('booking_id',$request->booking_id)->update(['status' => 6]);
              return response()->json(['status'=>1,'message'=>trans('Not Available Successfully')],200);
          } else{
              return response()->json(['status'=>0,'message'=>trans('Not Available Not found')],200);
          }
      }
      
      
      
      
   }
}