<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\PayoutCOD;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index()
    {
        if(Auth::user()->type == 1){
            $requests = Payout::join('bank','payout.provider_id','bank.provider_id')->orderByDesc('payout.status')->orderByDesc('payout.created_at')->paginate(10);
        }elseif (Auth::user()->type == 2) {
            $requests = Payout::join('bank','payout.provider_id','bank.provider_id')->where('payout.provider_id',Auth::user()->id)->orderByDesc('payout.status')->orderByDesc('payout.created_at')->paginate(10);
        }

        return view('payout.index',compact('requests'));
    }
    public function index_cod()
    {
        if(Auth::user()->type == 1){
            $requests = PayoutCOD::join('bank','payout_cod.provider_id','bank.provider_id')->orderByDesc('payout_cod.created_at')->paginate(10);
        }elseif (Auth::user()->type == 2) {
            $requests = PayoutCOD::join('bank','payout_cod.provider_id','bank.provider_id')->where('payout_cod.provider_id',Auth::user()->id)->orderByDesc('payout_cod.created_at')->paginate(10);
        }

        return view('payout.index_cod',compact('requests'));
    }
    public function create_request(Request $request)
    {
        $get = User::join('provider_types','users.provider_type','provider_types.id')->select('provider_types.commission')->where('users.id',Auth::user()->id)->first();

        $commission = $get->commission;
        $balance = $request->balance;
        $commission_amt = $balance*$commission/100;
        $payable_amt = $balance - $commission_amt;

        $request_id = substr(str_shuffle('ABCDFGHIJKLMNOPQRSTVWXYZ1234567890abcdeghijklmnopqrstuvwyz'), 0, 8);

        $pay = new Payout();
        $pay->request_id = $request_id;
        $pay->request_balance = $balance;
        $pay->request_date = Date('Y-m-d');
        $pay->commission = $commission;
        $pay->commission_amt = $commission_amt;
        $pay->payable_amt = $payable_amt;
        $pay->provider_id = Auth::user()->id;
        $pay->provider_name = Auth::user()->name;
        $pay->save();

        $tr = new Transaction();
        $tr->provider_id = Auth::user()->id;
        $tr->booking_id = $request_id;
        $tr->amount = $payable_amt;
        $tr->payment_type = 8; // 8=Withdraw Request
        $tr->save();

        return redirect()->back()->with('success',trans('messages.successs'));
    }

    public function update_request(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'request_id' => 'required',
                'payment_method' => 'required',
            ],[
                'request_id.required' => trans('messages.enter_request_id'),
                'payment_method.required' => trans('messages.select_payment_type')
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            $admindata = User::where('id',Auth::user()->id)->first();

            $payoutdata = Payout::where('request_id',$request->request_id)->first();
            
            Payout::where('request_id',$request->request_id)->update(['status'=>1,'payout_date'=>Date('Y-m-d')]);

            User::where('id',$payoutdata->provider_id)->update(['wallet'=>null]);

            $wallet = $admindata->wallet+$payoutdata->commission_amt;

            User::where('id',Auth::user()->id)->update(['wallet'=>$wallet]);

            $tr = new Transaction();
            $tr->user_id = Auth::user()->id; // user user_id as admin_id 
            $tr->provider_id = $payoutdata->provider_id;
            $tr->booking_id = $request->request_id;
            $tr->amount = $payoutdata->commission_amt;
            $tr->payment_type = 9; // 9=Withdraw Request accept/paid
            $tr->save();

            $tra = new Transaction();
            $tra->provider_id = $payoutdata->provider_id;
            $tra->booking_id = $payoutdata->request_id;
            $tra->amount = $payoutdata->payable_amt;
            $tra->payment_type = 9; // 8=Withdraw Request
            $tra->save();

            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    
    public function update_cod_request(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'request1_id' => 'required',
                'payment1_method' => 'required',
             ],[
                'request1_id.required' => trans('messages.enter_request_id'),
                'payment1_method.required' => trans('messages.select_payment_type'),
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            
        $request_id = substr(str_shuffle('ABCDFGHIJKLMNOPQRSTVWXYZ1234567890abcdeghijklmnopqrstuvwyz'), 0, 8);
        
        if($request->file('image')){
            $file = $request->file('image');
            $filename = 'COD-'.time().".".$file->getClientOriginalExtension();
            $file->move(storage_path().'/app/public/images/',$filename);
        }else{
          $filename="";  
        }
        
        $pay = new PayoutCOD();
        $pay->booking_id = $request->request1_id;
        $pay->request_id = $request_id;
        $pay->request_balance = $request->request_balance;
        $pay->request_date = Date('Y-m-d');
        $pay->payable_amt = $request->request_balance;
        $pay->provider_id = Auth::user()->id;
        $pay->provider_name = Auth::user()->name;
        $pay->payment_type = $request->payment1_method;
        $pay->images = $filename;
        $pay->payout_date = Date('Y-m-d');
        //dd($pay);
        $pay->save();

            return redirect()->back()->with('success',trans('messages.success'));
        }
    }
    
     public function update_admin_cod_request(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'request_cod_id' => 'required',
                'payment_cod_method' => 'required',
             ],[
                'request_cod_id.required' => trans('messages.enter_request_id'),
                'payment_cod_method.required' => trans('messages.select_payment_type'),
            ]);
        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();

        }else{
            
            

            $payoutdata = PayoutCOD::where('request_id',$request->request_cod_id)->first();
            $admindata = User::where('id',$payoutdata->provider_id)->first();
            
            if($request->payment_cod_method == 1){
                
                PayoutCOD::where('request_id',$request->request_cod_id)->update(['status'=>1,'payout_date'=>Date('Y-m-d')]);
    
                //User::where('id',$payoutdata->provider_id)->update(['wallet'=>null]);
                $wallet = $admindata->wallet+$payoutdata->payable_amt;
                 
                 User::where('id',$payoutdata->provider_id)->update(['wallet'=>$wallet]);
                
            }else{
                
                PayoutCOD::where('request_id',$request->request_cod_id)->update(['status'=>3,'payout_date'=>Date('Y-m-d')]);
                
            }
            
             return redirect()->back()->with('success',trans('messages.success'));
        }
    }

}
