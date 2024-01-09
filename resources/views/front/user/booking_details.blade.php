@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.booking_details')}}
@endsection
 
@section('front_content')
   <div class="col-xl-9 col-md-8">
      <div class="row match-height">
         @if(!empty($bookingdata))
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div class="plan-det">
                     <h5>{{trans('labels.booking_status')}} 
                        @if ($bookingdata->status == 1) 
                           <a class="btn btn-sm bg-danger-light float-right" onclick="cancelbooking('{{$bookingdata->booking_id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/home/user/bookings/cancel') }}','{{ trans('messages.wrong') }} :(','{{ trans('messages.record_safe') }}')"><i class="fas fa-close"></i> {{trans('labels.cancel_booking')}}</a>
                        @endif
                        @if($bookingdata->is_rated==0 && $bookingdata->status==3 )
                           <a class="btn btn-sm bg-info-light float-right" data-toggle="modal" data-target="#add-rattings"><i class="fas fa-star"></i> {{trans('labels.add_rattings')}}</a>
                        @endif
                     </h5>
                     <hr>
                     <?php 
                        // echo "<pre>";
                        // print_r($bookingdata->toArray());
                        // echo "</pre>";
                        ?> 
                     <div class="bookingtrack">
                        @if ($bookingdata->status == 1)
                           <div class="step active">
                              <span class="icon"><i class="fa fa-clock"></i></span>
                              <span class="text"> {{trans('labels.pending')}} </span>
                           </div>
                           <div class="step"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.accepted_by_provider')}}</span></div>
                           <div class="step"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                           <div class="step"><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                           <div class="step"><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                           <div class="step"><span class="icon"><i class="fa fa-check"></i></span><span class="text">{{trans('labels.completed')}}</span> </div>
                        @endif
                        @if ($bookingdata->status == 2)
                           <div class="step active"><span class="icon"><i class="fa fa-clock"></i></span><span class="text"> {{trans('labels.pending')}} </span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.accepted_by_provider')}}</span></div>
                           
                           <!--<div class="step <?php if($bookingdata->handyman_id != "" && $bookingdata->handyman_accept==1) { echo "active"; } ?>"><span class="icon"><i class="fa fa-hourglass-start"></i></span>-->
                           <!--   @if($bookingdata->handyman_id != "" && $bookingdata->handyman_accept==1)-->
                           <!--      <span class="text">{{trans('labels.handyman_assigned')}}</span>-->
                           <!--   @else-->
                           <!--      <span class="text">{{trans('labels.booking_inprogress')}}</span>-->
                           <!--   @endif-->
                           <!--</div>-->
                           
                            <?php if($bookingdata->handyman_accept == '1') { ?>
                                <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                            <?php } elseif($bookingdata->handyman_accept == '2') { ?> 
                                <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.rejected_by_handyman')}}</span></div>
                            <?php } else { ?>
                                <div class="step "><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                            <?php } ?>
                            
                           <!--<div class="step "><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>-->
                           <div class="step "><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                           <div class="step"><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                           <div class="step"><span class="icon"><i class="fa fa-check"></i></span><span class="text">{{trans('labels.completed')}}</span></div>
                        @endif
                        
                        @if ($bookingdata->status == 5)
                           <div class="step active"><span class="icon"><i class="fa fa-clock"></i></span><span class="text"> {{trans('labels.pending')}} </span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.accepted_by_provider')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-hourglass-end"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                           <div class="step "><span class="icon"><i class="fa fa-check"></i></span><span class="text">{{trans('labels.completed')}}</span> </div>
                        @endif
                        
                        
                        
                        
                        @if ($bookingdata->status == 3)
                           <div class="step active"><span class="icon"><i class="fa fa-clock"></i></span><span class="text"> {{trans('labels.pending')}} </span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.accepted_by_provider')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-hourglass-end"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                           <div class="step active"><span class="icon"><i class="fa fa-check"></i></span><span class="text">{{trans('labels.completed')}}</span> </div>
                        @endif
                        @if ($bookingdata->status == 4)
                           <div class="step active">
                              <span class="icon"><i class="fa fa-close"></i></span><span class="text">
                                 @if($bookingdata->canceled_by == 1)
                                    {{trans('labels.canceled_by_provider')}}
                                 @else
                                    {{trans('labels.canceled_by_you')}}
                                 @endif
                              </span> 
                           </div>
                        @endif
                         @if ($bookingdata->status == 6)
                           <div class="step active">
                              <span class="icon"><i class="fa fa-close"></i></span><span class="text">
                                 {{trans('Customer Not Avalable')}}
                              </span> 
                           </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="plan-det">
                     <h5 style="width:50%"><a class="text-dark" href="{{URL::to('/home/service-details/'.$bookingdata->service_slug)}}">{{$bookingdata->service_name}}</a></h5><hr>
                     <div class="booking-list">
                        <div class="booking-widget">
                           <img class="booking-img rounded" src="{{Helper::image_path($bookingdata->service_image)}}" alt="{{trans('labels.service_image')}}">
                           <div class="booking-det-info">
                              <ul class="list-group list-group-flush">
                                 <li class="list-group-item">{{trans('labels.price')}} :- <span>{{Helper::currency_format($bookingdata->price)}}</span></li>
                               
                                 @if(!empty($bookingdata->category_name))
                                     <li class="list-group-item">{{trans('labels.category')}} :- <span>{{$bookingdata->category_name}}</span></li>
                                 @else
                                     <li class="list-group-item">{{trans('Photographer')}} :- <span>{{$bookingdata->handyman_name}}</span></li>
                                 @endif
                                 
                                 <li class="list-group-item">{{trans('labels.duration')}} :- 
                                    <span>
                                    @if(!empty($bookingdata->instant_duration_type))
                                    {{ 'Hourly' }}
                                    @else
                                        @if($bookingdata->price_type == "Fixed")
                                              @if ($bookingdata->duration_type == 1)
                                                 {{$bookingdata->duration.trans('labels.minutes')}}
                                              @elseif ($bookingdata->duration_type == 2)
                                                 {{$bookingdata->duration.trans('labels.hours')}}
                                              @elseif ($bookingdata->duration_type == 3)
                                                 {{$bookingdata->duration.trans('labels.days')}}
                                              @else
                                                 {{$bookingdata->duration.trans('labels.minutes')}}
                                              @endif 
                                        @else
                                           {{$bookingdata->price_type}}
                                        @endif
                                    @endif
                                    <i class="fas fa-clock ml-1"></i></span>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-7">
            <div class="card">
               <div class="card-body">
                  <div class="plan-det">
                     <h5>{{trans('labels.date_and_time')}}</h5><hr>
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{trans('labels.date')}} :- <span>{{Helper::date_format($bookingdata->date)}}</span></li>
                        <li class="list-group-item">{{trans('labels.time')}} :- <span>{{$bookingdata->time}}</span></li>
                        @if($bookingdata->note != "" || $bookingdata->note != null)
                           <li class="list-group-item">{{trans('labels.notes')}} :- <span>{{strip_tags($bookingdata->note)}}</span></li>
                        @endif
                       
                       <!--<li class="list-group-item">{{trans('labels.address')}} :- <span>{{strip_tags($bookingdata->address)}}</span></li>-->
                        <li class="list-group-item">
                        <div class="row mb-1">
                                    <div class="col-4 pr-0"><strong>{{trans('labels.address')}}</strong></div>
                                    <div class="col-8 pr-0">{{strip_tags($bookingdata->address)}}</div>
                                 </div>
                                 </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-md-5">
            <div class="card">
               <div class="card-body">
                  <div class="plan-det">
                     <h5>{{trans('labels.payment_details')}}</h5><hr>
                     <ul class="list-group list-group-flush">
                        <li class="list-group-item">{{trans('labels.payment_type')}} <span class="float-right">
                           @if($bookingdata->payment_type == 1)
                              {{trans('labels.cod')}}
                           @elseif($bookingdata->payment_type == 2)
                              {{trans('labels.wallet')}}
                           @else
                              {{trans('labels.online')}}
                           @endif
                           
                          <?php
                          $total_amt = $bookingdata->total_amt+$bookingdata->discount;
                          $qnty = $total_amt/$bookingdata->price; 
                          if($qnty > 1) {
                              $qnty = $qnty;
                          } else {
                              $qnty = 1;
                          }
                           
                          ?>
                        </span></li>
                        <li class="list-group-item">{{trans('labels.price')}} <span class="float-right">{{Helper::currency_format($bookingdata->price)}}</span></li>
                        <li class="list-group-item">{{trans('labels.discount')}} <span class="float-right">{{Helper::currency_format($bookingdata->discount)}}</span></li>
                        <li class="list-group-item">{{trans('Quantity')}} <span class="float-right">{{ $qnty }}</span></li>
                        <li class="list-group-item"><strong>{{trans('labels.total')}} <span class="float-right">{{Helper::currency_format($bookingdata->total_amt)}}</span></strong></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="plan-det">
                     <h5>{{trans('labels.provider_details')}}</h5><hr>
                     <div class="booking-list">
                        <div class="booking-widget">
                           <a href="{{URL::to('/home/providers-services/'.$bookingdata->provider_slug)}}" class="p-2">
                              <img class="booking-img rounded" src="{{Helper::image_path($bookingdata->provider_image)}}" alt="{{trans('labels.provider_image')}}">
                           </a>
                           <div class="booking-det-info pt-2">
                              <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{trans('labels.name')}} :- <span>{{$bookingdata->provider_name}}</span></li>
                                <li class="list-group-item">{{trans('labels.email')}} :- <span>{{$bookingdata->provider_email}}</span></li>
                                <!--<li class="list-group-item">{{trans('labels.mobile')}} :- <span>{{$bookingdata->provider_mobile}}</span></li>-->
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @if($bookingdata->handyman_id != "" && $bookingdata->handyman_accept==1)
         <div class="col-lg-12">
            <div class="card">
               <div class="card-body">
                  <div class="plan-det">
                     <h5>{{trans('labels.handyman_details')}}</h5><hr>
                     <div class="booking-list">
                        <div class="booking-widget">
                           <img class="booking-img rounded" src="{{Helper::image_path($bookingdata->handyman_image)}}" alt="{{trans('labels.handyman_image')}}">
                           <div class="booking-det-info pt-2">
                              <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{trans('labels.name')}} :- <span>{{$bookingdata->handyman_name}}</span></li>
                                <li class="list-group-item">{{trans('labels.email')}} :- <span>{{$bookingdata->handyman_email}}</span></li>
                                @if($bookingdata->status == 2 && $bookingdata->handyman_accept == 1)
                                <li class="list-group-item">{{trans('Arrival OTP')}} :- <span>{{$bookingdata->assign_otp}}</span></li>
                                @elseif($bookingdata->status == 5) 
                                <li class="list-group-item">{{trans('Booking Complete OTP')}} :- <span>{{$bookingdata->completed_otp}}</span></li>
                                @endif
                                
                                <!--<li class="list-group-item">{{trans('labels.mobile')}} :- <span>{{$bookingdata->handyman_mobile}}</span></li>-->
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         @endif
         @else
            <p class="text-center">{{trans('labels.no_data')}}</p>
         @endif
      </div>
   </div>
@endsection