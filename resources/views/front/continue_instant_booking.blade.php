@extends('front.layout.main')
@section('page_title')
{{ trans('labels.booking') }} | {{ trans('labels.continue') }}
@endsection
@section('content')

<div class="breadcrumb-bar">
	<div class="container-fluid">
		<div class="row">
			<div class="col">
				<div class="breadcrumb-title">
					<h2>{{ trans('labels.booking') }}</h2>
				</div>
			</div>
			<div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
				<nav aria-label="breadcrumb" class="page-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
						<li class="breadcrumb-item active" aria-current="page"><a href="{{URL::to('/home/instant-booking')}}">{{ trans('Instant Booking') }}</a></li>
						<li class="breadcrumb-item" aria-current="page">{{ trans('labels.continue') }}</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>

<div class="content bg-sec-img">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="row">
			    <?php 
			 //   echo "<pre>";
			 //   print_r($photographerData);
			 //   echo "</pre>";
			    ?>

				<div class="col-xl-8 col-md-8">
					<div class="row align-items-center mb-4">
						<div class="col">
							<h4 class="widget-title mb-0">Photographer</h4>
						</div>
					</div>
					<div class="bookings">
						<div class="booking-list">
							<div class="booking-widget">
								<a href="javascript:void(0);" class="booking-img">
									<img src="{{ url('storage/app/public/handyman/'.$photographerData['photographer_image']) }}" alt="Photographer Image">
								</a>
								<div class="booking-det-info">
									<h3>
										<a href="javascript:void(0);">{{$photographerData['photographer_name']}}</a>
									</h3>
									<ul class="booking-details">

										<li><span>Price</span> {{Helper::currency_format($photographerData['booking_price'])}} </li>

										<li><span>Price type</span>
											<span>Hourly</span>
										</li>
										<li>
											<span>Studio</span>
											<div class="avatar avatar-xs mr-1">
												<img class="avatar-img rounded-circle" alt="Studio Image" src="{{Helper::image_path($photographerData['studioImage'])}}">
											</div>
											{{$photographerData['studioName']}}
										</li>

									</ul>
								</div>
								<div class="booking-det-info" style="width: 40%">
									<h4 class="filter-title">Duration</h4>

									<select class="form-control form-control selectbox select" name="duration" id="duration_booking" data-show-subtext="true" data-live-search="true">
									@for($i=1; $i < 100; $i++) 
									<?php 
																												

												$label = trans('labels.hours');
												$optionPrice = ($i) * $photographerData['booking_price'];
											
										?> <option value="{{$optionPrice}}" @isset($_GET['price']) @if($optionPrice==$_GET['price']) selected @endif @endisset>{{$i}} {{$label}} </option>
									
										@endfor
								</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-md-4">
					<div class="row align-items-center mb-4">
						<div class="col">
							<h4 class="widget-title mb-0">Booking Summery</h4>
						</div>
					</div>
					<div class="bookings">
						
						
						<div class="booking-list">
    						@if(Storage::exists('photographer_id') && Storage::disk('local')->get('photographer_id') == $photographerData['photographer_id'])
    						<input type="text" class="btn bg-light w-100 @error('coupon') border-danger @enderror" name="coupon" value="{{Storage::disk('local')->get('ins_coupon_code')}}" disabled="true">
    						<a href="{{URL::to('/home/remove-coupon-instant/'.$photographerData['photographer_id'])}}" class="btn bg-light w-100"><i class="fas fa-trash"></i> {{trans('labels.remove_coupon')}} </a>
    						@else
    						<form id="check_coupon" action="{{URL::to('/home/instant/continue/check-coupon/'.$photographerData['photographer_slug'])}}" method="POST">
    							@csrf
    							<p class="text-muted">{{trans('labels.apply_coupon_here')}}</p>
    							<div class="row">
    								<div class="col-sm-8">
    									<input type="text" class="btn bg-light w-100 @error('coupon') border-danger @enderror" name="coupon" value="{{old('coupon')}}" placeholder="{{trans('labels.enter_coupon')}} ">
    									<input type="hidden" name="studio_id" value="{{ $photographerData['studioId'] }}">
    									@error('coupon')<span class="text-danger">{{ $message }}</span>@enderror
    								</div>
    								<div class="col-sm-4">
    									<button type="submit" class="btn btn-red w-100"><i class="fas fa-paper-plane"></i> {{trans('labels.apply')}} </button>
    								</div>
    							</div>
    						</form>
    						@endif
    					</div>

						<div class="booking-list">
							<div class="col-sm-8">Price</div>
							<script src="{{ URL::asset('/storage/app/public/front-assets/js/jquery-3.5.0.min.js') }}"></script>
							<?php $baseurl = URL::to('/'); ?>
							<script type="text/javascript">
								$(document).on('change', '#duration_booking', function() {
									var query = $(this).val();
									var url = "<?php echo  $baseurl; ?>/home/instant/continue/<?php echo $photographerData['photographer_slug'];  ?>"; //window.location.href;
									window.location.href = url + "?price=" + query;
								});
							</script>
							<!--<div class="col-sm-4 text-right" id="price">-->
							<!--	₹1,020.00-->
							<!--</div>-->
							<div class="col-sm-4 text-right" id="price">
    							<?php
    							if (!empty($_REQUEST["price"])) {
    								$price = $_REQUEST["price"];
    								Storage::disk('local')->put("ins_price", $price);
    							} else {
    								$price = $photographerData['booking_price'];
    								Storage::disk('local')->put("ins_price", $price);
    							}
    							?>
    							{{Helper::currency_format($price)}}
    						</div>
							<div class="col-sm-8" id="discount">Discount</div>
							<!--<div class="col-sm-4 text-right" id="discount_price">-->
							<!--	₹0.00-->
							<!--</div>-->
							<div class="col-sm-4 text-right" id="discount_price">
    							@if(Storage::exists('photographer_id') && Storage::disk('local')->get('photographer_id') == $photographerData['photographer_id'])
    							@if(Storage::disk('local')->get('ins_discount_type') == 2)
    							<?php $discount = (Storage::disk('local')->get('ins_discount') / 100) * $price;
    							Storage::disk('local')->put("ins_total_discount", $discount); ?>
    							{{Helper::currency_format($discount)}}
    							@elseif(Storage::disk('local')->get('ins_discount_type') == 1)
    							<?php $discount = Storage::disk('local')->get('ins_discount');
    							Storage::disk('local')->put("ins_total_discount", $discount); ?>
    							{{Helper::currency_format($discount)}}
    							@else
    							<?php $discount = 0;
    							Storage::disk('local')->put("ins_total_discount", $discount); ?>
    							{{ Helper::currency_format($discount) }}
    							@endif
    							@else
    							<?php $discount = 0;
    							Storage::disk('local')->put("ins_total_discount", $discount); ?>
    							{{ Helper::currency_format($discount) }}
    							@endif
    						</div>
							<div class="w-100">
								<hr>
							</div>
							<div class="col-sm-8">Total</div>
							<!--<div class="col-sm-4 text-right" id="total_price">-->
							<!--	₹1,020.00-->
							<!--</div>-->
							<div class="col-sm-4 text-right" id="total_price">
    							<?php $total = $price - $discount;
    							Storage::disk('local')->put("ins_total_price", $total); ?> 
    							{{Helper::currency_format($total)}}
    						</div>
							<div class="w-100">
								<hr>
							</div>
							<div class="col-sm-12">
								<div class="service-book mt-1">
									<a class="btn btn-red" id="checkoutherf" href="{{URL::to('/home/instant/continue/checkout/'.$photographerData['photographer_slug'])}}">Checkout
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

	</div>
</div>

@endsection