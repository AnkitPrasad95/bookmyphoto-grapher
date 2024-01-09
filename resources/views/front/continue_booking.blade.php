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
						<li class="breadcrumb-item active" aria-current="page"><a href="{{URL::to('/home/services')}}">{{ trans('labels.services') }}</a></li>
						<li class="breadcrumb-item" aria-current="page">{{ trans('labels.continue') }}</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>

<div class="content bg-sec-img">
	<div class="container-fluid">
		<div class="row">
		    <?php 
            // echo "<pre>";
            // print_r($servicedata->toArray());
            // echo "<pre>";
            ?>

			<div class="col-xl-8 col-md-8">
				<div class="row align-items-center mb-4">
					<div class="col">
						<h4 class="widget-title mb-0">{{trans('labels.service')}}</h4>
					</div>
				</div>
				<div class="bookings">
					@if(!empty($servicedata))
					<div class="booking-list">
						<div class="booking-widget">
							<a href="{{URL::to('/home/service-details/'.$servicedata->slug)}}" class="booking-img">
								<img src="{{Helper::image_path($servicedata->service_image)}}" alt="{{trans('labels.service_image')}}">
							</a>
							<div class="booking-det-info">
								<h3>
									<a href="{{URL::to('/home/service-details/'.$servicedata->slug)}}">{{$servicedata->service_name}}</a>
									<?php Storage::disk('local')->put("service", $servicedata->service_id); ?>
								</h3>
								<ul class="booking-details">

									<li><span>{{trans('labels.price')}}</span> {{Helper::currency_format($servicedata->price)}} </li>

									<li><span>Price type</span>
										@if($servicedata->price_type == "Fixed")
										<span>
											@if ($servicedata->duration_type == 1)
											{{$servicedata->duration.trans('labels.minutes')}}
											@elseif ($servicedata->duration_type == 2)
											{{$servicedata->duration.trans('labels.hours')}}
											@elseif ($servicedata->duration_type == 3)
											{{$servicedata->duration.trans('labels.days')}}
											@else
											{{$servicedata->duration.trans('labels.minutes')}}
											@endif
											<i class="fas fa-clock ml-1"></i>
										</span>
										@else
										<span>{{$servicedata->price_type}}</span>
										@endif
									</li>
									<li>
										<span>{{trans('labels.provider')}}</span>
										<div class="avatar avatar-xs mr-1">
											<img class="avatar-img rounded-circle" alt="{{trans('labels.provider_image')}}" src="{{Helper::image_path($servicedata->provider_image)}}">
										</div>
										{{$servicedata->provider_name}}
									</li>

								</ul>
							</div>
							<div class="booking-det-info" style="width: 40%">
								<h4 class="filter-title">{{trans('labels.duration')}}</h4>
								{{--<input type="number"  value="{{$servicedata->duration}}" min="{{$servicedata->duration}}" id="service_duration" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration')}}" placeholder="{{trans('labels.enter_duration')}}">--}}
								<select class="form-control form-control selectbox select" name="duration" id="duration_booking" data-show-subtext="true" data-live-search="true">
									<?php

									if ($servicedata->price_type == "Fixed" && $servicedata->duration_type == 1) {
										$count = $servicedata->duration * 100;
									} else {
										$count = 100;
									}

									?>
									@for($i=$servicedata->duration?$servicedata->duration:1; $i < $count; $i++) <?php if ($servicedata->price_type == "Fixed") {
																													if ($servicedata->duration_type == 1) {
																														$label = trans('labels.minutes');
																														$optionPrice = ($i / $servicedata->duration) * $servicedata->price;
																													} elseif ($servicedata->duration_type == 2) {

																														$label = trans('labels.hours');
																														$optionPrice = ($i / $servicedata->duration) * $servicedata->price;
																													} elseif ($servicedata->duration_type == 3) {
																														$label = trans('labels.days');
																														$optionPrice = ($i / $servicedata->duration) * $servicedata->price;
																													} else {
																														$label = trans('labels.minutes');
																														$optionPrice = $i * $servicedata->price;
																													}
																												} else {
																													$label = $servicedata->price_type;
																													$optionPrice = $i * $servicedata->price;
																												}
																												?> <option value="{{$optionPrice}}" @isset($_GET['price']) @if($optionPrice==$_GET['price']) selected @endif @endisset>{{$i}} {{$label}} </option>
										<?php if ($servicedata->price_type == "Fixed" && $servicedata->duration_type == 3) {
											$i = $i + $servicedata->duration - 1;
										} ?>
										<?php if ($servicedata->price_type == "Fixed" && $servicedata->duration_type == 1) {
											$i = $i + $servicedata->duration - 1;
										} ?>
										@endfor
								</select>
							</div>
						</div>
					</div>
					@else
					<p class="text-center">{{trans('labels.no_data')}}</p>
					@endif
				</div>
			</div>
			<div class="col-xl-4 col-md-4">
				<div class="row align-items-center mb-4">
					<div class="col">
						<h4 class="widget-title mb-0">{{trans('labels.booking_summery')}}</h4>
					</div>
				</div>
				<div class="bookings">
					@if(!empty($servicedata))
					<div class="booking-list">
						@if(Storage::exists('service_id') && Storage::exists('coupon_code') && Storage::disk('local')->get('service_id') == $servicedata->service_id)
						<input type="text" class="btn bg-light w-100 @error('coupon') border-danger @enderror" name="coupon" value="{{Storage::disk('local')->get('coupon_code')}}" disabled="true">
						<a href="{{URL::to('/home/remove-coupon/'.$servicedata->service_id)}}" class="btn bg-light w-100"><i class="fas fa-trash"></i> {{trans('labels.remove_coupon')}} </a>
						@else
						<form id="check_coupon" action="{{URL::to('/home/service/continue/check-coupon/'.$servicedata->slug)}}" method="POST">
							@csrf
							<p class="text-muted">{{trans('labels.apply_coupon_here')}}</p>
							<div class="row">
								<div class="col-sm-8">
									<input type="text" class="btn bg-light w-100 @error('coupon') border-danger @enderror" name="coupon" value="{{old('coupon')}}" placeholder="{{trans('labels.enter_coupon')}} ">
									<input type="hidden" name="studio_id" value="{{ $servicedata->porvider_id }}">
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
						<div class="col-sm-8">{{trans('labels.price')}}</div>
						<?php $baseurl = URL::to('/'); ?>
						<script src="{{ URL::asset('/storage/app/public/front-assets/js/jquery-3.5.0.min.js') }}"></script>
						<script type="text/javascript">
							$(document).on('change', '#duration_booking', function() {
								var query = $(this).val();
								var url = "<?php echo  $baseurl; ?>/home/service/continue/<?php echo $servicedata->slug;  ?>"; //window.location.href;
								window.location.href = url + "?price=" + query;
							});
						</script>
						<div class="col-sm-4 text-right" id="price">
							<?php
							if (!empty($_REQUEST["price"])) {
								$price = $_REQUEST["price"];
								Storage::disk('local')->put("price", $price);
							} else {
								$price = $servicedata->price;
								Storage::disk('local')->put("price", $price);
							}
							?>
							{{Helper::currency_format($price)}}
						</div>
						<div class="col-sm-8" id="discount">{{trans('labels.discount')}}</div>
						<div class="col-sm-4 text-right" id="discount_price">
							@if(Storage::exists('service_id') && Storage::disk('local')->get('service_id') == $servicedata->service_id)
							@if(Storage::exists('discount_type') && Storage::disk('local')->get('discount_type') == 2)
							<?php $discount = (Storage::disk('local')->get('discount') / 100) * $price;
							Storage::disk('local')->put("total_discount", $discount); ?>
							{{Helper::currency_format($discount)}}
							@elseif(Storage::exists('discount_type') && Storage::disk('local')->get('discount_type') == 1)
							<?php $discount = Storage::disk('local')->get('discount');
							Storage::disk('local')->put("total_discount", $discount); ?>
							{{Helper::currency_format($discount)}}
							@else
							<?php $discount = 0;
							Storage::disk('local')->put("total_discount", $discount); ?>
							{{ Helper::currency_format($discount) }}
							@endif
							@else
							<?php $discount = 0;
							Storage::disk('local')->put("total_discount", $discount); ?>
							{{ Helper::currency_format($discount) }}
							@endif
						</div>
						<div class="w-100">
							<hr>
						</div>
						<div class="col-sm-8">{{trans('labels.total')}}</div>
						<div class="col-sm-4 text-right" id="total_price">
							<?php $total = $price - $discount;
							Storage::disk('local')->put("total_price", $total); ?>
							{{Helper::currency_format($total)}}
						</div>
						<div class="w-100">
							<hr>
						</div>
						<div class="col-sm-12">
							<div class="service-book mt-1">
								<a class="btn btn-red" id="checkoutherf" href="{{URL::to('/home/service/continue/checkout/'.$servicedata->slug)}}">{{trans('labels.checkout')}}
								</a>
							</div>
						</div>
					</div>
					@else
					<p class="text-center">{{trans('labels.no_data')}}</p>
					@endif
				</div>
			</div>

		</div>
	</div>
</div>

@endsection