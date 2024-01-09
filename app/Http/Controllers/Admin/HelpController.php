<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Purifier;

class HelpController extends Controller
{
      public function help_form()
      {
         return view('front.user.help');
      }
      public function help()
      {
         $helpdata = Help::orderByDesc('status','id')->paginate(10);
         return view('admin.help',compact('helpdata'));
      }
      public function clearhelp()
      {
         $update = Help::where('status',2)->update(["status" => 1]);
         return json_encode($update);
      }
      public function add_help(Request $request)
      {
         $validator = Validator::make($request->all(),[
               'fname' => 'required',
               'lname' => 'required',
               'email' => 'required|email',
               'mobile' => 'required',
               'subject' => 'required',
               'message' => 'required'
         ],[ 
               'fname.required' => trans('messages.enter_fname'),
               'lname.required' => trans('messages.enter_lname'),
               'email.required' => trans('messages.enter_email'),
               'email.email' => trans('messages.valid_email'),
               'mobile.required' => trans('messages.enter_mobile'),
               'subject.required' => trans('messages.enter_subject'),
               'message.required' => trans('messages.enter_message')
         ]);
         if ($validator->fails()) {

               return redirect()->back()->withErrors($validator)->withInput();

         }else{

               $message = strip_tags(Purifier::clean($request->message));
               
               $help = new Help();
               $help->user_id = Auth::user()->id;
               $help->fname = $request->fname;
               $help->lname = $request->lname;
               $help->email = $request->email;
               $help->mobile = $request->mobile;
               $help->subject = $request->subject;
               $help->message = $message;
               $help->status = 2;

               if($help->save()){
                  return redirect()->back()->with('success',trans('messages.success'));
               }else{
                  return redirect()->back()->with('success',trans('messages.wrong'));
               }
         }
      }
}