@extends('front.layout.main')

@section('page_title')
    {{ trans('labels.booking') }} | {{ trans('labels.checkout') }}
@endsection
<script type="text/javascript">
  function preventBack() { "use strict"; window.history.forward(); }  
  setTimeout("preventBack()", 0);
  window.onunload = function () { null };
</script>
@section('content')
	<div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>{{ trans('labels.checkout') }}</h2>
                    </div>
                </div>
                <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                           <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.service') }}</li>
                           <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.continue') }}</li>
                           <li class="breadcrumb-item " aria-current="page">{{ trans('labels.checkout') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    	<div class="content bg-sec-img">
    		<div class="container-fluid">
    			<div class="row">
                    @if(!empty($addressdata))
        				<div class="col-lg-8 col-md-12">
        					<h4 class="mb-3">{{trans('labels.booking_address')}}</h4>
        					<div class="table-responsive mb-3">
        						<table class="table table-bordered table-sm table-hover mb-0 bg-white">
        							<tbody>
        								<span id="address_err" class=""></span>
        								@foreach($addressdata as $address)
        								<tr>
        									<td>
        										<div class="custom-control custom-radio" onclick="closeaddressform();">
        										    <input type="hidden" id="address_id" value="{{$address->id}}">

        											<input class="custom-control-input"  id="{{$address->id}}" name="address" data-fullname="{{$address->name}}" data-email="{{$address->email}}" data-address_id="{{$address->id}}" data-mobile="{{$address->mobile}}" data-street_address="{{$address->street}}" data-landmark="{{$address->landmark}}" data-postcode="{{$address->postcode}}" type="radio">

        											<label class="custom-control-label text-body ml-2" for="{{$address->id}}">
        												<strong> {{$address->name}} </strong><br>
        												{{$address->email}}<br>{{$address->mobile}}<br>
        												{{$address->street." ".$address->landmark}}<br>{{$address->postcode}}
        											</label>

        										</div>
        									</td>
        								</tr>
        								@endforeach
        								<tr>
        									<td>
        										<div class="col-sm-12">
        											<div class="service-book m-1">
        					                            <button class="btn btn-red" onclick="openaddressform();"> <i class="fa fa-plus"></i> {{trans('labels.add_address')}}</button>
        					                        </div>
        											<form method="post" action="{{URL::to('/home/user/add-address')}}" id="addressform" class="mt-2 @if($errors->any()) dblock @else dn @endif">
        												@csrf
        												<div class="row mb-10">
        													<div class="col-12 col-md-12">
        														<div class="form-group">
        															<label for="fullnam">{{trans('labels.fullname')}}*</label>
        															<input class="form-control form-control-sm @error('fullname') is-invalid @enderror" name="fullname" id="fullname" type="text" placeholder="{{trans('labels.enter_full_name')}}" value="{{old('fullname')}}">
        															@error('fullname')<span class="text-danger ">{{ $message }}</span>@enderror
        														</div>
        													</div>

        													<div class="col-12 col-md-6">
        														<div class="form-group">
        															<label for="email">{{trans('labels.email')}}*</label>
        															<input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" name="email" id="email" placeholder="{{trans('labels.enter_email')}}" value="{{old('email')}}">
        															@error('email')<span class="text-danger ">{{ $message }}</span>@enderror
        														</div>
        													</div>

        													<div class="col-12 col-md-6">
        														<div class="form-group">
        															<label for="mobile">{{trans('labels.mobile')}}*</label>
        															<input class="form-control form-control-sm @error('mobile') is-invalid @enderror" name="mobile" id="mobile" type="text" placeholder="{{trans('labels.enter_mobile')}}" value="{{old('mobile')}}">
        															@error('mobile')<span class="text-danger ">{{ $message }}</span>@enderror
        														</div>
        													</div>

        													<div class="col-12 col-md-12">
        														<div class="form-group">
        															<label for="street_address">{{trans('labels.street_address')}}*</label>
        															<textarea  autocomplete="off" class="form-control form-control-sm @error('street_address') is-invalid @enderror" name="street_address" id="street_address" placeholder="{{trans('labels.enter_street_address')}}" rows="2"></textarea>
        															@error('street_address')<span class="text-danger ">{{ $message }}</span>@enderror
        														</div>
        														
        														<div class="form-group col-xl-6 d-none" id="latitudeArea">
                                                                <label class="mr-sm-2">Latitude</label>
                                                                <input type="text" id="latitude" name="latitude" class="form-control" value="{{old('latitude')}}">
                                                                </div>
                                                          
                                                                <div class="form-group col-xl-6 d-none" id="longtitudeArea">
                                                                    <labe class="mr-sm-2"l>Longitude</label>
                                                                    <input type="text" name="longitude" id="longitude" class="form-control" value="{{old('longitude')}}">
                                                                </div>
                                                                <div id="map"></div>
        													</div>

        													<div class="col-12 col-md-6">
        														<div class="form-group">
        															<label for="landmark">{{trans('labels.landmark')}}*</label>
        															<input class="form-control form-control-sm @error('landmark') is-invalid @enderror" name="landmark" id="landmark" type="text" placeholder="{{trans('labels.enter_landmark')}}" value="{{old('landmark')}}">
        															@error('landmark')<span class="text-danger ">{{ $message }}</span>@enderror
        														</div>
        													</div>

        													<div class="col-12 col-md-6">
        														<div class="form-group">
        															<label for="postalcode">{{trans('labels.postalcode')}}*</label>
        															<input class="form-control form-control-sm @error('postalcode') is-invalid @enderror" name="postalcode" id="postalcode" type="text" placeholder="{{trans('labels.enter_postalcode')}}" value="{{old('postalcode')}}">
        															@error('postalcode')<span class="text-danger ">{{ $message }}</span>@enderror
        														</div>
        													</div>
        													<div class="col-12 col-md-3 mb-2">	
        														<input type="submit" name="submit" class="btn btn-block btn-red mt-2" value="{{trans('labels.add')}}">
        													</div>
        												</div>
        											</form>
        										</div>
        									</td>
        								</tr>
        							</tbody>
        						</table>
        					</div>
        					<!-- <h4 class="mt-3">{{trans('labels.payment')}}</h4>
        					<span id="err_msg" class=""></span>
                            @if(!empty($paymethods))
        					<div class="list-group list-group-sm mb-3">
        						@foreach($paymethods as $methods)
        						<div class="list-group-item">
        							<div class="custom-control custom-radio">
        								<input class="custom-control-input" id="{{$methods->payment_name}}" data-payment_type="{{$methods->id}}" name="payment" type="radio">
        								<label class="custom-control-label font-size-sm text-body text-nowrap" for="{{$methods->payment_name}}">

        									@if($methods->payment_name == "COD")
        										<img src="{{Helper::image_path('COD.png')}}" class="img-fluid ml-2" alt="" width="30px" />
        										{{$methods->payment_name}}
        									@endif

        									@if($methods->payment_name == "Wallet")
        										<img src="{{Helper::image_path('wallet1.png')}}" class="img-fluid ml-2" alt="" width="30px" />
    											{{$methods->payment_name}}
    			                                <span class="text-danger text-right dn mr-auto" id="wallet_error" ></span>
        									@endif

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
        						@endforeach
        					</div> -->
        					<!-- <div class="service-book mt-2">
                                <button class="btn btn-red" onclick="proceed_payment()">{{trans('labels.proceed_payment')}}</button>
                            </div> -->
                            <!-- @else
                                <p class="text-center">{{trans('labels.no_data')}}</p>
                            @endif -->
        				</div>
        				<div class="col-12 col-md-12 col-lg-4">
        					<h4 class="mb-3">{{trans('labels.date_time')}}</h4>
        					<span id="date_time_err_msg" class=""></span>
        					<div class="cart_detail_box mb-4 flex" style="display: inline-flex;">
        							<h6 class="mb-3">Instant Booking</h6>
        							<input type="checkbox" class="custom-control custom-radio" name="instant_booking" id="instant_booking" value="1" style="margin-left: 17px;margin-top: -9px;width: 1rem;">
        					</div>
        					<div class="cart_detail_box mb-4">
        						<input type="date" class="form-control form-control-sm" name="date" id="date" min="<?=date('Y-m-d')?>">
        						<input type="time" class="form-control form-control-sm" name="time" id="time">
        					</div>
        					<h4 class="mb-3">{{trans('labels.notes')}}</h4>
        					<div class="cart_detail_box mb-4">
        						<textarea class="form-control form-control-sm mb-9 mb-md-0 font-size-xs" rows="3" name="booking_notes" id="booking_notes" placeholder="{{trans('labels.enter_notes')}}"></textarea>
        					</div>
        					<h4 class="mb-3">{{trans('labels.booking_summery')}}</h4>
        					<div class="cart_detail_box mb-4">
        						<ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
        							<li class="list-group-item d-flex">
        								<span>{{trans('labels.price')}}</span> <span class="ml-auto font-size-sm">
        									{{Helper::currency_format(Storage::disk('local')->get('price'))}}
        								</span>
        							</li>
        							<li class="list-group-item d-flex">
        								<span>{{trans('labels.discount')}}</span> <span class="ml-auto font-size-sm">
        									{{Helper::currency_format(Storage::disk('local')->get('total_discount'))}}
        								</span>
        							</li>
        							<li class="list-group-item d-flex font-size-lg font-weight-bold">
        								<span>{{trans('labels.total')}}</span> <span class="ml-auto font-size-sm">
        									{{Helper::currency_format(Storage::disk('local')->get('total_price'))}}
        								</span>
        							</li>

        							<input type="hidden" name="price" id="price" value="{{Storage::disk('local')->get('price')}}">
        							<input type="hidden" name="total_price" id="total_price" value="{{Storage::disk('local')->get('total_price')}}">
        							<input type="hidden" name="discount" id="discount" value="{{Storage::disk('local')->get('total_discount')}}">
        							<input type="hidden" name="service" id="service" value="{{Storage::disk('local')->get('service')}}">
        							<input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">

        							<input type="hidden" name="select_ptype" id="select_ptype" value="{{trans('messages.select_payment_type')}}">
        							<input type="hidden" name="date_time_err_text" id="date_time_err_text" value="{{trans('messages.select_date_time')}}">
        							<input type="hidden" name="address_err_text" id="address_err_text" value="{{trans('messages.select_address')}}">
    								<input type="hidden" name="title" id="title" value="{{trans('labels.app_name')}}">
    								<input type="hidden" name="description" id="description" value="{{trans('labels.add_wallet_description')}}">
    								<input type="hidden" name="logo" id="logo" value="https://stripe.com/img/documentation/checkout/marketplace.png">
    								<input type="hidden" name="booking_url" id="booking_url" value="{{ URL::to('/home/service/book') }}">
    								<input type="hidden" name="success_url" id="success_url" value="{{route('booking_success')}}">

        							@if(Storage::exists('service_id') && Storage::disk('local')->get('service_id') == $servicedata->service_id)
        								<input type="hidden" name="coupon_code" id="coupon_code" value="{{Storage::disk('local')->get('coupon_code')}}">
        								<input type="hidden" name="service_id" id="service_id" value="{{Storage::disk('local')->get('service_id')}}">
        							@endif
        						</ul>
        					</div>
        					<span id="error" class=""></span>

							<div>
							<h4 class="mt-3">{{trans('labels.payment')}}</h4>
        					<span id="err_msg" class=""></span>
                            @if(!empty($paymethods))
        					<div class="list-group list-group-sm mb-3">
        						@foreach($paymethods as $methods)
        						<div class="list-group-item">
        							<div class="custom-control custom-radio">
        								<input class="custom-control-input" id="{{$methods->payment_name}}" data-payment_type="{{$methods->id}}" name="payment" type="radio">
        								<label class="custom-control-label font-size-sm text-body text-nowrap" for="{{$methods->payment_name}}">

        									@if($methods->payment_name == "COD")
        										<img src="{{Helper::image_path('COD.png')}}" class="img-fluid ml-2" alt="" width="30px" />
        										{{$methods->payment_name}}
        									@endif

        									@if($methods->payment_name == "Wallet")
        										<img src="{{Helper::image_path('wallet1.png')}}" class="img-fluid ml-2" alt="" width="30px" />
    											{{$methods->payment_name}}
    			                                <span class="text-danger text-right dn mr-auto" id="wallet_error" ></span>
        									@endif

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
        						@endforeach
        					</div>
        					<div class="service-book mt-2 mb-3">
                                <button class="btn btn-red" onclick="proceed_payment()">{{trans('labels.proceed_payment')}}</button>
                            </div>
                            @else
                                <p class="text-center">{{trans('labels.no_data')}}</p>
                            @endif
							</div>
        				</div>
                    @else
                        <p class="text-center">{{trans('labels.no_data')}}</p>
                    @endif
    			</div>
    		</div>
    	</div>

@endsection

@section('scripts')

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://checkout.stripe.com/v2/checkout.js"></script>
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="https://js.paystack.co/v1/inline.js"></script> 


<script>
        $(document).ready(function () {
            $("#latitudeArea").addClass("d-none");
            $("#longtitudeArea").addClass("d-none");
        });
</script>  

<script type="text/javascript"> 
    $(document).ready(function() {
        $('#instant_booking').on('change', function() {
            if ($(this).prop('checked')) {
                // Checkbox is checked, set date and time
                var dt = new Date();
                var date = dt.getFullYear() + '-' + ('0' + (dt.getMonth() + 1)).slice(-2) + '-' + ('0' + dt.getDate()).slice(-2);
                var time = ('0' + dt.getHours()).slice(-2) + ':' + ('0' + dt.getMinutes()).slice(-2);

                $('#date').val(date);
                $('#time').val(time);
                
                // Disable date and time input fields
                //$('#date, #time').prop('disabled', true);
            } else {
                // Checkbox is unchecked, remove date and time
                $('#date').val('');
                $('#time').val('');

                // Enable date and time input fields
                $('#date, #time').prop('disabled', false);
            }
        });
    });
</script>

    
<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 28.455473, lng: 77.021902},
      zoom: 13,
      disableDefaultUI: false,
      streetViewControl: false
    });
    var input = document.getElementById('street_address');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
  
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });
  
    autocomplete.addListener('place_changed', function () {
        
         infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
    
        
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
      
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
      
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        
        
        
        var place = autocomplete.getPlace();
        $('#latitude').val(place.geometry['location'].lat());
        $('#longitude').val(place.geometry['location'].lng());

        //$("#latitudeArea").removeClass("d-none");
        //$("#longtitudeArea").removeClass("d-none");
    });
}
</script>
<script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>
@endsection