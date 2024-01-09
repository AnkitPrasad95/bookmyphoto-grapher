@extends('layout.main')
@section('page_title',trans('labels.edit_payment_method'))
@section('content')
	<section id="basic-form-layouts">
		<div class="row">
			<div class="col-md-12">
	        	<div class="card">
	            <div class="card-header">
						<h4 class="card-title" id="horz-layout-colored-controls"> <b> {{$paymentmethodsdata->payment_name}} </b> </h4>
	            </div>
	            <div class="card-body">
	               <div class="px-3">
					    	<form class="form form-horizontal" id="edit_payment_method_form" action="{{URL::to('payment-methods/edit/'.$paymentmethodsdata->id)}}" method="POST" >
								@csrf
                        <div class="form-body">
                           <div class="form-group">
                              <label for="name">{{trans('labels.environment')}} @error('environment')<span class="text-danger" id="environment_error">{{ $message }}</span>@enderror</label>
                              <select id="edit_environment" name="environment" class="form-control border-primary" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="payment_name">
                                 <option @if($paymentmethodsdata->environment == "1") value="1" selected @endif >{{trans('labels.sandbox')}}</option>
                                 <option @if($paymentmethodsdata->environment == "2") value="2" selected @endif>{{trans('labels.production')}}</option>
                              </select>
                              @error('environment')<span class="text-danger" id="environment_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group" @if($paymentmethodsdata->payment_name != "Flutterwave") style="display:none;" @endif>
                              <label for="encryption_key">{{trans('labels.encryption_key')}} @error('environment')<span class="text-danger" id="environment_error">{{ $message }}</span>@enderror</label>
                              <input type="text" class="form-control" id="encryption_key" name="encryption_key" value="{{$paymentmethodsdata->encryption_key}}">
                              @error('encryption_key')<span class="text-danger">{{ $message }}</span>@enderror
                           </div>
                           <div class="row">
                              <div class="col">
                                 <div class="form-group">
                                    <label>{{trans('labels.test_public_key')}} @error('test_public_key')<span class="text-danger" id="test_public_key_error">{{ $message }}</span>@enderror</label>
                                    <input type="text" class="form-control" id="test_public_key" name="test_public_key" value="{{$paymentmethodsdata->test_public_key}}">
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="form-group">
                                    <label>{{trans('labels.test_secret_key')}} @error('test_secret_key')<span class="text-danger" id="test_secret_key_error">{{ $message }}</span>@enderror</label>
                                    <input type="text" class="form-control" id="test_secret_key" name="test_secret_key" value="{{$paymentmethodsdata->test_secret_key}}">
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col">
                                 <div class="form-group">
                                    <label>{{trans('labels.live_public_key')}} @error('live_public_key')<span class="text-danger" id="live_public_key_error">{{ $message }}</span>@enderror</label>
                                    <input type="text" class="form-control" id="live_public_key" name="live_public_key" value="{{$paymentmethodsdata->live_public_key}}">
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="form-group">
                                    <label>{{trans('labels.live_secret_key')}} @error('live_secret_key')<span class="text-danger" id="live_secret_key_error">{{ $message }}</span>@enderror</label>
                                    <input type="text" class="form-control" id="live_secret_key" name="live_secret_key" value="{{$paymentmethodsdata->live_secret_key}}">
                                 </div>
                              </div>
                           </div>
                           <div class="form-actions left">
                              <a class="btn btn-raised btn-danger mr-1" href="{{URL::to('payment-methods')}}"> <i class="fa fa-arrow-left"></i> {{trans('labels.back')}} </a>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                              @else
                                 <button type="submit" id="btn_edit_paymrnt_method" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                              @endif
                           </div>
                        </div>
							</form>
	               </div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection