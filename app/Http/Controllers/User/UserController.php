<?php
namespace App\Http\Controllers\User;
use App\Helpers\helper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailSendController;
use App\Models\City;
use App\Models\ProviderType;
use App\Models\User;
use App\Models\Rattings;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Timing;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Purifier;
use Str;
use Session;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    public function register_user()
    {
        if(isset($_COOKIE['city_name'])){
            return view('front.user_form');
        }
    }
    public function store_user(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|unique:users,mobile|digits:10',
            'address' => 'required',
        ],  [ 
            'firstname.required' => trans('messages.enter_firstname'),
            'lastname.required' => trans('messages.enter_lastname'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.valid_email'),
            'email.unique' => trans('messages.email_exist'),
            'mobile.required' => trans('messages.enter_mobile'),
            'address.required' => trans('messages.enter_address')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if(Session::has('google_id') || Session::has('facebook_id')){
                $password = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
            }else{
                $validator = Validator::make($request->all(),
                    ['password' => 'required',],
                    ['password.required' => trans('messages.enter_password'),]);
        
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $password = $request->password;
                }
            }
            try {
                $otp = rand(100000,999999);
                $user_name = $request->firstname.' '. $request->lastname;
                //$helper = helper::verificationemail($request->email,$otp);
                $helper = EmailSendController::emailVerification($request->email,$otp,$user_name);
                //dd($helper);
                if($helper == 1){
                    if(Session::get('google_id')){
                        $login_type = "google";
                    }elseif(Session::get('facebook_id')){
                        $login_type = "facebook";
                    }else{
                        $login_type = "email";
                    }
                    $referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10); 
                    $address = strip_tags(Purifier::clean($request->address));
                    $user = new User();
                    $user->name = $request->firstname.' '.$request->lastname;
                    $user->slug = Str::slug($request->firstname,'-');
                    $user->email = $request->email;
                    $user->password = Hash::make($password);
                    $user->mobile = $request->mobile;
                    $user->image = "default.png";
                    $user->address = $address;
                    $user->referral_code = $referral_code;
                    // $user->latitude = $request->latitude;
                    // $user->longitude = $request->longitude;
                    $user->latitude = !empty($request->latitude) ? $request->latitude : '';
                    $user->longitude = !empty($request->longitude) ? $request->longitude : '';
                    $user->type = 4;
                    $user->login_type = $login_type;
                    if(Session::get('google_id')){
                        $user->google_id = Session::get('google_id');   
                    }
                    if(Session::get('facebook_id')){
                        $user->facebook_id = Session::get('facebook_id');   
                    }
                    $user->otp = $otp;
                    $user->is_verified = 2;
                    $user->is_available = 1;
                    if($user->save()){
                        if(Session::get('google_id')){
                            Session::forget('google_id');
                            Session::forget('default_email');
                            Session::forget('default_name');
                        }
                        if(Session::get('facebook_id')){
                            Session::forget('facebook_id');
                            Session::forget('default_email');
                            Session::forget('default_name');
                        }
                        if($request->referral_code != ""){
                            $appdata = Setting::first();
                            $checkreferral = User::select('id','name','referral_code','wallet')->where('referral_code',$request->referral_code)->where('is_available',1)->first();
                            if($checkreferral){
                                $refwallet = $checkreferral->wallet + $appdata->referral_amount;
                                $updatewallet = User::where('id',$checkreferral->id)->update(['wallet'=>$refwallet]);
                                $transaction = new Transaction();
                                $transaction->user_id = $checkreferral->id;
                                $transaction->amount = $appdata->referral_amount;
                                $transaction->payment_type = 7;
                                $transaction->username = $request->name;
                                $transaction->save();
                                $updatewallet = User::where('id',$user->id)->update(['wallet'=>$appdata->referral_amount]);
                                $transaction = new Transaction();
                                $transaction->user_id = $user->id;
                                $transaction->amount = $appdata->referral_amount;
                                $transaction->payment_type = 7;
                                $transaction->username = $checkreferral->name;
                                $transaction->save();
                            }else{
                                return redirect()->back()->with('error', trans('messages.invalid_referral'));   
                            }
                        }
                        session(['otpemail' => $request->email]);
                        return redirect(route('verify'))->with('success',trans('messages.success'));
                    }else{
                        return redirect()->back()->with('error', trans('messages.wrong'));
                    }
                }else{
                    return redirect()->back()->with('error', trans('messages.wrong_while_email'));
                }
            } catch (Exception $e) {
                // dd($e->getMessage());
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        }
    }
    public function register_provider()
    {
        $providertypedata = ProviderType::where('is_available',1)->where('is_deleted',2)->get();
        $citydata = City::where('is_available',1)->where('is_deleted',2)->orderBy('name')->get();
        return view('front.provider_form',compact('citydata','providertypedata'));
    }
    public function store_provider(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'mobile' => 'required|digits:10',
            'provider_type' => 'required',
            'city' => 'required',
            'address' => 'required',
        ],  [ 
            'firstname.required' => trans('messages.enter_firstname'),
            'lastname.required' => trans('messages.enter_lastname'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.valid_email'),
            'email.unique' => trans('messages.email_exist'),
            'password.required' => trans('messages.enter_password'),
            'mobile.required' => trans('messages.enter_mobile'),
            'provider_type.required' => trans('messages.select_provider_type'),
            'city.required' => trans('messages.enter_city'),
            'address.required' => trans('messages.enter_address')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $otp = rand(100000,999999);
            $user_name = $request->firstname.' '. $request->lastname;
            //$helper = helper::verificationemail($request->email,$otp);
             $helper = EmailSendController::emailVerification($request->email,$otp, $user_name);
             //dd($helper);
            if($helper == 1){

                if($request->file("image") != ""){
                    $validator = Validator::make($request->all(),
                        ['image' => 'image|mimes:jpeg,jpg,png'],  
                        [ 'image.image' => trans('messages.enter_image_file'),
                        'image.mimes' => trans('messages.valid_image')]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }else{
                        $file = $request->file("image");
                        $fname = 'provider-'.time().".".$file->getClientOriginalExtension();
                        $file->move(storage_path().'/app/public/provider/',$fname);
                        $filename = $fname;
                    }
                }else{
                    $filename  = "default.png";
                }

                $checkslug = User::where('slug',Str::slug($request->name, '-'))->first();
                if($checkslug != ""){
                    $last = User::select('id')->orderByDesc('id')->first();
                    $create = $request->name." ".($last->id+1);
                    $slug =   Str::slug($create,'-');
                }else{
                    $slug = Str::slug($request->name, '-');
                }

                $address = strip_tags(Purifier::clean($request->address));
                $provider = new User();
                $provider->name = $user_name;
                $provider->email = $request->email;
                $provider->password = Hash::make($request->password);
                $provider->mobile = $request->mobile;
                $provider->provider_type = $request->provider_type;
                $provider->image = $filename;
                $provider->address = $address;
                $provider->city_id = json_encode($request->city);
                $provider->type = 2;
                $provider->login_type = "email";
                $provider->otp = $otp;
                $provider->is_verified = 2;
                $provider->is_available = 1;
                $provider->slug = $slug;
                $provider->latitude = !empty($request->latitude) ? $request->latitude : '';
                $provider->longitude = !empty($request->longitude) ? $request->longitude : '';
                
                if($provider->save()){
                    session(['otpemail' => $request->email]);
                    $day = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
                    $open_time = array('9:00am','9:00am','9:00am','9:00am','9:00am','9:00am','9:00am');
                    $close_time= array('6:00pm','6:00pm','6:00pm','6:00pm','6:00pm','6:00pm','6:00pm');

                    foreach($day as $key => $no)
                    {
                        $time = new Timing();
                        $time->provider_id = $provider->id;
                        $time->day = $no;
                        $time->open_time = $close_time[$key];
                        $time->close_time = $close_time[$key];
                        $time->is_always_close = 2;
                        $time->save();
                    }
                    return redirect(route('verify'))->with('success',trans('messages.success'));
                }else{
                    return redirect()->back()->with('error', trans('messages.wrong'));
                }
            }else{
                return redirect()->back()->with('error', trans('messages.wrong_while_email'));
            }
        }
    }
    public function verify_email()
    {
        return view('front.verify_email');
    }
    public function verify_otp(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['otp' => 'required'],
            [ 'otp.required' => trans('messages.enter_otp')]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $check = User::where('email',$request->email)->first();

            if(!empty($check))
            {
                if($check->otp == $request->otp)
                {
                    $update = User::where('email',$request->email)->update(['otp'=>NULL,'is_verified'=>1]);
    
                    if($update)
                    {
                        session()->forget('otpemail');
                        return redirect(route('login'))->with('success', trans('messages.success'));
                    }else{
                        return redirect()->back()->with('success', trans('messages.wrong'));
                    }
                }else{
                    return redirect()->back()->with('error', trans('messages.invalid_otp'));
                }
            }else{
                return redirect()->back()->with('error', trans('messages.invalid_email'));
            }
        }
    }
    public function resend_otp(Request $request)
    {
        $email = Session::get('otpemail');
        $userData = User::select('id', 'name')->where('email', $email)->first();
        $otp = rand(100000,999999);
        //$helper = helper::verificationemail($email,$otp);
        
        $helper = EmailSendController::emailVerification($email,$otp, $userData->name);
        if($helper == 1){
            User::where('email',$email)->update(['otp'=>$otp,'is_verified'=>2]);
            return redirect(route('verify'))->with('success',trans('messages.verification_code_sent'));
        }else{
            return redirect()->back()->with('error',trans('messages.wrong_while_email'));
        }
    }
    public function editprofile(Request $request,$id)
    {
        $validator = Validator::make($request->all(),
                ['name' => 'required'],  
                [ 'name.required' => trans('messages.enter_full_name')]
            );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->file('image') != ""){
                $validator = Validator::make($request->all(),
                            ['image' => 'image|mimes:jpeg,jpg,png'],  
                            [ 'image.required' => trans('messages.enter_image_file'),
                            'image.mimes' => trans('messages.valid_image')]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $file = $request->file("image");
                    if(Auth::user()->type == 2){

                        if(file_exists(storage_path("app/public/provider/".Auth::user()->image)))
                        {
                            unlink(storage_path("app/public/provider/".Auth::user()->image));
                        }

                        $filename = 'provider-'.time().".".$file->getClientOriginalExtension();
                        $file->move(storage_path().'/app/public/provider/',$filename);
                    }else{

                        if(file_exists(storage_path("app/public/profile/".Auth::user()->image)))
                        {
                            unlink(storage_path("app/public/profile/".Auth::user()->image));
                        }

                        $filename = 'profile-'.time().".".$file->getClientOriginalExtension();
                        $file->move(storage_path().'/app/public/profile/',$filename);
                    }
                    User::where('id', $id)->update(['image' => $filename]);
                }
            }
            User::where('id', $id)->update(['name' => $request->name]);
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    public function editPassword(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required',
            'c_new_password' => 'required'
        ],[ 
            'old_password.required' => trans('messages.enter_old_password'),
            'new_password.required' => trans('messages.enter_new_password'),
            'c_new_password.required' => trans('messages.enter_confirm_password')
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            $user_old_data = User::find($id);
            if (Hash::check($request->old_password,$user_old_data->password)) 
            {
                User::where('id',$id)->update(['password'=>Hash::make($request->new_password)]);
                return redirect()->back()->with("success",trans('messages.success'));
            }else{
                return redirect()->back()->with("error",trans('messages.old_pass_invalid'));
            }
        }
    }
    public function forgot_pass()
    {
        if(isset($_COOKIE['city_name'])){
            return view('front.forgot_pass');
        }
    }
    
    public function admin_send_pass(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),
            ['email' => 'required'],
            [ 'email.required' => trans('messages.enter_email')]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $check = User::where('email',$request->email)
                            ->where(function ($query) {
                                $query->where('type', 2)
                                    ->orWhere('type', 1);
                                })
                            ->where('is_available',1)
                            ->first();
            //dd($check);                
            if(!empty($check))
            {
                if($check->is_available == 1){
                    $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
                    $helper = EmailSendController::forgotpassword($request->email,$check->name,$new_password);
                    //dd($helper);
                    if($helper == 1){
                        User::where('email', $request->email)->update(['password'=>Hash::make($new_password)]);
                        return redirect(route('adminlogin'))->with('success',trans('messages.password_sent'));
                    }else{
                        return redirect()->back()->with('error',trans('messages.wrong_while_email'));
                    }
                }else{
                    return redirect()->back()->with('error',trans('messages.blocked'));
                }
            }else{
                return redirect()->back()->with('error',trans('messages.invalid_email'));
            }
        }
    }
    
     public function send_pass(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['email' => 'required'],
            [ 'email.required' => trans('messages.enter_email')]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $check = User::where('email',$request->email)
                            ->where(function ($query) {
                                $query->where('type', 2)
                                    ->orWhere('type', 4);
                                })
                            ->where('is_available',1)
                            ->first();
            if(!empty($check))
            {
                if($check->is_available == 1){
                    $new_password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
                    $helper = EmailSendController::forgotpassword($request->email,$check->name,$new_password);
                    //dd($helper);
                    if($helper == 1){
                        User::where('email', $request->email)->update(['password'=>Hash::make($new_password)]);
                        return redirect(route('login'))->with('success',trans('messages.password_sent'));
                    }else{
                        return redirect()->back()->with('error',trans('messages.wrong_while_email'));
                    }
                }else{
                    return redirect()->back()->with('error',trans('messages.blocked'));
                }
            }else{
                return redirect()->back()->with('error',trans('messages.invalid_email'));
            }
        }
    }
    
    
    public function clearnotification(Request $request) 
    {
        $update = Notification::where('user_id',$request->user_id)->update(["is_read" => 1]);
        return json_encode($update);
    }
    public function noti(Request $request) 
    {
        $notificationdata = Notification::select('notification.id','notification.title','notification.message','notification.booking_id','notification.booking_status','notification.canceled_by','notification.is_read',DB::raw('DATE(notification.created_at) AS date'))
                    ->where('notification.user_id',Auth::user()->id)
                    ->orderByDesc('notification.id')
                    ->paginate(10);
        return view('provider.notification',compact('notificationdata'));
    }
    
    public function notifications_bell(Request $request) 
    {
        //return "hjkghjgjhgghj";  
         
        $notificationdata = Notification::where('notification.user_id',Auth::user()->id)->where('notification.is_read',2)->count();
        $res = ['notifyval' => $notificationdata];    
        return json_encode($res);
        //echo json_encode($res);            
        //return view('provider.notification',compact('notificationdata'));
    }

    public function users(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != ""){
                $usersdata = User::select('name','email','mobile','image')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('email', 'like', '%'.$query.'%')
                        ->orWhere('mobile', 'like', '%'.$query.'%')
                        ->where('type',4)
                        ->where('is_available',1)
                        ->orderByDesc('id')
                        ->paginate(10);
            }else{
                $usersdata = User::where('type',4)->orderByDesc('id')->paginate(10);
            }
            return view('users.users_table', compact('usersdata'))->render();
        }else{
            $usersdata = User::where('type',4)->orderByDesc('id')->paginate(10);
            return view('users.index',compact('usersdata'));
        }
    }

    public function usersstatus(Request $request){
        $success = User::where('id',$request->id)->update(['is_available'=>$request->status]);
        if($success) {
            return 1;
        } else {
            return 0;
        }         
    }
    
    public function test_Mail(){
        
        
        $data = [
            'title' => "Email verification",
            'email' => 'ak981993@gmail.com',
            'otp' => '445566',
        ];
        try {
            Mail::send('Email.emailverification', $data, function ($message) use ($data) {
                $message->from(env('MAIL_USERNAME'))->subject($data['title']);
                $message->to($data['email']);
            });
            return 1;
        } catch (\Throwable $th) {
            // Log the exception or print the message for debugging
            \Log::error('Mail sending error: ' . $th->getMessage());
            return 0;
        }



    }
}
