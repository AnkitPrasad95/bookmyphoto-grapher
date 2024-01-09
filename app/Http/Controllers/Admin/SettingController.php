<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\HomeSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function show()
    {
        $settingdata = Setting::first();
        return view('setting.show',compact('settingdata'));
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'firebase_key' => 'required',
                'currency' => 'required',
                'currency_position' => 'required',
                'referral_amount' => 'required',
                'withdrawable_amount' => 'required',
                'timezone' => 'required',
                'address' => 'required',
                'contact' => 'required',
                'email' => 'required|email',
                'copyright' => 'required',
                'website_title' => 'required',
                'meta_title' => 'required',
                'meta_description' => 'required',
                'facebook_link' => 'required',
                'twitter_link' => 'required',
                'instagram_link' => 'required',
                'linkedin_link' => 'required',
            ],[ 
                'firebase_key.required' => trans('messages.enter_firebase_key'),
                'currency.required' => trans('messages.enter_currency'),
                'currency_position.required' => trans('messages.select_currency_position'),
                'referral_amount.required' => trans('messages.enter_referral_amount'),
                'withdrawable_amount.required' => trans('messages.enter_withdrawable_amount'),
                'timezone.required' => trans('messages.select_timezone'),
                'address.required' => trans('messages.enter_address'),
                'contact.required' => trans('messages.enter_contact'),
                'email.required' => trans('messages.enter_email'),
                'email.email' => trans('messages.valid_email'),
                'copyright.required' => trans('messages.enter_copyright'),
                'website_title.required' => trans('messages.enter_website_title'),
                'meta_title.required' => trans('messages.enter_meta_title'),
                'meta_description.required' => trans('messages.enter_meta_description'),
                'facebook_link.required' => trans('messages.enter_link'),
                'twitter_link.required' => trans('messages.enter_link'),
                'instagram_link.required' => trans('messages.enter_link'),
                'linkedin_link.required' => trans('messages.enter_link'),
            ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if($request->file('logo') != ""){
                $validator = Validator::make($request->all(),[
                        'logo' => 'image|mimes:jpg,jpeg,png',
                    ],[
                        'logo.image' => trans('messages.enter_image_file'),
                        'logo.mimes' => trans('messages.valid_image'),
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = Setting::first(); 
                    if(file_exists(storage_path("app/public/images/".$rec->logo))){
                        unlink(storage_path("app/public/images/".$rec->logo));
                    }
                    $file = $request->file('logo');
                    $filename = 'logo-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    Setting::where('id',1)->update(['logo'=>$filename]);
                }  
            }
            if($request->file('favicon') != ""){
                $validator = Validator::make($request->all(),[
                        'favicon' => 'image|mimes:jpg,jpeg,png',
                    ],[
                        'favicon.image' => trans('messages.enter_image_file'),
                        'favicon.mimes' => trans('messages.valid_image'),
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = Setting::first(); 
                    if(file_exists(storage_path("app/public/images/".$rec->favicon))){
                        unlink(storage_path("app/public/images/".$rec->favicon));
                    }
                    $file = $request->file('favicon');
                    $filename = 'favicon-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    Setting::where('id',1)->update(['favicon'=>$filename]);
                }  
            }
            if($request->file('banner') != ""){
                $validator = Validator::make($request->all(),[
                        'banner' => 'image|mimes:jpg,jpeg,png',
                    ],[
                        'banner.image' => trans('messages.enter_image_file'),
                        'banner.mimes' => trans('messages.valid_image'),
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = Setting::first(); 
                    if(file_exists(storage_path("app/public/images/".$rec->banner))){
                        unlink(storage_path("app/public/images/".$rec->banner));
                    }
                    $file = $request->file('banner');
                    $filename = 'banner-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    Setting::where('id',1)->update(['banner'=>$filename]);
                }  
            }
            if($request->file('og_image') != ""){
                $validator = Validator::make($request->all(),[
                        'og_image' => 'image|mimes:jpg,jpeg,png',
                    ],[
                        'og_image.mage' => trans('messages.enter_image_file'),
                        'og_image.mimes' => trans('messages.valid_image'),
                    ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = Setting::first(); 
                    if(file_exists(storage_path("app/public/images/".$rec->og_image))){
                        unlink(storage_path("app/public/images/".$rec->og_image));
                    }
                    $file = $request->file('og_image');
                    $filename = 'og-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    Setting::where('id',1)->update(['og_image'=>$filename]);
                }  
            }

            Setting::where('id',1)
                ->update([
                    'firebase_key'=>$request->firebase_key,
                    'currency'=>$request->currency,
                    'currency_position'=>$request->currency_position,
                    'referral_amount'=>$request->referral_amount,
                    'withdrawable_amount'=>$request->withdrawable_amount,
                    'timezone'=>$request->timezone,
                    'address'=>$request->address,
                    'contact'=>$request->contact,
                    'email'=>$request->email,
                    'copyright'=>$request->copyright,
                    'website_title'=>$request->website_title,
                    'meta_title'=>$request->meta_title,
                    'meta_description'=>$request->meta_description,
                ]);
            return redirect(route('settings'))->with('success','Success');
        }
    }
    public function home_page()
    {
        $settingdata = HomeSettings::first();
        return view('setting.home_page_settings',compact('settingdata'));
    }
    public function home_page_setting(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title1' => 'required',
            'title2' => 'required',
            'title3' => 'required',
            'description1' => 'required',
            'description2' => 'required',
            'description3' => 'required',
        ],[ 
            'title1.required' => trans('messages.enter_title'),
            'title2.required' => trans('messages.enter_title'),
            'title3.required' => trans('messages.enter_title'),
            'description1.required' => trans('messages.enter_description'),
            'description2.required' => trans('messages.enter_description'),
            'description3.required' => trans('messages.enter_description'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            
            if($request->file('icon1') != ""){
                $validator = Validator::make($request->all(),
                    ['icon1' => 'image|mimes:jpg,jpeg,png',],
                    ['icon1.mage' => trans('messages.enter_image_file'),
                    'icon1.mimes' => trans('messages.valid_image'),]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = HomeSettings::first();
                    if(file_exists(storage_path("app/public/images/".$rec->icon1))){
                        unlink(storage_path("app/public/images/".$rec->icon1));
                    }
                    $file = $request->file('icon1');
                    $filename = 'icon1-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    HomeSettings::where('id',1)->update(['icon1'=>$filename]);
                }
            }
            if($request->file('icon2') != ""){
                $validator = Validator::make($request->all(),
                    ['icon2' => 'image|mimes:jpg,jpeg,png',],
                    ['icon2.mage' => trans('messages.enter_image_file'),
                    'icon2.mimes' => trans('messages.valid_image'),]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = HomeSettings::first();
                    if(file_exists(storage_path("app/public/images/".$rec->icon2))){
                        unlink(storage_path("app/public/images/".$rec->icon2));
                    }
                    $file = $request->file('icon2');
                    $filename = 'icon2-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    HomeSettings::where('id',1)->update(['icon2'=>$filename]);
                }
            }
            if($request->file('icon3') != ""){
                $validator = Validator::make($request->all(),
                    ['icon3' => 'image|mimes:jpg,jpeg,png',],
                    ['icon3.mage' => trans('messages.enter_image_file'),
                    'icon3.mimes' => trans('messages.valid_image'),]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }else{
                    $rec = HomeSettings::first();
                    if(file_exists(storage_path("app/public/images/".$rec->icon3))){
                        unlink(storage_path("app/public/images/".$rec->icon3));
                    }
                    $file = $request->file('icon3');
                    $filename = 'icon3-'.time().".".$file->getClientOriginalExtension();
                    $file->move(storage_path().'/app/public/images/',$filename);

                    HomeSettings::where('id',1)->update(['icon3'=>$filename]);
                }
            }

            HomeSettings::where('id',1)
                ->update([
                    'title1'=>$request->title1,
                    'title2'=>$request->title2,
                    'title3'=>$request->title3,
                    'description1'=>$request->description1,
                    'description2'=>$request->description2,
                    'description3'=>$request->description3,
                ]);
            return redirect(route('home_page'))->with('success','Success');
        }
    }
}

