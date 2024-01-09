<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;
use Purifier;
use Illuminate\Support\Facades\Validator;

class InquiryController extends Controller
{
    public function contactus()
    {
        return view('front.contactus');
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'message' => 'required'
        ],[ 
            'fname.required' => trans('messages.enter_fname'),
            'lname.required' => trans('messages.enter_lname'),
            'email.required' => trans('messages.enter_email'),
            'email.email' => trans('messages.valid_email'),
            'mobile.required' => trans('messages.enter_mobile'),
            'message.required' => trans('messages.enter_message')
        ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{

            $message = strip_tags(Purifier::clean($request->message));
            
            $inquiry = new Inquiry();
            $inquiry->fname = $request->fname;
            $inquiry->lname = $request->lname;
            $inquiry->email = $request->email;
            $inquiry->mobile = $request->mobile;
            $inquiry->message = $message;

            if($inquiry->save()){
                return redirect()->back()->with('success',"Inquiry sended successfully");
            }else{
                return redirect()->back()->with('success',trans('messages.wrong'));
            }
        }
    }
}
