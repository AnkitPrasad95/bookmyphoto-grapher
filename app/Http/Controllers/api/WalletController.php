<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class WalletController extends Controller
{
    public function wallet_add(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_user_id')],200);
        }
        $checkuser = User::where('id',$request->user_id)->where('type', '=', 4)->where('is_available',1)->first();
        if(empty($checkuser)){
            return response()->json(["status"=>0,"message"=>trans('messages.invalid_user')],200);
        }
        if($request->amount == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_amount')],200);
        }
        if($request->payment_type == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_payment_type')],200);
        }
        if($request->amount == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_amount')],200);
        }

        $wallet = $checkuser->wallet + $request->amount;

        $updateuserwallet = User::where('id',$request->user_id)->update(['wallet' => $wallet]);

        $transaction = new Transaction();
        $transaction->user_id = $request->user_id;
        $transaction->transaction_id = $request->transaction_id;
        $transaction->amount = $request->amount;
        $transaction->payment_type = $request->payment_type;
        if($transaction->save()){
            return Response::json(['status' => 1,'message' => trans('messages.success')], 200);
        }else{
            return Response::json(['status' => 0,'message' => trans('messages.wrong')], 200);
        }
    }
    public function wallet(Request $request)
    {
        if($request->user_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.enter_user_id')],200);
        }

        $walletdata = Transaction::select('id','user_id','service_id','provider_id','booking_id','transaction_id','amount','payment_type','username',
                                    DB::raw('DATE(created_at) AS date'))
                                ->where('user_id',$request->user_id)
                                ->orderByDesc('id')
                                ->paginate(10);
        $total = User::select('wallet')->where('id',$request->user_id)->first();
        return response()->json(["status"=>1,"message"=>trans('messages.success'),'total_wallet'=>$total,'walletdata'=>$walletdata],200);
    }
}
