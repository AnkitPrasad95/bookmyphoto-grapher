<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;
use App\Models\ProviderType;
use App\Models\City;
use App\Models\Handyman;
use App\Models\Timing;
use App\Models\Service;
use App\Models\User;
use App\Models\Rattings;
use App\Models\Bank;
use App\Models\Booking;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Purifier;
use Str;

class ProviderController extends Controller
{
    public function providers(Request $request)
    {
        if($request->ajax())
        {
            $query = $request->get('query');
            if($query != ""){
                $providerdata = User::join('provider_types','users.provider_type','provider_types.id')
                        ->select('users.*','provider_types.name as provider_name')
                        ->where('users.name', 'like', '%'.$query.'%')
                        ->orWhere('users.email', 'like', '%'.$query.'%')
                        ->orWhere('provider_types.name', 'like', '%'.$query.'%')
                        ->orWhere('users.mobile', 'like', '%'.$query.'%')
                        ->where('users.type',2)
                        ->where('users.is_available',1)
                        ->orderByDesc('id')
                        ->paginate(10);
            }else{
                $providerdata = User::where('type',2)->orderByDesc('id')->paginate(10);
            }
            return view('provider.provider_table', compact('providerdata'))->render();
        }else{
            $providerdata = User::where('type',2)->orderByDesc('id')->paginate(10);
            return view('provider.index',compact('providerdata'));
        }
    }
    public function addprovider(){

        $providertypedata = ProviderType::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();

        $citydata = City::where('is_available',1)->where('is_deleted',2)->orderBy('id','DESC')->get();

        return view('provider.add',compact('providertypedata','citydata'));
    }
    public function storeprovider(Request $request)
    {
        
        //dd($request->all());
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'image' => 'required|image|mimes:jpeg,jpg,png',
                'provider_type' => 'required',
                'mobile' => 'required|unique:users',
                'address' => 'required',
                'city_id' => 'required',
                'about' => 'required'
            ],[
                'name.required' => trans('messages.enter_full_name'),
                'email.required' => trans('messages.enter_email'),
                'email.email' => trans('messages.valid_email'),
                'email.unique' => trans('messages.email_exist'),
                'password.required' => trans('messages.enter_password'),
                'image.required' => trans('messages.enter_image'),
                'image.image' => trans('messages.enter_image_file'),
                'image.mimes' => trans('messages.valid_image'),
                'provider_type.required'=>trans('messages.select_provider_type'),
                'mobile.required' => trans('messages.enter_mobile'),
                'mobile.unique' => trans('messages.mobile_exist'),
                'address.required' => trans('messages.enter_address'),
                'city_id.required' => trans('messages.enter_city'),
                'about.required'=>trans('messages.enter_about_provider')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $file = $request->file("image");
            $filename = 'provider-'.time().".".$file->getClientOriginalExtension();
            $file->move(storage_path().'/app/public/provider/',$filename);

            $checkslug = User::where('slug',Str::slug($request->name, '-'))->first();
            if($checkslug != ""){
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            $address = strip_tags(Purifier::clean($request->address));
            //$about = strip_tags(Purifier::clean($request->about));
            $about = $request->about;
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->image = $filename;
            $user->password = Hash::make($request->password);
            $user->type = 2;
            $user->provider_type = $request->provider_type;
            $user->address = $address;
            $user->city_id = json_encode($request->city_id);
            $user->radius = $request->radius;
            $user->about = $about;
            $user->login_type = "email";
            $user->is_verified = 1;
            $user->is_available = 1;
            $user->slug = $slug;
            $user->save();
            
            $day = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
            $open_time = array('9:00am','9:00am','9:00am','9:00am','9:00am','9:00am','9:00am');
            $close_time= array('6:00pm','6:00pm','6:00pm','6:00pm','6:00pm','6:00pm','6:00pm');

            foreach($day as $key => $no)
            {
                $time = new Timing();
                $time->provider_id = $user->id;
                $time->day = $no;
                $time->open_time = $close_time[$key];
                $time->close_time = $close_time[$key];
                $time->is_always_close = 2;
                $time->save();
            }

            return redirect(route('providers'))->with('success',trans('messages.provider_added'));
        }
    }
    public function showprovider($provider){

        $providerdata = User::where('id',$provider)->first();
        //dd($providerdata);

        $providertypedata = ProviderType::where([['id','!=',$providerdata['providertype']->id],['is_deleted',2]])->get();
        $citydata= DB::table('users')
                         ->select('city_id')
            ->where('id', $provider)->limit(1)->get(); 
            //dd($citydata);
       $cityId=json_decode($citydata[0]->city_id);
       //$citydata = City::where([['id','!=',$providerdata['city']->id],['is_deleted',2]])->get();
       $citydata = City::where([['is_deleted',2]])->get();

        return view('provider.show',compact('providerdata','providertypedata','citydata','cityId'));
    }
    public function editprovider(Request $request,$provider)
    {
        //echo $provider;
        //dd($request->All());
        $pdata = User::where('id',$provider)->first();
        //dd($pdata);
        $validator = Validator::make($request->all(),[
                'edit_provider_name' => 'required',
                'email' => 'required|email|unique:users,email,'.$pdata->id,
                'provider_type' => 'required',
                'mobile' => 'required',
                'address' => 'required',
                'city_id' => 'required',
                'about' => 'required'
                ],[
                    'edit_provider_name.required' => trans('messages.enter_full_name'),
                    'email.required' => trans('messages.enter_email'),
                    'email.email' => trans('messages.valid_email'),
                    'email.unique' => trans('messages.email_exist'),
                    'mobile.required' => trans('messages.enter_mobile'),
                    'provider_type.required'=>trans('messages.select_provider_type'),
                    'address.required' => trans('messages.enter_address'),
                    'city_id.required' => trans('messages.enter_city'),
                    'about.required'=>trans('messages.enter_about_provider')
                ]);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            if($request->file("image") != ""){

                $validator = Validator::make($request->all(),[
                        'image' => 'required|image|mimes:jpeg,jpg,png',
                    ],[
                        'image.required' => trans('messages.enter_image'),
                        'image.image' => trans('messages.enter_image_file'),
                        'image.mimes' => trans('messages.valid_image')
                    ]);
                if ($validator->fails()) {
        
                    return redirect()->back()->withErrors($validator)->withInput();
        
                }else{
                    $rec = User::where('slug',$provider)->first();
                    if(file_exists(storage_path().'/app/public/provider/'.$rec->image)){
                        unlink(storage_path().'/app/public/provider/'.$rec->image);
                    }
                    $file = $request->file('image');
                    $filename = 'provider-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/provider/',$filename);

                    User::where('id',$pdata->id)->update(['image' => $filename]);
                }
            }
            if($request->is_available){
                $status = 1;
            }else{
                $status = 2;
            }
            // $checkslug = User::where('slug',Str::slug($request->edit_provider_name, '-'))->first();
            // if($checkslug != ""){
            //     $last = User::select('id')->orderByDesc('id')->first();
            //     $create = $request->edit_provider_name." ".($last->id+1);
            //     $slug =   Str::slug($create,'-');
            // }else{
                $slug = Str::slug($request->edit_provider_name, '-');
            //}
            $address = strip_tags(Purifier::clean($request->address));
            //$about = strip_tags(Purifier::clean($request->about));
            $about = $request->about;
            //dd($request->input('edit_provider_name'));
            User::where('id',$pdata->id)->update([
                   'name' =>  $request->edit_provider_name,
                   'email' =>  $request->email,
                   'mobile' =>  $request->mobile,
                   'provider_type' =>  $request->provider_type,
                   'address' =>  $address,
                   'city_id' =>  json_encode($request->city_id),
                   'about' => $about,
                   'slug' =>  $slug,
                   'is_available' =>  $status,
                ]);
            return redirect(route('providers'))->with('success',trans('messages.provider_updated'));
        }
    }
    public function providerstatus(Request $request){
        $success = User::where('id',$request->id)->update(['is_available'=>$request->status]);
        if($success) {
            return 1;
        } else {
            return 0;
        }         
    }
    public function provider($provider,Request $request) 
    {
        $providerdata = User::where('id',$provider)->first();
        $handymandata = User::where('provider_id',$providerdata->id)->where('is_available',1)->where('type',3)->orderByDesc('id')->paginate(10);
        $servicedata = Service::where('provider_id',$providerdata->id)->where('is_deleted',2)->orderBy('id','DESC')->paginate(10);
        $total_earning = DB::table('bookings')->where('provider_id', $providerdata->id)->where('status',3)->sum('total_amt');
        $rattingsdata = Rattings::leftJoin('users', 'rattings.user_id', '=', 'users.id')
                        ->select('rattings.id','rattings.ratting','rattings.comment','users.id as user_id','users.name as user_name','users.image as user_image',
                           DB::raw('DATE(rattings.created_at) AS date'))
                        ->where('rattings.provider_id',$providerdata->id)
                        ->paginate(10);

        // bookings-chart-start 
        $years = Booking::select(DB::raw("YEAR(created_at) as year"))->orderByDesc('created_at')->where('provider_id',$providerdata->id)->groupBy(DB::raw("YEAR(created_at)"))->get();
        $bookings = Booking::select(DB::raw("MONTHNAME(created_at) as month_name"),DB::raw("YEAR(created_at) as years"),DB::raw("SUM(total_amt) total"))
                        ->groupBy(DB::raw("YEAR(created_at)"),DB::raw("MONTHNAME(created_at)"))
                        ->orderBy('created_at')
                        ->where('status',3)
                        ->where('provider_id', $providerdata->id);
        if($request->has('year') && $request->year != ""){
            $bookings = $bookings->where(DB::raw("YEAR(created_at)"),'=',$request->year);
        }else{
            $bookings = $bookings->where(DB::raw("YEAR(created_at)"),'=',date('Y'));
        }
        $bookings = $bookings->get();
        $result[] = ['Month','Earnings'];
        foreach ($bookings as $key => $value) {
            $result[++$key] = [$value->month_name, (int)$value->total];
        }
        // bookings-chart-end

        if($request->ajax())
        {
            echo json_encode($result);
        }else{
            $earnings = json_encode($result);
            return view('provider.showprovider',compact('providerdata','handymandata','servicedata','rattingsdata','years','total_earning','earnings'));
        }
    }
    public function settings()
    {
        //$providerdata = User::where('slug',$provider)->first();

        

        //return view('provider.show',compact('providerdata','providertypedata','citydata','cityId'));    
        //$providerdata = User::where('id',Auth::user()->id)->first();
        $bankdata = Bank::where('provider_id',Auth::user()->id)->first();
        $providerdata = User::where('id',Auth::user()->id)->first();
        $providertypedata = ProviderType::where([['id','!=',$providerdata['providertype']->id],['is_deleted',2]])->get();
        $citydatar= DB::table('users')
                         ->select('city_id')
            ->where('slug', $providerdata->slug)->limit(1)->get(); 
        $cityId=json_decode($citydatar[0]->city_id);
       //$citydata = City::where([['id','!=',$providerdata['city']->id],['is_deleted',2]])->get();
        $citydata = City::where([['is_deleted',2]])->get();
       //dd($citydata);
        return view('provider.settings',compact('providerdata','bankdata','providertypedata','citydata','cityId'));
    }
    public function profile_settings_update(Request $request)
    {   
        //dd($request->all());
        $validator = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.Auth::user()->id,
                'mobile' => 'required',
                'bank_name' => 'required',
                'account_holder' => 'required',
                'account_type' => 'required',
                ],[
                    'name.required' => trans('messages.enter_full_name'),
                    'email.required' => trans('messages.enter_email'),
                    'email.email' => trans('messages.valid_email'),
                    'email.unique' => trans('messages.email_exist'),
                    'mobile.required' => trans('messages.enter_mobile'),
                    'bank_name.required' => trans('messages.enter_bank_name'),
                    'account_holder.required' => trans('messages.enter_account_holder'),
                    'account_type.required' => trans('messages.enter_account_type'),
                    'account_number.required' => trans('messages.enter_account_number'),
                    'routing_number.required' => trans('messages.enter_routing_number')
                ]);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            if($request->file("image") != ""){

                $validator = Validator::make($request->all(),[
                        'image' => 'required|image|mimes:jpeg,jpg,png',
                    ],[
                        'image.required' => trans('messages.enter_image'),
                        'image.image' => trans('messages.enter_image_file'),
                        'image.mimes' => trans('messages.valid_image')
                    ]);
                if ($validator->fails()) {
        
                    return redirect()->back()->withErrors($validator)->withInput();
        
                }else{
                    $rec = User::where('slug',$provider)->first();
                    if(file_exists(storage_path().'/app/public/provider/'.$rec->image)){
                        unlink(storage_path().'/app/public/provider/'.$rec->image);
                    }
                    $file = $request->file('image');
                    $filename = 'provider-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/provider/',$filename);

                    User::where('id',Auth::user()->id)->update(['image' => $filename]);
                }
            }

            $checkslug = User::where('slug',Str::slug($request->name, '-'))->first();
            $address = strip_tags(Purifier::clean($request->address));
            $about = $request->about;
            $city = json_encode($request->city_id);
            //dd($city);
            if($checkslug != ""){
                $last = User::select('id')->orderByDesc('id')->first();
                $create = $request->name." ".($last->id+1);
                $slug =   Str::slug($create,'-');
            }else{
                $slug = Str::slug($request->name, '-');
            }
            User::where('id',Auth::user()->id)->update([
                   'name' =>  $request->name,
                   'email' =>  $request->email,
                   'mobile' =>  $request->mobile,
                   'slug' =>  $slug,
                   'address' =>  $address,
                   'city_id' =>  $city,
                   'about' => $about,
                ]);
            Bank::where('provider_id',Auth::user()->id)->update([
                'bank_name' =>  $request->bank_name,
                'account_holder' =>  $request->account_holder,
                'account_type' =>  $request->account_type,
                'account_number' =>  $request->account_number,
                'routing_number' =>  $request->routing_number
            ]);
            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    public function add_bank(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'bank_name' => 'required',
                'account_holder' => 'required',
                'account_type' => 'required',
                'account_number' => 'required|unique:bank',
                'routing_number' => 'required|unique:bank'
                ],[
                    'bank_name.required' => trans('messages.enter_bank_name'),
                    'account_holder.required' => trans('messages.enter_account_holder'),
                    'account_type.required' => trans('messages.enter_account_type'),
                    'account_number.required' => trans('messages.enter_account_number'),
                    'routing_number.required' => trans('messages.enter_routing_number')
                ]);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $bank = new Bank();
            $bank->provider_id = Auth::user()->id;
            $bank->bank_name = $request->bank_name;
            $bank->account_holder = $request->account_holder;
            $bank->account_type = $request->account_type;
            $bank->account_number = $request->account_number;
            $bank->routing_number = $request->routing_number;
            $bank->save();
            return redirect()->back()->with('success',trans('messages.success'));
        }
    } 
    public function reviews() 
    {
        $rattingsdata = Rattings::leftJoin('users', 'rattings.user_id', '=', 'users.id')
                        ->select('rattings.id','rattings.ratting','rattings.comment',
                            'users.id as user_id','users.name as user_name','users.image as user_image',
                           DB::raw('DATE(rattings.created_at) AS date'))
                        ->where('rattings.provider_id',Auth::user()->id)
                        ->paginate(10);
        $averageratting = Rattings::where('provider_id',Auth::user()->id)
                ->select(DB::raw('ROUND(avg(rattings.ratting),2) as avg_ratting'))
                ->first();
        return view('provider.rattings',compact('rattingsdata','averageratting'));
    } 
    
    public function updateVerifiedFlag(Request $request){
        
        if($request->input('user_slug') != '' && $request->input('checkboxData') != '') {
            if($request->input('checkboxData') == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            //dd($status); 
            $rec = User::where('id',$request->input('user_slug'))->update(['verified_flag' => $status]);
            return "success";
             
        } else {
            return "fail";
        }
    }
     
    public function updateUserAvailablity(Request $request){
        //dd($status); 
        //return $request->input();
        if($request->input('user_slug') != '' && $request->input('available_status') != '') {
            if($request->input('available_status') == 'Unavailable') {
                $status = 0;
            } else if($request->input('available_status') == 'Busy') {
                $status = 2;
            } else if($request->input('available_status') == 'Available') {
                $status = 1;
            }
            
            $rec = User::where('id',$request->input('user_slug'))->update(['available_status' => $status]);
            return "success";
             
        } else {
            return "fail";
        }
    }
    
    
}
