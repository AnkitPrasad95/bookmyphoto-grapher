<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\PaymentMethods;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;
use Stripe;

class WalletController extends Controller
{
    public function wallet_add(Request $request)
    {
        if($request->payment_type == 3 || $request->payment_type == 5 || $request->payment_type == 6){

            $transaction_id = $request->transaction_id;
        }
        if($request->payment_type == 4){

            Stripe\Stripe::setApiKey("sk_test_51HVsZRLKgWGtoXaz2VWYK0XT4FjOinBELkdjMuEMoBVYChCu3lUUmhv9o6FtbAQhWdyOMANwkDyXzxW8KmtrFNiQ009xR3GbaZ");
            $payment = Stripe\Charge::create ([
                    "amount" => $request->amount * 100,
                    "currency" => "inr",
                    "source" => $request->stripeToken,
                    "description" => "Test payment description.",
            ]);
            $transaction_id = $payment->id;
        }

        $wallet = Auth::user()->wallet + $request->amount;

        $updateuserwallet = User::where('id',Auth::user()->id)->update(['wallet' => $wallet]);

        $transaction = new Transaction;
        $transaction->user_id = $request->user_id;
        $transaction->transaction_id = $transaction_id;
        $transaction->amount = $request->amount;
        $transaction->payment_type = $request->payment_type;
        if($transaction->save()){
            return Response::json(['status' => 1,'message' => $request->input()], 200);
        }else{
            return Response::json(['status' => 0,'message' => trans('messages.wrong')], 200);
        }
    }
    public function wallet()
    {
        if(isset($_COOKIE["city_name"])){
            $walletdata = Transaction::select('transactions.*',DB::raw('DATE(transactions.created_at) AS date'))->where('user_id',Auth::user()->id)->orderByDesc('id')->paginate(10);
            $paymethods = PaymentMethods::where('is_available',1)->where('payment_name','!=','cod')->where('payment_name','!=','wallet')->orderBy('id')->get();
        }else{
            $walletdata = "";
            $paymethods = "";
        }
        return view('front.user.wallet',compact('walletdata','paymethods'));
    }
}
