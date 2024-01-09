@extends('layout.main')
@section('page_title',trans('labels.notifications'))
@section('content')
	<section id="list">
	   <div class="row match-height">
	      <div class="col-sm-12 col-md-6 col-lg-12">
	         <div class="card">
	            <div class="card-header">
	               <h4 class="card-title">{{trans('labels.notifications')}}</h4>
	            </div>
					<div class="card-body">
	               <div class="card-block">
	                  <div class="simple-line-icons overflow-hidden">
	                  	@if(!empty($notificationdata) && count($notificationdata)>0)
                        	<div class="row">
									@foreach($notificationdata as $noti)
										<div class="col-md-12 col-sm-6 col-12 fonticon-container ">
											<div class="fonticon-wrap">
												@if($noti->booking_status == 1)
													<i class="fa fa-tags info"></i>
												@endif
												@if($noti->booking_status == 3)
													<i class="fa fa-check success"></i>
												@endif
												@if($noti->booking_status == 4)
													<i class="fa fa-times danger"></i>
												@endif
												@if($noti->booking_status == 2 && $noti->title == "Booking Rejected")
													<i class="fa fa-times danger"></i>
												@endif
												@if($noti->booking_status == 2 && $noti->title == "Booking Accepted")
													<i class="fa fa-check success"></i>
												@endif
											</div>
											<label class="fonticon-classname" for="view_info">
												<a href="{{URL::to('/bookings/'.$noti->booking_id)}}" class="text-dark">{{$noti->title}}</a>
												<small class="text-muted font-small-3 float-right mr-2 mt-1">{{Helper::date_format($noti->date)}}</small>
											</label>
											<label class="">{{$noti->message}}</label>
										</div>
									@endforeach
								</div>
								<div class="text-center">
									{{$notificationdata->links()}}
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
	</section>

@endsection