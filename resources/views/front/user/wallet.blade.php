@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.wallet')}}
@endsection
@section('front_content')
	<div class="col-xl-9 col-md-8">
		@if(!empty($walletdata))
     		<div class="row">
         	<div class="col-xl-6 col-lg-6 col-md-6">
             	<div class="card">
                 	<div class="card-body">
                     <h4 class="card-title border-bottom">{{trans('labels.wallet')}}</h4>
                     <div class="wallet-details">
                         <span>{{trans('labels.current_balance')}}</span>
                         <h3>{{Helper::currency_format(Auth::user()->wallet)}}</h3>
                         <div class="d-flex justify-content-between my-4">
                         	<?php $total_credit = 0;$total_debit = 0;?>
                         	@foreach($walletdata as $wallet)
                         		@if($wallet->payment_type == 2)
                         			<?php $total_debit += $wallet->amount;?>
                         		@else
									<?php $total_credit += $wallet->amount;?>
                         		@endif
                         	@endforeach
                             <div>
                                 <p class="mb-1">{{trans('labels.total_credit')}}</p>
                                 <h4>{{Helper::currency_format($total_credit)}}</h4>
                             </div>
                             <div>
                                 <p class="mb-1">{{trans('labels.total_debit')}}</p>
                                 <h4>{{Helper::currency_format($total_debit)}}</h4>
                             </div>
                         </div>
                     </div>
                 </div>
             	</div>
         	</div>
         	<div class="col-xl-6 col-lg-6 col-md-6">
             	<div class="card">
                 	<div class="card-body">
                     <h4 class="card-title border-bottom">{{trans('labels.add_wallet')}}</h4>
                     <span id="amt_err_msg" class=""></span>
                     <div class="form-group">
                        <div class="input-group">
                           @if(Helper::appdata()->currency_position == "left")
										<div class="input-group-prepend">
                                 <label class="input-group-text display-5">{{Helper::appdata()->currency}}</label>
                              </div>
                              <input type="text" maxlength="4" class="form-control" name="wallet_amt" id="wallet_amt" placeholder="{{trans('labels.enter_amount')}}">
                           @else
                              <input type="text" maxlength="4" class="form-control" name="wallet_amt" id="wallet_amt" placeholder="{{trans('labels.enter_amount')}}">
                              <div class="input-group-prepend">
                                 <label class="input-group-text display-5">{{Helper::appdata()->currency}}</label>
                              </div>
									@endif
                        </div>
                     </div>
                     <span id="err_msg" class=""></span>
                     <div class="row">
             			@foreach($paymethods as $methods)
						  	<div class="col-12 col-sm-6">
						  		<div class="list-group-item mb-3">
	    							<div class="custom-control custom-radio">
	    								<input class="custom-control-input" id="{{$methods->payment_name}}" data-payment_type="{{$methods->id}}" name="payment" type="radio">
	    								<label class="custom-control-label font-size-sm text-body text-nowrap" for="{{$methods->payment_name}}">

	    									@if($methods->payment_name == "RazorPay")
	    										<img src="{{Helper::image_path('creditcard.png')}}" class="img-fluid ml-2" alt="knjbhv" width="30px" />

	    										@if($methods->environment=='1')
	    										    <input type="hidden" name="razorpay" id="razorpay" value="{{$methods->test_public_key}}">
	    										@else
	    										    <input type="hidden" name="razorpay" id="razorpay" value="{{$methods->live_public_key}}">
	    										@endif
												{{$methods->payment_name}}
	    									@endif

	    									@if($methods->payment_name == "Stripe")
	    										<img src="{{Helper::image_path('creditcard.png')}}" class="img-fluid ml-2" alt="knjbhv" width="30px" />

	    										@if($methods->environment=='1')
	    										    <input type="hidden" name="stripe" id="stripe" value="{{$methods->test_public_key}}">
	    										@else
	    										    <input type="hidden" name="stripe" id="stripe" value="{{$methods->live_public_key}}">
	    										@endif
												{{$methods->payment_name}}
	    									@endif

	    									@if($methods->payment_name == "Flutterwave")
	    										<img src="{{Helper::image_path('creditcard.png')}}" class="img-fluid ml-2" alt="knjbhv" width="30px" />

	    										@if($methods->environment=='1')
	    										    <input type="hidden" name="flutterwave" id="flutterwave" value="{{$methods->test_public_key}}">
	    										@else
	    										    <input type="hidden" name="flutterwave" id="flutterwave" value="{{$methods->live_public_key}}">
	    										@endif
												{{$methods->payment_name}}
	    									@endif

	    									@if($methods->payment_name == "Paystack")
	    										<img src="{{Helper::image_path('creditcard.png')}}" class="img-fluid ml-2" alt="knjbhv" width="30px" />

	    										@if($methods->environment=='1')
	    										    <input type="hidden" name="paystack" id="paystack" value="{{$methods->test_public_key}}">
	    										@else
	    										    <input type="hidden" name="paystack" id="paystack" value="{{$methods->live_public_key}}">
	    										@endif
												{{$methods->payment_name}}
	    									@endif

	    								</label>
	    							</div>
	    						</div>	
						  	</div>
					  	@endforeach
					</div>
					<span id="payment_err_msg" class=""></span>
					<div class="service-book mt-2">
                        <button class="btn btn-primary btn-block withdraw-btn" onclick="add_to_wallet()"> <i class="fa fa-plus"></i> {{trans('labels.add')}}</button>
                     </div>
                 	</div>
            	</div>
         	</div>
     		</div>
       	@if(!empty($walletdata) && count($walletdata) > 0)
            <h4 class="mb-4">Wallet Transactions</h4>
            <div class="card transaction-table">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-center table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>{{trans('labels.srno')}}</th>
                                    <th>{{trans('labels.amount')}}</th>
                                    <th>{{trans('labels.description')}}</th>
                                    <th>{{trans('labels.date')}}</th>
                                    <th>{{trans('labels.status')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php $i=1;?>
                            	@foreach($walletdata as $wallet)
                                <tr>
                                    <td><?=$i++;?></td>
                                    <td>{{Helper::currency_format($wallet->amount)}}</td>
                                    <td>
                                    	@if($wallet->payment_type == 1)
                                    		{{trans('labels.booking_canceled')}} <strong>{{$wallet->booking_id}}</strong>
                                    	@elseif($wallet->payment_type == 2)
											{{trans('labels.service_booked')}} <strong>{{$wallet->booking_id}}</strong>
										@elseif($wallet->payment_type == 3 || $wallet->payment_type == 4 || $wallet->payment_type == 5 || $wallet->payment_type == 6)
										 	{{trans('labels.added_with_card')}}
										@elseif($wallet->payment_type == 7)
											{{trans('labels.from_reference')}} <strong>{{$wallet->username}}</strong>
										@endif
                                    </td>
                                    <td>{{Helper::date_format($wallet->date)}}</td>
                                    <td>
                                    	@if($wallet->payment_type == 2)
											<span class="badge bg-danger-light"> {{trans('labels.debit')}} </span>
										@elseif($wallet->payment_type == 1 || $wallet->payment_type == 3 || $wallet->payment_type == 4 || $wallet->payment_type == 5 || $wallet->payment_type == 6 || $wallet->payment_type == 7)
											<span class="badge bg-success-light"> {{trans('labels.credit')}} </span>
										@endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        	</div>
        	<div class="d-flex justify-content-center">
	            {{ $walletdata->links() }}
	         </div>
        @endif
     	@else
    		<p class="text-center">{{trans('labels.no_data')}}</p>
    	@endif
		</div>

   	<input type="hidden" name="name" id="name" value="{{Auth::user()->name}}">
	<input type="hidden" name="email" id="email" value="{{Auth::user()->email}}">
	<input type="hidden" name="mobile" id="mobile" value="{{Auth::user()->mobile}}">
	<input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
	<input type="hidden" name="amt_err_text" id="amt_err_text" value="{{trans('messages.enter_amount')}}">
	<input type="hidden" name="select_ptype" id="select_ptype" value="{{trans('messages.select_payment_type')}}">
	<input type="hidden" name="title" id="title" value="{{trans('labels.app_name')}}">
	<input type="hidden" name="description" id="description" value="{{trans('labels.add_wallet_description')}}">
	<input type="hidden" name="logo" id="logo" value="https://stripe.com/img/documentation/checkout/marketplace.png">
	<input type="hidden" name="add_wallet_url" id="add_wallet_url" value="{{ URL::to('/home/user/wallet/add') }}">
	<input type="hidden" name="wallet_url" id="wallet_url" value="{{URL::to('/home/user/wallet')}}">

@endsection

@section('scripts')

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
@endsection