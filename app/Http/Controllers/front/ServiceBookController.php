<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Provider;
use App\Models\Handyman;
use App\Models\User;
use App\Models\Timing;
use App\Models\Booking;
use App\Models\Rattings;
use App\Models\Coupons;
use App\Models\Aboutus;
use App\Models\BookingAddress;
use App\Models\City;
use App\Models\Transaction;
use App\Models\Notification;
use App\Models\GalleryImages;
use App\Models\PaymentMethods;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Purifier;
use Response;
use Helper;
use Stripe;
use App\Http\Controllers\EmailSendController;

class ServiceBookController extends Controller
{
        public function book(Request $request)
        {
            //return $request->input();
                $booking_id = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);

                
                if (is_numeric($request->service)) {
                     $checkservice = Service::where('id', $request->service)->where('is_available', 1)->where('is_deleted', 2)->first();
                     //dd($checkservice);

                    $checkprovider = User::where('id', $checkservice->provider_id)->first();
                    
                    $service_id = $request->service;
                    $price_type = $checkservice->price_type;
                    $price = $checkservice->price;
                    $duration_type = $checkservice->duration_type;
                    $serviceName= $checkservice->name;
                    $image = $checkservice->image;
                    $handyman_id = '';
                    $duration = ($request->total_price+$request->discount)/$price;
                    $status = 1;
                    
                    
                    
                    
                } else {
                    $array = explode("_", $request->service);
                    //dd($array);
                    $checkservice = User::where('id', $array[1])->where('is_available', 1)->first();
                    //dd($checkservice);
                    $checkprovider = User::where('id', $checkservice->provider_id)->first();
                    
                    //dd($checkservice);
                    $service_id = '';
                    $price_type = 'Hourly';
                    $price = $checkservice->booking_price;
                    $duration_type = 2;
                    $serviceName = "Instant Booking";
                    $image = $checkservice->image;
                    $handyman_id =  $array[1];
                    $duration = ($request->total_price+$request->discount)/$price;
                    $status = 2;
                    
                }
                //dd($duration);
                //die;
               

                if ($request->payment_type == 2) {

                        $getuserdata = User::where('id', $request->user_id)->get()->first();
                        if ($getuserdata->wallet < $request->total_price) {
                                return response()->json(["status" => 0, "message" => trans('messages.low_balance')], 200);
                        } else {
                                $wallet = $getuserdata->wallet - $request->total_price;

                                $updateuserwallet = User::where('id', $request->user_id)->update(['wallet' => $wallet]);

                                $transaction = new Transaction;
                                $transaction->user_id = $request->user_id;
                                $transaction->service_id = $service_id;
                                $transaction->provider_id = $checkservice->provider_id;
                                $transaction->booking_id = $booking_id;
                                $transaction->amount = $request->total_price;
                                $transaction->payment_type = 2;
                                $transaction->save();
                        }
                }
                if ($request->payment_type == 3 || $request->payment_type == 5 || $request->payment_type == 6) {

                        $payment_id = $request->payment_id;
                }
                if ($request->payment_type == 4) {

                        Stripe\Stripe::setApiKey(Helper::stripe_key());
                        $payment = Stripe\Charge::create([
                                "amount" => $request->total_price * 100,
                                "currency" => "inr",
                                "source" => $request->stripeToken,
                                "description" => "Test payment description.",
                        ]);
                        $payment_id = $payment->id;
                }
                $note = strip_tags(Purifier::clean($request->booking_notes));
                $booking = new Booking();
                $booking->booking_id = $booking_id;
                $booking->service_id = $service_id;
                $booking->address_id = $request->address_id;
                $booking->service_name = $serviceName;
                $booking->service_image = $image;
                $booking->price = $price;
                $booking->price_type = $price_type;
                $booking->duration = $duration;
                $booking->duration_type = $duration_type;
                $booking->provider_id = $checkservice->provider_id;
                $booking->provider_name = $checkprovider->name;
                $booking->handyman_id = $handyman_id;
                $booking->status = $status;
                $booking->date = $request->date;
                $booking->time = $request->time;
                if (Storage::exists('photographer_id')) {
                        $booking->coupon_code = $request->coupon_code;
                        $booking->discount = $request->discount;
                }
                if (Storage::exists('service_id')) {
                        $booking->coupon_code = $request->coupon_code;
                        $booking->discount = $request->discount;
                }
                $booking->user_id = $request->user_id;
                $booking->address = $request->fullname . ", " . $request->email . ", " . $request->mobile . ", " . $request->street . ", " . $request->landmark . ", " . $request->postcode;
                $booking->payment_type = $request->payment_type;
                if ($request->payment_type != "1" && $request->payment_type != "2") {
                        $booking->transaction_id = $payment_id;
                }
                $booking->note = $note;
                $booking->total_amt = $request->total_price;
                //dd($booking);
                if ($booking->save()) {

                        if (Storage::exists('photographer_id')) {
                                Storage::disk('local')->delete("photographer_id");
                        }
                        if (Storage::exists('coupon_code')) {
                                Storage::disk('local')->delete("coupon_code");
                        }
                        if (Storage::exists('total_discount')) {
                                Storage::disk('local')->delete("total_discount");
                        }
                        if (Storage::exists('discount_type')) {
                                Storage::disk('local')->delete("discount_type");
                        }
                        if (Storage::exists('service')) {
                                Storage::disk('local')->delete("service");
                        }
                        if (Storage::exists('total_price')) {
                                Storage::disk('local')->delete("total_price");
                        }

                        //$helper = helper::create_booking($booking->booking_id);
                        $helper = EmailSendController::create_booking($booking->booking_id);
                        //dd($helper);

                        if ($helper == 1) {
                                helper::create_booking_noti($booking->user_id, $booking->provider_id, $booking->booking_id);
                                return Response::json(['status' => 1, 'message' => $request->input()], 200);
                        } else {
                                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
                        }
                } else {
                        return Response::json(['status' => 0, 'message' => trans('messages.wrong')], 200);
                }
        }

        public function cancel(Request $request)
        {
                if ($request->booking_id != "") {

                        $bdata = Booking::where('booking_id', $request->booking_id)->first();

                        if (!empty($bdata)) {

                                if ($bdata->status == 2) {
                                        return response()->json(['status' => 0, 'message' => trans('messages.accepted_by_provider')], 200);
                                } elseif ($bdata->status == 4) {
                                        return response()->json(['status' => 0, 'message' => trans('messages.cancelled_by_provider')], 200);
                                } else {
                                        //$helper = helper::cancel_booking($bdata->id);
                                        $helper = EmailSendController::cancel_booking($bdata->id);
                                        if ($helper == 1) {
                                                if ($bdata->payment_type != 1 && $bdata->payment_type != 2) {
                                                        $wallet = Auth::user()->wallet + $bdata->total_amt;

                                                        $updateuserwallet = User::where('id', Auth::user()->id)->update(['wallet' => $wallet]);

                                                        $transaction = new Transaction;
                                                        $transaction->user_id = Auth::user()->id;
                                                        $transaction->service_id = $bdata->service_id;
                                                        $transaction->provider_id = $bdata->provider_id;
                                                        $transaction->booking_id = $bdata->booking_id;
                                                        $transaction->transaction_id = $bdata->transaction_id;
                                                        $transaction->amount = $bdata->total_amt;
                                                        $transaction->payment_type = 1;
                                                        $transaction->save();
                                                }
                                                $success = Booking::where('booking_id', $request->booking_id)->update(['status' => 4, 'canceled_by' => 2]);
                                                helper::cancel_booking_noti(Auth::user()->id, $request->booking_id, $request->canceled_by);
                                                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
                                        } else {
                                                return response()->json(['status' => 0, 'message' => trans('messages.wrong_while_email')], 200);
                                        }
                                }
                        } else {
                                return 0;
                        }
                } else {
                        return 0;
                }
        }
        public function stripe_pay(Request $request)
        {
                // dd($request->input());
                Stripe\Stripe::setApiKey("sk_test_51HVsZRLKgWGtoXaz2VWYK0XT4FjOinBELkdjMuEMoBVYChCu3lUUmhv9o6FtbAQhWdyOMANwkDyXzxW8KmtrFNiQ009xR3GbaZ");
                $payment = Stripe\Charge::create([
                        "amount" => 1000 * 100,
                        "currency" => "inr",
                        "source" => $request->stripeToken,
                        "description" => "Test payment description.",
                ]);
                dd($payment);
                return back();
        }
        public function checkout($service)
        {
                if (isset($_COOKIE["city_name"])) {
                        $servicedata = Service::with('rattings')
                                ->join('categories', 'services.category_id', '=', 'categories.id')
                                ->join('users', 'services.provider_id', '=', 'users.id')
                                ->select(
                                        'services.id as service_id',
                                        'services.name as service_name',
                                        'services.price',
                                        'services.price_type',
                                        'services.description',
                                        'services.discount',
                                        'services.duration',
                                        DB::raw("CONCAT('" . asset('application/storage/app/public/service') . "/', services.image) AS service_image")
                                )
                                ->where('services.slug', $service)
                                ->where('services.is_available', 1)
                                ->where('services.is_deleted', 2)
                                ->first();
                        $addressdata = BookingAddress::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
                        $paymethods = PaymentMethods::where('is_available', 1)->orderBy('id')->get();
                } else {
                        $servicedata = "";
                        $addressdata = "";
                        $paymethods = "";
                }
                return view("front.checkout", compact('addressdata', 'servicedata', 'paymethods'));
        }
        public function remove_coupon()
        {
                if (Storage::exists('service_id')) {
                        Storage::disk('local')->delete("service_id");
                }
                if (Storage::exists('coupon_code')) {
                        Storage::disk('local')->delete("coupon_code");
                }
                if (Storage::exists('total_discount')) {
                        Storage::disk('local')->delete("total_discount");
                }
                if (Storage::exists('discount_type')) {
                        Storage::disk('local')->delete("discount_type");
                }
                if (Storage::exists('service')) {
                        Storage::disk('local')->delete("service");
                }
                if (Storage::exists('total_price')) {
                        Storage::disk('local')->delete("total_price");
                }
                return redirect()->back()->with('success', trans('messages.success'));
        }
        
        
        // public function check_coupon(Request $request, $service)
        // {
        //         $validator = Validator::make(
        //                 $request->all(),
        //                 ['coupon' => 'required',],
        //                 ['coupon.required' => trans('messages.enter_coupon')]
        //         );
        //         if ($validator->fails()) {
        //                 return redirect()->back()->withErrors($validator)->withInput();
        //         } else {
        //                 $sdata = Service::where('slug', $service)->first();

        //                 $checkcoupon = Coupons::where('service_id', $sdata->id)
        //                         ->where('code', $request->coupon)
        //                         ->where('is_available', 1)
        //                         ->where('is_deleted', 2)
        //                         ->first();

        //                 if (!empty($checkcoupon)) {
        //                         if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
        //                                 Storage::disk('local')->put("service_id", $sdata->id);
        //                                 Storage::disk('local')->put("coupon_code", $checkcoupon->code);
        //                                 Storage::disk('local')->put("discount", $checkcoupon->discount);
        //                                 Storage::disk('local')->put("discount_type", $checkcoupon->discount_type);

        //                                 return redirect()->back()->with('success', trans('messages.success'))->withInput();
        //                         } else {
        //                                 return redirect()->back()->with('error', trans('messages.coupon_expired'));
        //                         }
        //                 } else {
        //                         return redirect()->back()->with('error', trans('messages.not_for_this_service'));
        //                 }
        //         }
        // }
        
        
        public function check_coupon(Request $request, $service)
        {
            //echo $service;
            //dd($request->input());
                $validator = Validator::make(
                        $request->all(),
                        ['coupon' => 'required',],
                        ['coupon.required' => trans('messages.enter_coupon')]
                );
                if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                } else {
                        
                        $sdata = Service::where('slug', $service)->first();
                        $studiodata = User::where('id', $request->input('studio_id'))->first();
        
                        $checkcoupon = Coupons::where('studio_id', $studiodata->id)
                                ->where('code', $request->coupon)
                                ->where('is_available', 1)
                                ->where('is_deleted', 2)
                                ->first();
                        //dd($checkcoupon);   
                        // echo "<pre>";
                        // print_r($checkcoupon->toArray());
                        // echo "</pre>";
                        // die;
                        if (!empty($checkcoupon)) {
                            if($checkcoupon->type == 'all' && ($checkcoupon->service_id == 0 || $checkcoupon->service_id <=0)) {
                                //echo "For All Photografer and service"; die;
                                if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                                    Storage::disk('local')->put("service_id", $sdata->id);
                                    Storage::disk('local')->put("coupon_code", $checkcoupon->code);
                                    Storage::disk('local')->put("discount", $checkcoupon->discount);
                                    Storage::disk('local')->put("discount_type", $checkcoupon->discount_type);
        
                                    return redirect()->back()->with('success', trans('messages.success'))->withInput();
                                } else {
                                        return redirect()->back()->with('error', trans('messages.coupon_expired'));
                                }
                            } 
                            
                            else if($checkcoupon->type == 'service' && ($checkcoupon->service_id == 0 || $checkcoupon->service_id <=0)) {
                                //echo "For All Service"; die;
                                if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                                    Storage::disk('local')->put("service_id", $sdata->id);
                                    Storage::disk('local')->put("coupon_code", $checkcoupon->code);
                                    Storage::disk('local')->put("discount", $checkcoupon->discount);
                                    Storage::disk('local')->put("discount_type", $checkcoupon->discount_type);
        
                                    return redirect()->back()->with('success', trans('messages.success'))->withInput();
                                } else {
                                        return redirect()->back()->with('error', trans('messages.coupon_expired'));
                                }
                            } 
                            
                            else if($checkcoupon->type == 'service' && $checkcoupon->service_id > 0) {
                                //echo "For Single ".$service; die;
                                if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                                    Storage::disk('local')->put("service_id", $sdata->id);
                                    Storage::disk('local')->put("coupon_code", $checkcoupon->code);
                                    Storage::disk('local')->put("discount", $checkcoupon->discount);
                                    Storage::disk('local')->put("discount_type", $checkcoupon->discount_type);
        
                                    return redirect()->back()->with('success', trans('messages.success'))->withInput();
                                } else {
                                        return redirect()->back()->with('error', trans('messages.coupon_expired'));
                                }
                                
                            }  
                            else {
                                return redirect()->back()->with('error', trans('messages.not_for_this_photografer'));
                            }
                            
                            
                               
                        } else {
                                return redirect()->back()->with('error', trans('messages.not_for_this_photografer'));
                        }
                }
        }
        public function continue_booking($service)
        {
                if (isset($_COOKIE["city_name"])) {
                        $servicedata = Service::with('rattings')
                                ->join('categories', 'services.category_id', '=', 'categories.id')
                                ->join('users', 'services.provider_id', '=', 'users.id')
                                ->select('services.id as service_id', 'services.name as service_name', 'services.price', 'services.duration_type', 'services.price_type', 'services.description', 'services.discount', 'services.duration', 'services.slug', 'services.image as service_image', 'categories.id as category_id', 'categories.name as category_name', 'services.provider_id as porvider_id', 'users.name as provider_name', 'users.image as provider_image')
                                ->where('services.slug', $service)
                                ->where('services.is_available', 1)
                                ->where('services.is_deleted', 2)
                                ->first();
                } else {
                        $servicedata = "";
                }
                return view('front.continue_booking', compact('servicedata'));
        }
        public function stripe_form()
        {
                return view('front.stripe_form');
        }
        public function success()
        {
                return view('front.booking_success');
        }
        
        public function continue_instant_booking($photographer)
        {
                if (isset($_COOKIE["city_name"])) {
                    
                        $instantBooking = User::select('users.id', 'users.name', 'users.slug', 'users.email', 'users.mobile', 'users.image', 'users.address', 
                        'users.description', 'users.booking_price', 'users.provider_id', 'users.photographer_lat', 'users.photographer_long')
                        ->where('users.type', 3)
                        ->where('users.slug', $photographer)
                        //->orderBy('users.id', 'desc')
                        ->first();
                        
                        $providerData = User::select('id as studioId', 'name as studioName', 'slug as studioSlug', 'provider_type', 'image as studioImage', 'verified_flag', 'available_status', 'latitude', 'longitude')->where('id', $instantBooking->provider_id)->where('available_status', 1)->first();
                        
                         $photographerData = [
                        'photographer_id' => $instantBooking->id,
                        'photographer_name' => $instantBooking->name,
                        'photographer_slug' => $instantBooking->slug,
                        'photographer_image' => $instantBooking->image,
                        'photographer_mobile' => $instantBooking->mobile,
                        'photographer_description' => $instantBooking->description,
                        'photographer_lat' => $instantBooking->photographer_lat,
                        'photographer_long' => $instantBooking->photographer_long,
                        'studioId' => $providerData->studioId,
                        'studioName' => $providerData->studioName,
                        'studioSlug' => $providerData->studioSlug,
                        'studioImage' => $providerData->studioImage,
                        'verified_flag' => $providerData->verified_flag,
                        'available_status' => $providerData->available_status,
                        'latitude' => $providerData->latitude,
                        'longitude' => $providerData->longitude,
                        'provider_type' => $providerData->provider_type,
                        'booking_price' => $instantBooking->booking_price,
                        ];
                } else {
                        $photographerData = "";
                }
                //dd($photographerData);
                return view('front.continue_instant_booking', compact('photographerData'));
        }
        
        public function checkout_instant($photographer)
        {
                if (isset($_COOKIE["city_name"])) {
                        // $servicedata = Handyman::with('rattings')
                        //         ->join('Provider', 'services.category_id', '=', 'Provider.id')
                        //         ->join('users', 'services.provider_id', '=', 'users.id')
                        //         ->select(
                        //                 'services.id as service_id',
                        //                 'services.name as service_name',
                        //                 'services.price',
                        //                 'services.price_type',
                        //                 'services.description',
                        //                 'services.discount',
                        //                 'services.duration',
                        //                 DB::raw("CONCAT('" . asset('application/storage/app/public/service') . "/', services.image) AS service_image")
                        //         )
                        //         ->where('services.slug', $service)
                        //         ->where('services.is_available', 1)
                        //         ->where('services.is_deleted', 2)
                        //         ->first();
                        
                         $instantBooking = User::select('users.id', 'users.name', 'users.slug', 'users.email', 'users.mobile', 'users.image', 'users.address', 
                        'users.description', 'users.booking_price', 'users.provider_id', 'users.photographer_lat', 'users.photographer_long')
                        ->where('users.type', 3)
                        ->where('users.slug', $photographer)
                        
                        ->first();
                        
                        $providerData = User::select('id as studioId', 'name as studioName', 'slug as studioSlug', 'provider_type', 'image as studioImage', 'verified_flag', 'available_status', 'latitude', 'longitude')->where('id', $instantBooking->provider_id)->where('available_status', 1)->first();
                        
                         $photographerData = [
                        'photographer_id' => $instantBooking->id,
                        'photographer_name' => $instantBooking->name,
                        'photographer_slug' => $instantBooking->slug,
                        'photographer_image' => $instantBooking->image,
                        'photographer_mobile' => $instantBooking->mobile,
                        'photographer_description' => $instantBooking->description,
                        'photographer_lat' => $instantBooking->photographer_lat,
                        'photographer_long' => $instantBooking->photographer_long,
                        'studioId' => $providerData->studioId,
                        'studioName' => $providerData->studioName,
                        'studioSlug' => $providerData->studioSlug,
                        'studioImage' => $providerData->studioImage,
                        'verified_flag' => $providerData->verified_flag,
                        'available_status' => $providerData->available_status,
                        'latitude' => $providerData->latitude,
                        'longitude' => $providerData->longitude,
                        'provider_type' => $providerData->provider_type,
                        'booking_price' => $instantBooking->booking_price,
                        ];
                        
                        $addressdata = BookingAddress::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
                        $paymethods = PaymentMethods::where('is_available', 1)->orderBy('id')->get();
                } else {
                        $photographerData = "";
                        $addressdata = "";
                        $paymethods = "";
                }
                return view("front.instant-checkout", compact('photographerData', 'addressdata', 'paymethods'));
        }
        
        public function check_instant_coupon(Request $request, $photographer)
        {
            // echo $photographer;
            // dd($request->input());
                $validator = Validator::make(
                        $request->all(),
                        ['coupon' => 'required',],
                        ['coupon.required' => trans('messages.enter_coupon')]
                );
                if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                } else {
                        
                        $sdata = User::where('slug', $photographer)->first();
                        $studiodata = User::where('id', $request->input('studio_id'))->first();

                        $checkcoupon = Coupons::where('studio_id', $studiodata->id)
                                ->where('code', $request->coupon)
                                ->where('is_available', 1)
                                ->where('is_deleted', 2)
                                ->first();
                        //dd($checkcoupon);   
                        // echo "<pre>";
                        // print_r($checkcoupon->toArray());
                        // echo "</pre>";
                        //die;
                        if (!empty($checkcoupon)) {
                            if($checkcoupon->type == 'all' && ($checkcoupon->photographer_id == 0 || $checkcoupon->photographer_id <=0)) {
                                //echo "For All Photografer and service"; die;
                                 if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                                        Storage::disk('local')->put("photographer_id", $sdata->id);
                                        Storage::disk('local')->put("ins_coupon_code", $checkcoupon->code);
                                        Storage::disk('local')->put("ins_discount", $checkcoupon->discount);
                                        Storage::disk('local')->put("ins_total_discount", $checkcoupon->discount);
                                        Storage::disk('local')->put("ins_discount_type", $checkcoupon->discount_type);

                                        return redirect()->back()->with('success', trans('messages.success'))->withInput();
                                } else {
                                        return redirect()->back()->with('error', trans('messages.coupon_expired'));
                                }
                            } 
                            
                            else if($checkcoupon->type == 'photographer' && ($checkcoupon->photographer_id == 0 || $checkcoupon->photographer_id <=0)) {
                                //echo "For All Photografer"; die;
                                 if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                                        Storage::disk('local')->put("photographer_id", $sdata->id);
                                        Storage::disk('local')->put("ins_coupon_code", $checkcoupon->code);
                                        Storage::disk('local')->put("ins_discount", $checkcoupon->discount);
                                        Storage::disk('local')->put("ins_total_discount", $checkcoupon->discount);
                                        Storage::disk('local')->put("ins_discount_type", $checkcoupon->discount_type);

                                        return redirect()->back()->with('success', trans('messages.success'))->withInput();
                                } else {
                                        return redirect()->back()->with('error', trans('messages.coupon_expired'));
                                }
                            } 
                            
                            else if($checkcoupon->type == 'photographer' && $checkcoupon->photographer_id > 0) {
                                //echo "For Single ".$photographer; die;
                                 if ((date('Y-m-d') >= $checkcoupon->start_date) && (date('Y-m-d') <= $checkcoupon->expire_date)) {
                                        Storage::disk('local')->put("photographer_id", $sdata->id);
                                        Storage::disk('local')->put("ins_coupon_code", $checkcoupon->code);
                                        Storage::disk('local')->put("ins_discount", $checkcoupon->discount);
                                        Storage::disk('local')->put("ins_total_discount", $checkcoupon->discount);
                                        Storage::disk('local')->put("ins_discount_type", $checkcoupon->discount_type);

                                        return redirect()->back()->with('success', trans('messages.success'))->withInput();
                                } else {
                                        return redirect()->back()->with('error', trans('messages.coupon_expired'));
                                }
                                
                            }  
                            else {
                                return redirect()->back()->with('error', trans('messages.not_for_this_photografer'));
                            }
                            
                            
                               
                        } else {
                                return redirect()->back()->with('error', trans('messages.not_for_this_photografer'));
                        }
                }
        }
        
        public function remove_coupon_instant()
        {
                if (Storage::exists('photographer_id')) {
                        Storage::disk('local')->delete("photographer_id");
                }
                if (Storage::exists('ins_coupon_code')) {
                        Storage::disk('local')->delete("ins_coupon_code");
                }
                if (Storage::exists('ins_total_discount')) {
                        Storage::disk('local')->delete("ins_total_discount");
                }
                if (Storage::exists('ins_discount_type')) {
                        Storage::disk('local')->delete("ins_discount_type");
                }
                if (Storage::exists('ins_total_price')) {
                        Storage::disk('local')->delete("ins_total_price");
                }
                return redirect()->back()->with('success', trans('messages.success'));
        }
}
