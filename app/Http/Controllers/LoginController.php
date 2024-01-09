<?php
namespace App\Http\Controllers;
use App\Helpers\helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Session;
use Str;

class LoginController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();
            if($finduser){
                if($finduser->is_verified == 1){
                    Auth::loginUsingId($finduser->id);
                    session(['id' => $finduser->id]);
                    return redirect()->route('user_dashboard');
                }else{
                    Auth::logout();
                    $otp = rand(100000,999999);
                    $helper = helper::verificationemail($finduser->email,$otp);
                    if($helper == 1){
                        $success = User::where('email', $finduser->email)->update(['otp' => $otp]);
                        if($success){
                            session(['otpemail' => $finduser->email]);
                            return redirect(route('verify'))->with('success',trans('messages.success'));
                        }else{
                            return redirect()->back()->with('error', trans('messages.wrong'));
                        }
                    }else{
                        return redirect()->back()->with('error',trans('messages.wrong_while_email'));
                    }
                }
            }else{
                session(['facebook_id' => $user->id]);
                session(['default_email' => $user->email]);
                session(['default_name' => $user->name]);
                return redirect(route('register_user'));
            }
        } catch (Exception $e) {
            return redirect(route('login'))->with('error',trans('messages.wrong'));
        }
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            //dd($user);
            $finduser = User::where('google_id', $user->id)->first();
            //dd($finduser);
            if($finduser){
                if($finduser->is_verified == 1){
                    Auth::loginUsingId($finduser->id);
                    session(['id' => $finduser->id]);
                    return redirect()->route('user_dashboard');
                }else{
                    Auth::logout();
                    $otp = rand(100000,999999);
                    $helper = helper::verificationemail($finduser->email,$otp);
                    if($helper == 1){
                        $success = User::where('email', $finduser->email)->update(['otp' => $otp]);
                        if($success){
                            session(['otpemail' => $finduser->email]);
                            return redirect(route('verify'))->with('success',trans('messages.success'));
                        }else{
                            return redirect()->back()->with('error', trans('messages.wrong'));
                        }
                    }else{
                        return redirect()->back()->with('error',trans('messages.wrong_while_email'));
                    }
                }
            }else{
                session(['google_id' => $user->id]);
                session(['default_email' => $user->email]);
                session(['default_name' => $user->name]);
                return redirect(route('register_user'));
            }
      
        } catch (Exception $e) {
            return redirect(route('login'))->with('error',trans('messages.wrong'));
        }
    }
    public function adminlogin(Request $request){
       //$email = session(['email',$request->email]);
       $email = $request->session()->get('email');
          return view("auth.index",compact('email'));
    }
    public function admin_forgot_pass(Request $request) {
        
        $email = $request->session()->get('email');
        return view("auth.admin-forgot-password", compact('email'));
    }
    
    
    public function checkadminlogin(Request $request)
    {
        
         Session::put(['email',$request->email]);
         $email = $request->session()->get('email');

         // if( ini_get('allow_url_fopen') ) {
            
        //     $payload = file_get_contents('https://paponapps.co.in/api/keyverify.php?url='.str_replace('checkadminlogin', '', url()->current()).'&type=login');
        //     $obj = json_decode($payload);

        //     if ($obj->status == '1') {
                $validator = Validator::make($request->all(),[
                        'email' => 'required|email',
                        'password' => 'required',
                    ],  [ 
                        'email.required' => trans('messages.enter_email'),
                        'email.email' => trans('messages.valid_email'),
                        'password.required' => trans('messages.enter_password')
                    ]);
                if ($validator->fails()) {

                    return redirect()->back()->withErrors($validator)->withInput();
                    
                }else{

                    if (Auth::attempt($request->only('email', 'password'))) 
                    {
                        if(Auth::user()->type==1 || Auth::user()->type==2) { 
                            return redirect()->route('dashboard');
                        } else if(Auth::user()->type==3 || Auth::user()->type==4) {
                            Auth::logout();
                            return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
                        } else {
                            return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
                        }
                        $request->session()->forget('email');

                    }else{
                        $email = $request->input('email');
                        session(['email' => $email]);
                        return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
                    }
                }
        //     } elseif ($obj->status == '3') {
        //         return Redirect::to('/')->with('danger', $obj->message);
        //     } else {
        //         return Redirect::to('/verification')->with('danger', $obj->message);
        //     }
        // }
    }
    public function index(){
        $email = session('email','');
        //dd($email);
        return view("front.login",compact('email'));
    }
    public function checklogin(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required',
            ],  [ 
                'email.required' => trans('messages.enter_email'),
                'email.email' => trans('messages.valid_email'),
                'password.required' => trans('messages.enter_password')
            ]);
            
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if (Auth::attempt($request->only('email', 'password'))) 
            {
                if(Auth::user()->type == 1 || Auth::user()->type == 2 || Auth::user()->type == 3) { 

                    Auth::logout();

                    return redirect()->back()->with('error',trans('messages.email_pass_invalid'));

                } else if(Auth::user()->type == 4) {

                    if(Auth::user()->is_available == "2"){
                        return redirect()->back()->with('error',trans('messages.blocked'));
                    }

                    if(Auth::user()->is_verified == "1"){

                        session(['id' => Auth::user()->id]);

                        return redirect()->route('user_dashboard');

                    }else{
                        Auth::logout();
                        $otp = rand(100000,999999);
                        $helper = helper::verificationemail($request->email,$otp);
                        if($helper == 1){
                            
                            $success = User::where('email', $request->email)->update(['otp' => $otp]);

                            if($success){

                                session(['otpemail' => $request->email]);
                                return redirect(route('verify'))->with('success',trans('messages.success'));

                            }else{
                                dd();
                                return redirect()->back()->with('error', trans('messages.wrong'));
                            }
                        }else{
                            return redirect()->back()->with('error',trans('messages.wrong_while_email'));
                        }
                    }
                } else {
                    return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
                }
            }else{
                
                return redirect()->back()->with('error',trans('messages.email_pass_invalid'));
            }
        }
    }

    // public function systemverification(Request $request)
    // {
        
        //dd($request->input());
        // if( ini_get('allow_url_fopen') ) {
        //     $username = str_replace(' ','',$request->envato_username);

        //     $payload = file_get_contents('https://domainname/api/getdata.php?envato_username='.$username.'&email='.$request->email.'&purchase_key='.$request->purchase_key.'&domain='.$request->domain.'&purchase_type=123&version=1');

        //     $obj = json_decode($payload);

        //     if ($obj->status == '1') {
        //         return Redirect::to('/')->with('success', 'You have successfully verified your License. Please try to Login now. If any query Contact us infotechgravity@gmail.com');
        //     } else {
        //         return Redirect::back()->with('danger', $obj->message);
        //     }
        // } else {
        //     return Redirect::back()->with('danger', "allow_url_fopen is disabled. file_get_contents would not work. ASK TO YOUR SERVER SUPPORT TO ENABLE THIS 'allow_url_fopen' AND TRY AGAIN");
        // }
    //}

    public function logout() {
        Auth::logout();
        session()->flush();
        return Redirect::to('/');
    }
       public function Adminlogout() {
        Auth::logout();
        session()->flush();
        return Redirect::to('/admin');
    }
    public function log_in_provider($slug)
    {
        $data = User::where('id',$slug)->first();
        Auth::loginUsingId($data->id, TRUE);
        Session::put('back_admin',1);
        return redirect(route('dashboard'));
    }
    public function go_back()
    {
        Auth::loginUsingId(1, TRUE);
        session()->flush();
        return redirect(route('dashboard'));
    }
}
