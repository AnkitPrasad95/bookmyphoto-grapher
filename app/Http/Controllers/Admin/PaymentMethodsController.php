<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentMethodsController extends Controller
{
    public function index()
    {
        $paymentmethodsdata = PaymentMethods::orderBy('id')->get();
        return view('payment_methods.index',compact('paymentmethodsdata'));
    }
    public function show($id)
    {
        $paymentmethodsdata = PaymentMethods::find($id);
        return view('payment_methods.show',compact('paymentmethodsdata'));
    }
    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
                'environment' => 'required',
                'test_public_key' => 'required',
                'test_secret_key' => 'required',
                'live_public_key' => 'required',
                'live_secret_key' => 'required'
            ],[
                'environment.required' => trans('messages.select_environment'),
                'test_public_key.required' => trans('messages.enter_test_public_key'),
                'test_secret_key.required' => trans('messages.enter_test_secret_key'),
                'live_public_key.required' => trans('messages.enter_live_publi_key'),
                'live_secret_key.required' => trans('messages.enter_live_secret_key')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            $pdata = PaymentMethods::find($id);
            if($pdata->payment_name == "Flutterwave"){
                $validator = Validator::make($request->all(),
                    ['encryption_key' => 'required'],
                    ['encryption_key.required' => trans('messages.enter_encryption_key')]);
                if ($validator->fails()) {

                    return redirect()->back()->withErrors($validator)->withInput();

                }else{
                    $encryption_key = $request->encryption_key;
                }   
            }else{
                $encryption_key = NULL;
            }

            $success = PaymentMethods::where('id',$id)
                ->update([
                    'environment'=>$request->environment,
                    'test_public_key'=>$request->test_public_key,
                    'test_secret_key'=>$request->test_secret_key,
                    'live_public_key'=>$request->live_public_key,
                    'live_secret_key'=>$request->live_secret_key,
                    'encryption_key'=>$encryption_key,
                ]);

            return redirect(route('payment-methods'))->with('success',trans('messages.method_updated'));
        }
    }
    public function status(Request $request)
    {
        $success = PaymentMethods::where('id',$request->id)->update(['is_available'=>$request->status]);
        if($success) {
            return 1;
        } else {
            return 0;
        }                                        
    }
}
