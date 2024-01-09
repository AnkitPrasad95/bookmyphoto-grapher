<?php
namespace App\Helpers;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use App\Models\Payout;
use App\Models\Category;
use App\Models\City;
use App\Models\Help;
use App\Models\PaymentMethods;
use App\Models\Booking;
use App\Models\Bank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Str;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;


class helper
{
    public static function push_notification($title,$token,$body)
    {
        $google_api_key = helper::appdata()->firebase_key;
        $msg = array(
            'body'  => $body,
            'title' => $title,
            'sound' => 1/*Default sound*/
        );
        $fields = array(
            'to'            => $token,
            'notification'  => $msg
        );
        $headers = array(
            'Authorization: key=' . $google_api_key,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

        $result = curl_exec ( $ch );
        curl_close ( $ch );

        return $result;
    }
    public static function verificationemail($email, $otp)
    {
        //return 
        $getlogo = Setting::select('logo')->where('id', 1)->first();
        $data = [
            'title' => "Email verification",
            'email' => $email,
            'otp' => $otp,
            'logo' => asset('storage/app/public/images/' . $getlogo->logo)
        ];
        //dd($data);
        try {
            Mail::send('Email.emailverification', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } 
        
        // catch (\Exception $exception) {
        //     // Log the exception for debugging purposes
        //     \Log::error('Email sending error: ' . $exception->getMessage());
        
        //     // Return an error response
        //     return response()->json(['status' => 'error', 'message' => 'Error sending email'], 500);
        // }
        
        catch (\Throwable $th) {
            return "Error: " . $th->getMessage();
            //return 0;
        }
            
    }
    

    
    public static function resendotp($email, $otp)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $data = [
            'title' => "Verification code",
            'email' => $email,
            'otp' => $otp,
            'logo' => asset('storage/app/public/images/' . $getlogo->logo)
        ];
        try {
            Mail::send('Email.emailverification', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function forgotpassword($email, $name, $password)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $data = [
            'title' => trans('messages.password_reset'),
            'email' => $email,
            'name' => $name,
            'password' => $password,
            'logo' => asset('storage/app/public/images/' . $getlogo->logo)
        ];
        try {
            Mail::send('Email.email', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function create_booking($bid)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $bookingdata = Booking::where('booking_id',$bid)->first();
        $userdata = User::where('id',$bookingdata->user_id)->first();
        $title = trans('messages.accept_booking');
        $app_name = trans('labels.app_name');
        $logo = asset('storage/app/public/images/'.$getlogo->logo);
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'email' => $userdata->email,
            'name' => $userdata->name,
            'logo' => $logo,
            'bid' => $bookingdata->booking_id,
        ];
        try {
            Mail::send('Email.create_booking', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function accept_booking($bid)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $bookingdata = Booking::where('id',$bid)->first();
        $userdata = User::where('id',$bookingdata->user_id)->first();
        $title = trans('messages.accept_booking');
        $app_name = trans('labels.app_name');
        $logo = asset('storage/app/public/images/'.$getlogo->logo);
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'date' => $bookingdata->date,
            'email' => $userdata->email,
            'name' => $userdata->name,
            'logo' => $logo,
            'bid' => $bookingdata->booking_id,
        ];
        try {
            Mail::send('Email.accept_booking', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function assign_handyman($bid)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $bookingdata = Booking::where('id',$bid)->first();
        $userdata = User::where('id',$bookingdata->user_id)->first();
        $handymandata = User::where('id',$bookingdata->handyman_id)->first();
        $title = trans('messages.assign_handyman');
        $app_name = trans('labels.app_name');
        $logo = asset('storage/app/public/images/'.$getlogo->logo);
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'date' => $bookingdata->date,
            'email' => $userdata->email,
            'name' => $userdata->name,
            'handyman_name' => $handymandata->name,
            'handyman_email' => $handymandata->email,
            'handyman_mobile' => $handymandata->mobile,
            'logo' => $logo,
            'bid' => $bookingdata->booking_id,
        ];
        try {
            Mail::send('Email.assign_handyman', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function complete_booking($bid)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $bookingdata = Booking::where('id',$bid)->first();
        $userdata = User::where('id',$bookingdata->user_id)->first();
        $title = trans('messages.accept_booking');
        $app_name = trans('labels.app_name');
        $logo = asset('storage/app/public/images/'.$getlogo->logo);
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'date' => $bookingdata->date,
            'email' => $userdata->email,
            'name' => $userdata->name,
            'logo' => $logo,
            'bid' => $bookingdata->booking_id,
        ];
        try {
            Mail::send('Email.complete_booking', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function cancel_booking($bid)
    {
        $getlogo = Setting::select('logo')->where('id', '=', '1')->first();
        $bookingdata = Booking::where('id',$bid)->first();
        $userdata = User::where('id',$bookingdata->user_id)->first();
        $title = trans('messages.cancel_booking');
        $app_name = trans('labels.app_name');
        $logo = asset('storage/app/public/images/'.$getlogo->logo);
        if($bookingdata->canceled_by == 1){
            $description = "Your Booking ".$bookingdata->booking_id." has been cancelled By Admin.";
        }else{
            $description = "Your Booking ".$bookingdata->booking_id." has been cancelled by You.";
        }
        $data = [
            'title' => $title,
            'app_name' => $app_name,
            'date' => $bookingdata->date,
            'email' => $userdata->email,
            'name' => $userdata->name,
            'logo' => $logo,
            'description' => $description,
        ];
        try {
            Mail::send('Email.cancel_booking', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    // Booking notification
    public static function create_booking_noti($user_id,$provider_id,$booking_id)
    {
        $title = "Booking Created";
        $message = "Booking ".$booking_id." has been created";

        // for user
        $user_noti = new Notification();
        $user_noti->user_id = $user_id;
        $user_noti->title = $title;
        $user_noti->message = $message;
        $user_noti->booking_id = $booking_id;
        $user_noti->booking_status = 1;
        $user_noti->is_read = 2;
        $user_noti->save();
        
        // for provider
        $noti = new Notification();
        $noti->user_id = $provider_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 1;
        $noti->is_read = 2;
        $noti->save();

        $checkuser = User::find($user_id);
        helper::push_notification($title,$checkuser->token,$message);
        $checkprovider = User::find($provider_id);
        helper::push_notification($title,$checkprovider->token,$message);
    }
    public static function accept_booking_noti($user_id,$handyman_id,$booking_id)
    {
        $user_title = "Booking Accepted";
        $user_message = "Booking ".$booking_id." has been accepted.";
        $checkuser = User::find($user_id);
        helper::push_notification($user_title,$checkuser->token,$user_message);

        $noti = new Notification();
        $noti->user_id = $user_id;
        $noti->title = $user_title;
        $noti->message = $user_message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 2;
        $noti->is_read = 2;
        $noti->save();
        if($handyman_id != ""){
            // common created for API side-accept booking by provider from ServiceProvider:providerApp

            $checkhandyman = User::find($handyman_id);
            $title = "Booking Assigned";
            
            // for user
            $user_message = "Booking ".$booking_id." has been assigned to photographer.";
            helper::push_notification($title,$checkuser->token,$user_message);
            
            // for handyman
            $handyman_message = "Booking ".$booking_id." has been assigned to you.";
            helper::push_notification($title,$checkhandyman->token,$handyman_message);

            $noti = new Notification();
            $noti->user_id = $handyman_id;
            $noti->title = $title;
            $noti->message = $handyman_message;
            $noti->booking_id = $booking_id;
            $noti->booking_status = 2;
            $noti->is_read = 2;
            $noti->save();
        }
    }
    public static function assign_handyman_noti($handyman_id,$booking_id)
    {
        $checkbooking = Booking::where('booking_id',$booking_id)->first();

        $checkuser = User::find($checkbooking->user_id);
        $checkhandyman = User::find($handyman_id);
        $title = "Booking Assigned";
        
        // for user
        $user_message = "Booking ".$booking_id." has been assigned to Photographer.";
        helper::push_notification($title,$checkuser->token,$user_message);
        
        // for handyman
        $handyman_message = "Booking ".$booking_id." has been assigned to you.";
        helper::push_notification($title,$checkhandyman->token,$handyman_message);

        $noti = new Notification();
        $noti->user_id = $handyman_id;
        $noti->title = $title;
        $noti->message = $handyman_message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 2;
        $noti->is_read = 2;
        $noti->save();
    }
    public static function complete_booking_noti($user_id,$booking_id)
    {
        $checkbooking = Booking::where('booking_id',$booking_id)->first();
        $checkprovider = User::find($checkbooking->provider_id);

        $checkuser = User::find($user_id);
        $title = "Booking Competed";
        $message = "Booking ".$booking_id." has been completed";

        if($checkbooking->handyman_id != ""){
            $checkhandyman = User::find($checkbooking->handyman_id);
            helper::push_notification($title,$checkhandyman->token,$message);
        }
        helper::push_notification($title,$checkuser->token,$message);
        helper::push_notification($title,$checkprovider->token,$message);

        $noti = new Notification();
        $noti->user_id = $user_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 3;
        $noti->is_read = 2;
        $noti->save();
    }
    public static function cancel_booking_noti($user_id,$booking_id,$cancelled_by)
    {
        $title = "Booking Canceled";
        $message = "Booking ".$booking_id." has been cancelled";

        $noti = new Notification();
        $noti->user_id = $user_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 4;
        $noti->canceled_by = $cancelled_by;
        $noti->is_read = 2;
        $noti->save();

        $checkuser = User::find($user_id);
        helper::push_notification($title,$checkuser->token,$message);

        $checkbooking = Booking::where('booking_id',$booking_id)->first();
        $checkprovider = User::find($checkbooking->provider_id);
        helper::push_notification($title,$checkprovider->token,$message);
    }
    public static function handyman_booking_action_noti($provider_id,$booking_id,$action)
    {
        $title = "";
        $message = "";
        if($action == "accept"){
            $title = "Booking Accepted";
            $message = "Booking ".$booking_id." has been accepted by photographer";
        }
        if($action == "reject"){
            $title = "Booking Rejected";
            $message = "Booking ".$booking_id." has been rejected by photographer";
        }
        $noti = new Notification();
        $noti->user_id = $provider_id;
        $noti->title = $title;
        $noti->message = $message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 2;
        $noti->is_read = 2;
        $noti->save();

        $checkprovider = User::find($provider_id);
        helper::push_notification($title,$checkprovider->token,$message);
    }
    
    public static function arrive_handyman_noti($handyman_id,$booking_id)
    {
        $checkbooking = Booking::where('booking_id',$booking_id)->first();

        $checkuser = User::find($checkbooking->user_id);
        $checkhandyman = User::find($handyman_id);
        $providerman = User::find($checkbooking->provider_id);
        $title = "Photographer Arrived";
        
        // for user
        $user_message = "Booking ".$booking_id." photographer has been arrived.";
        helper::push_notification($title,$checkuser->token,$user_message);
        
        // for handyman
        $handyman_message = "Booking ".$booking_id." has been arrived to customer.";
        helper::push_notification($title,$providerman->token,$handyman_message);

        $noti = new Notification();
        $noti->user_id = $providerman;
        $noti->title = $title;
        $noti->message = $handyman_message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 5;
        $noti->is_read = 2;
        $noti->save();
    }
    
    public static function customer_not_available_noti($handyman_id,$booking_id)
    {
        $checkbooking = Booking::where('booking_id',$booking_id)->first();

        $checkuser = User::find($checkbooking->user_id);
        $checkhandyman = User::find($handyman_id);
        $providerman = User::find($checkbooking->provider_id);
        $title = "Customer not available";
        
        // for user
        $user_message = "Booking ".$booking_id." has been marked to Customer not available.";
        helper::push_notification($title,$checkuser->token,$user_message);
        
        // for handyman
        $handyman_message = "Booking ".$booking_id." has been marked to Customer not available.";
        helper::push_notification($title,$providerman->token,$handyman_message);

        $noti = new Notification();
        $noti->user_id = $providerman;
        $noti->title = $title;
        $noti->message = $handyman_message;
        $noti->booking_id = $booking_id;
        $noti->booking_status = 6;
        $noti->is_read = 2;
        $noti->save();
    }

    // Other
    public static function date_format($date)
    {
        $date = date('d-m-Y', strtotime($date));
        return $date;
    }
    public static function currency_format($price)
    {
        $currency = Setting::select('currency','currency_position')->first();
        $position = strtolower($currency->currency_position);
        if ($position == "left") {
            return $currency->currency.number_format($price, 2);
        }
        if ($position == "right") {
            return number_format($price, 2).$currency->currency;
        }
    }
    public static function stripe_key()
    {   
        $pmdata = PaymentMethods::select('test_public_key','test_secret_key')->where('payment_name','=','Stripe')->where('is_available',1)->first();
        return $pmdata->test_secret_key;
    }
    public static function wallet()
    {
        $walletdata = User::select('wallet')->where('id',@Auth::user()->id)->first();
        return @$walletdata->wallet;
    }
    public static function payout_request()
    {
        $payout = Payout::where('status',2)->count();
        return $payout;
    }
    public static function appdata()
    {
        $appdata = Setting::first();
        return $appdata;
    }
    public static function categories()
    {
        $categories = Category::select('id','name','slug')->where('is_available',1)->where('is_deleted',2)->orderByDesc('id')->take(5)->get();
        return $categories;
    }
    public static function cities()
    {
        $citydata = City::select('cities.id','cities.name','cities.image')
                    ->where('is_available',1)->where('is_deleted',2)
                    ->orderBy('name')
                    ->get();
        return $citydata;
    }
    public static function check_bank()
    {   
        if(Auth::user()->type == 2){
            $check_bank = Bank::where('provider_id', Auth::user()->id)->count();
            return $check_bank;
        }else{
            return 1;
        }
    }
    public static function booking()
    {
        $booking = Booking::where('status', 1)
                            ->where(function ($query) {
                                $query->Where('provider_id', '=', Auth::user()->id)
                                   ->orWhere('user_id', '=', Auth::user()->id);
                                })
                             ->count();
        return $booking;
    }
    public static function notification()
    {
        $notification = Notification::where('user_id',@Auth::user()->id)->where('is_read', 2)->count();
        return $notification;
    }
    public static function help()
    {
        $help = Help::where('status',2)->count();
        return $help;
    }
    public static function image_path($image)
    {
        $path = asset('storage/app/public/images/not-found.png');
        
        if(Str::contains($image, 'category')){
            $path = asset('storage/app/public/category/'.$image);
        }
        if(Str::contains($image, 'city')){
            $path = asset('storage/app/public/city/'.$image);
        }
        if(Str::contains($image, 'provider')){
            $path = asset('storage/app/public/provider/'.$image);
        }
        if(Str::contains($image, 'handyman')){
            $path = asset('storage/app/public/handyman/'.$image);
        }
        if(Str::contains($image, 'service') || Str::contains($image, 'gallery')){
            $path = asset('storage/app/public/service/'.$image);
        }
        if(Str::contains($image, 'profile')){
            $path = asset('storage/app/public/profile/'.$image);
        }
        if(Str::contains($image, 'banners-')){
            $path = asset('storage/app/public/banner/'.$image);
        }
        if(Str::contains($image, 'cancel') ||Str::contains($image, 'confirmed') ||Str::contains($image, 'pending') || Str::contains($image, 'wallet1') || Str::contains($image, 'creditcard') || Str::contains($image, 'COD') || Str::contains($image, 'default') || Str::contains($image, 'icon') || Str::contains($image, 'about-') || Str::contains($image, 'logo') || Str::contains($image, 'banner-') || Str::contains($image, 'favicon') || Str::contains($image, 'og')){
            $path = asset('storage/app/public/images/'.$image);
        }

        return $path;   
    }
    
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
      if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
      }
      else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
    
        if ($unit == "K") {
          return ceil(($miles * 1.609344));
        } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
          return $miles;
        }
      }
    }
    //echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
    
    
}
