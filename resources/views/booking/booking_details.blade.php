@extends('layout.main')
@section('page_title')
{{trans('labels.bookings')}} | {{$bookingdata->booking_id}}
@endsection
<style>
/*a.btn.btn-success.btn-sm.btnmng {*/
/*    float: right;*/
/*}    */

.bookingtrack .icon i {
    position: relative;
    top: 11px;
}
</style>
@section('content')
<section id="list">
   <!-- Status track bar -->
   <div class="row match-height">
      <div class="col-sm-12 col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="card-block ">
                  <h1 class="card-title mt-1">{{trans('labels.booking_status')}}
                     @if(Auth::user()->type == 2 && $bookingdata->status == 1)
                     {{--<a class="btn btn-danger btn-sm float-right" onclick="cancelbooking('{{$bookingdata->id}}','4','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/cancel') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x"></i> {{ trans('labels.cancel') }} </a>--}}
                     <a class="btn btn-danger btn-sm float-right cancel_reason" data-bookingid="{{$bookingdata->id}}" data-toggle="modal" data-target="#cancel_reason"><i class="ft-x"></i> {{ trans('labels.cancel') }} </a>
                     <a style="background-color:#309be5;" class="btn btn-info btn-sm float-right mr-1" onclick="acceptbooking('{{$bookingdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/accept') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check"></i> {{ trans('labels.accept') }}</a>
                     @endif
                     @if(($bookingdata->status != 3 && $bookingdata->status != 6 && $bookingdata->canceled_by == ''))
                     <span class="float-right">
                     <a class="btn btn-success btn-sm btnmng" onclick="completebooking('{{$bookingdata->id}}','3','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/complete') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check"></i> {{ trans('labels.complete') }}</a>
                     </span>
                     @endif
                     
                  </h1>
                  <hr>
                  <?php
                //   echo "<pre>";
                    //   print_r($bookingdata->toArray());
                //   echo "</pre>";
                  ?>
                  <div class="bookingtrack">
                     @if ($bookingdata->status == 1)
                     <div class="step active">
                        <span class="icon"><i class="ft-clock"></i></span>
                        <span class="text"> {{trans('labels.pending')}} </span>
                     </div>
                     <div class="step"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.accepted')}}</span></div>
                     <div class="step"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                     <div class="step"><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                     <div class="step"><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                     <div class="step"><span class="icon"><i class="fa fa-check"></i></span><span class="text">{{trans('labels.completed')}}</span> </div>
                     @endif
                     @if ($bookingdata->status == 2)
                     <?php //echo "lalalalala"; //die;  
                     ?>
                     <div class="step active">
                        <span class="icon"><i class="ft-clock"></i></span>
                        <span class="text"> {{trans('labels.pending')}} </span>
                     </div>

                     <div class="step active">
                        <span class="icon"><i class="fa fa-user"></i></span>
                        <span class="text">{{trans('labels.accepted')}}</span>
                     </div>
                    
                     <!--<div class="step @if($bookingdata->handyman_id != "" && $bookingdata->handyman_accept == 1) {{ 'active' }}  @endif">-->
                     <!--   <span class="icon"><i class="fa fa-hourglass-start"></i></span>-->
                     <!--   @if($bookingdata->handyman_id != "" && $bookingdata->handyman_accept == 1)-->
                     <!--   <span class="text">{{trans('labels.handyman_assigned')}}</span>-->
                     <!--   @else-->
                        <!--<span class="text">{{trans('labels.booking_inprogress')}}</span>-->
                     <!--   @endif-->
                     <!--   @if(Auth::user()->type == 2)-->
                     <!--   @if(!empty($ahandymandata))-->
                     <!--   @if($bookingdata->status == 2 && ($bookingdata->handyman_accept == 2 || $bookingdata->handyman_id == "") )-->
                     <!--   <a class="btn btn-warning btn-sm select_handyman" data-bookingid="{{$bookingdata->id}}" data-toggle="modal" data-target="#select_handyman"><i class="ft-user"></i> {{ trans('labels.assign_handyman') }} </a>-->
                     <!--   @endif-->
                     <!--   @endif-->
                     <!--   @if($bookingdata->status == 2)-->
                        
                     <!--   <a class="btn btn-success btn-sm" onclick="completebooking('{{$bookingdata->id}}','3','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/complete') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check"></i> {{ trans('labels.complete') }}</a>-->

                     <!--   @endif-->
                     <!--   @endif-->
                     <!--</div>-->
                    <?php if($bookingdata->handyman_accept == 1) { ?>
                        <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                    <?php } elseif($bookingdata->handyman_accept == 2) { ?> 
                        <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.rejected_by_handyman')}}</span></div>
                    <?php } else { ?>
                        <div class="step "><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                    <?php } ?>
                     
                     <div class="step "><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                     <div class="step "><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                     <div class="step"><span class="icon"><i class="fa fa-check"></i></span><span class="text">{{trans('labels.completed')}}</span> </div>
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
                     <div class="step active"><span class="icon"><i class="ft-clock"></i></span><span class="text"> {{trans('labels.pending')}} </span></div>
                     <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.accepted')}}</span></div>
                     <div class="step active"><span class="icon"><i class="fa fa-user"></i></span><span class="text">{{trans('labels.photographer')}}</span></div>
                     <div class="step active"><span class="icon"><i class="fa fa-car"></i></span><span class="text">{{trans('labels.arrived')}}</span></div>
                     
                     <div class="step active"><span class="icon"><i class="fa fa-hourglass-start"></i></span><span class="text">{{trans('labels.booking_inprogress')}}</span></div>
                     <div class="step active">
                        <span class="icon"><i class="fa fa-check"></i></span>
                        <span class="text">
                           @if($bookingdata->handyman_id != "" && $bookingdata->handyman_accept == 1)
                           {{trans('labels.completed_by_handyman')}}
                           @else
                           {{trans('labels.completed')}}
                           @endif
                        </span>
                     </div>
                     @endif
                     @if ($bookingdata->status == 6)
                     <div class="step active">
                        <span class="icon"><i class="ft-x"></i></span><span class="text">
                          {{trans('Customer Not Avalable')}}
                        </span>
                     </div>
                     @endif
                     @if ($bookingdata->status == 4)
                     <div class="step active">
                        <span class="icon"><i class="ft-x"></i></span><span class="text">
                           @if($bookingdata->canceled_by == 1)
                           @if(Auth::user()->type == 1)
                           {{ trans('labels.cancel_by_provider') }}
                           @else
                           {{ trans('labels.cancel_by_you') }}
                           @endif
                           @elseif($bookingdata->canceled_by == 2)
                           {{trans('labels.cancel_by_customer')}}
                           @endif
                        </span>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Service info -->
   <div class="row match-height">
      <div class="col-sm-12 col-md-6 col-lg-12">
         <div class="card">
            <div class="card-block">

               <div class="media">
                  <!-- <img src="{{Helper::image_path($bookingdata->service_image)}}" class="rounded zoom-in booking-detail-image" data-enlargeable/> -->
                  <div class="media-body ml-2">
                     <div class="form-group row m-0">
                        <div class="col-md-4"><img src="{{Helper::image_path($bookingdata->service_image)}}" class="img-fluid rounded zoom-in booking-detail-image" data-enlargeable />
                        </div>
                        <div class="col-md-8">
                           <div class="row">
                              <div class="col col-md-12">
                                 <h3 class="text-bold-500 primary mt-2">{{$bookingdata->service_name}}</h3>
                              </div>
                              <div class="w-100">
                                 <hr class="m-1">
                              </div>
                              <div class="col col-md-12 ">
                                 <div class="row">
                                    <div class="col-12 col-md-6 col-sm-6">
                                       <ul class="no-list-style pl-0">
                                          <li class="">
                                             <span class="text-bold-500 primary"><i class="ft-smartphone font-small-3"></i> {{trans('labels.price')}}</span>
                                             <span class="display-block overflow-hidden">
                                                {{Helper::currency_format($bookingdata->price)}}
                                             </span>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-12 col-md-6 col-sm-6">
                                       <ul class="no-list-style pl-0">
                                          <li class="">
                                             <span class="text-bold-500 primary"><i class="ft-mail font-small-3"></i> {{trans('labels.duration')}}</span>
                                             <span class="display-block overflow-hidden">
                                                <!--@if($bookingdata->price_type == "Fixed")-->
                                                <!--      @if ($bookingdata->duration_type == 1)-->
                                                <!--         {{$bookingdata->duration.trans('labels.minutes')}}-->
                                                <!--      @elseif ($bookingdata->duration_type == 2)-->
                                                <!--         {{$bookingdata->duration.trans('labels.hours')}}-->
                                                <!--      @elseif ($bookingdata->duration_type == 3)-->
                                                <!--         {{$bookingdata->duration.trans('labels.days')}}-->
                                                <!--      @else-->
                                                <!--         {{$bookingdata->duration}}-->
                                                <!--      @endif-->
                                                <!--@else-->
                                                <!--   {{$bookingdata->price_type}}-->
                                                <!--@endif-->

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
                                             </span>
                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-12 col-md-6 col-sm-6">
                                       <ul class="no-list-style pl-0">

                                          <li class="">
                                             @if(!empty($bookingdata->category_name))
                                             <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('labels.category')}}</span>
                                             <span class="display-block overflow-hidden">{{$bookingdata->category_name}}</span>
                                             @else
                                             <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('Photographer')}}</span>
                                             <span class="display-block overflow-hidden">{{$bookingdata->handyman_name}}</span>
                                             @endif

                                          </li>
                                       </ul>
                                    </div>
                                    <div class="col-lg-12">
                                       <ul class="no-list-style pl-0">
                                          <li class="">
                                             <span class="text-bold-500 primary"><i class="fa fa-list-alt font-small-3"></i> {{trans('labels.description')}}</span>
                                             <span class="display-block overflow-hidden">{{Str::limit(strip_tags($bookingdata->description),350)}}</span>
                                          </li>
                                       </ul>
                                    </div>
                                    @if ($bookingdata->cancel_reason != '')
                                    <div class="col-lg-12">
                                       <ul class="no-list-style pl-0">
                                          <li class="">
                                             <span class="text-bold-500 primary"><i class="fa fa-list-alt font-small-3"></i> Cancel Reason</span>
                                             <span class="display-block overflow-hidden">{{Str::limit(strip_tags($bookingdata->cancel_reason),350)}}</span>
                                          </li>
                                       </ul>
                                    </div>
                                    @endif
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
   <!-- date-time-payment-info -->
   <div class="row match-height">
      <div class="col-sm-12 col-md-6 col-lg-12">
         <div class="card">
            <div class="col-lg-12">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="card-body">
                        <div class="card-block">
                           <h1 class="card-title mt-1">{{trans('labels.date_time')}}</h1>
                           <hr>
                           
                           <div class="row mb-1">
                              <div class="col-4 pr-0"><strong>{{trans('labels.date')}}</strong></div>
                              <div class="col-8 pr-0">{{Helper::date_format($bookingdata->date)}}</div>
                           </div>
                           <div class="row mb-1">
                              <div class="col-4 pr-0"><strong>{{trans('labels.time')}}</strong></div>
                              <div class="col-8 pr-0">{{$bookingdata->time}}</div>
                           </div>
                           @if($bookingdata->note != "" || $bookingdata->note != null)
                           <div class="row mb-1">
                              <div class="col-4 pr-0"><strong>{{trans('labels.notes')}}</strong></div>
                              <div class="col-8 pr-0">{{strip_tags($bookingdata->note)}}</div>
                           </div>
                           @endif
                           <div class="row mb-1">
                              <div class="col-4 pr-0"><strong>{{trans('labels.address')}}</strong></div>
                              <div class="col-8 pr-0">{{strip_tags($bookingdata->address)}}</div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="card-body">
                        <div class="card-block">
                           <h1 class="card-title mt-1">{{trans('labels.payment_details')}}</h1>
                           <hr>
                           <div class="row mb-1">
                              <div class="col-6 pr-0"><strong>{{trans('labels.payment_type')}}</strong></div>
                              <div class="col-6 pr-2 text-right">
                                 @if($bookingdata->payment_type == 1)
                                 {{trans('labels.cod')}}
                                 @elseif($bookingdata->payment_type == 2)
                                 {{trans('labels.wallet')}}
                                 @else
                                 {{trans('labels.online')}}
                                 @endif
                              </div>
                           </div>
                           <div class="row mb-1">
                              <div class="col-6 pr-0"><strong>{{trans('labels.price')}}</strong></div>
                              <div class="col-6 pr-2 text-right">{{Helper::currency_format($bookingdata->price)}}</div>
                           </div>
                           <div class="row mb-1">
                              <div class="col-6 pr-0"><strong>{{trans('labels.discount')}}</strong></div>
                              <div class="col-6 pr-2 text-right">{{Helper::currency_format($bookingdata->discount)}}</div>
                           </div>
                           <div class="row mb-1">
                              <div class="col-6 pr-0"><strong>{{trans('Quantity')}}</strong></div>
                              <?php
                              $total_amt = $bookingdata->total_amt+$bookingdata->discount;
                              $qnty = $total_amt/$bookingdata->price; 
                              if($qnty > 1) {
                                  $qnty = $qnty;
                              } else {
                                  $qnty = 1;
                              }
                               
                              ?>
                              <div class="col-6 pr-2 text-right">{{ $qnty }}</div>
                           </div>
                           <hr>
                           <div class="row mb-1">
                              <div class="col-6 pr-0"><strong>{{trans('labels.total')}}</strong></div>
                              <div class="col-6 pr-2 text-right">{{Helper::currency_format($bookingdata->total_amt)}}</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   
   <div class="row match-height">
       <div class="col-sm-12 col-md-6 col-lg-12">
         <div class="card">
              <div class="card-header border-bottom p-2 m-2">
               <h3>{{trans('labels.user')}}</h3>
            </div>
            <div class="card-block">

               <div class="media">
                  <a>
                     <img src="{{Helper::image_path($bookingdata->customer_image)}}" class="rounded booking-detail-profile" />
                  </a>
                  <div class="media-body ml-2">
                     <div class="form-group row m-0">
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col col-md-12">
                                 <h3 class="text-bold-500 primary mt-2">{{$bookingdata->customer_name}}</h3>
                              </div>
                              <div class="w-100">
                                 <hr class="m-1">
                              </div>
                              <div class="col col-md-12 ">
                                 <div class="row">
                                    <div class="col-12 col-md-6 col-sm-4">
                                       <ul class="no-list-style pl-0">
                                          <li class="">
                                             <span class="text-bold-500 primary"><i class="ft-mail font-small-3"></i> {{trans('labels.email')}}</span>
                                             <span class="display-block overflow-hidden">{{$bookingdata->customer_email}}</span>
                                          </li>
                                       </ul>
                                    </div>
                                    <!--<div class="col-12 col-md-6 col-sm-4">-->
                                    <!--   <ul class="no-list-style pl-0">-->
                                    <!--      <li class="">-->
                                    <!--         <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('labels.mobile')}}</span>-->
                                    <!--         <span class="display-block overflow-hidden">{{$bookingdata->provider_mobile}}</span>-->
                                    <!--      </li>-->
                                    <!--   </ul>-->
                                    <!--</div>-->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>

         </div>
      </div>
   </div>
   @if(Auth::user()->type == 1)
   <div class="row match-height">
 
      <div class="col-sm-12 col-md-6 col-lg-12">
         <div class="card">
             <div class="card-header border-bottom p-2 m-2">
               <h3>{{trans('labels.provider')}}</h3>
            </div>
            <div class="card-block">

               <div class="media">
                  <a href="{{URL::to('/providers/'.$bookingdata->provider_slug)}}">
                     <img src="{{Helper::image_path($bookingdata->provider_image)}}" class="rounded booking-detail-profile" />
                  </a>
                  <div class="media-body ml-2">
                     <div class="form-group row m-0">
                        <div class="col-md-12">
                           <div class="row">
                              <div class="col col-md-12">
                                 <h3 class="text-bold-500 primary mt-2">{{$bookingdata->provider_name}}</h3>
                              </div>
                              <div class="w-100">
                                 <hr class="m-1">
                              </div>
                              <div class="col col-md-12 ">
                                 <div class="row">
                                    <div class="col-12 col-md-6 col-sm-4">
                                       <ul class="no-list-style pl-0">
                                          <li class="">
                                             <span class="text-bold-500 primary"><i class="ft-mail font-small-3"></i> {{trans('labels.email')}}</span>
                                             <span class="display-block overflow-hidden">{{$bookingdata->provider_email}}</span>
                                          </li>
                                       </ul>
                                    </div>
                                    <!--<div class="col-12 col-md-6 col-sm-4">-->
                                    <!--   <ul class="no-list-style pl-0">-->
                                    <!--      <li class="">-->
                                    <!--         <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('labels.mobile')}}</span>-->
                                    <!--         <span class="display-block overflow-hidden">{{$bookingdata->provider_mobile}}</span>-->
                                    <!--      </li>-->
                                    <!--   </ul>-->
                                    <!--</div>-->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </div>

         </div>
      </div>
   </div>
   @endif
   @if($bookingdata->handyman_id != "")
   <div class="row match-height">
 
      <div class="col-sm-12 col-md-6 col-lg-12">
         <div class="card">
            <div class="card-header border-bottom p-2 m-2">
               <h3>{{trans('labels.handyman')}}</h3>
            </div>
            <div class="card-block">
               <div class="row">

                  <div class="col-lg-6">
                     <div class="media">
                        <!-- <img src="{{Helper::image_path($bookingdata->handyman_image)}}" class="rounded booking-detail-profile zoom-in" data-enlargeable/> -->
                        <div class="media-body ml-2">
                           <div class="form-group row m-0">
                              <div class="col-md-4">
                                 <img src="{{Helper::image_path($bookingdata->handyman_image)}}" class="rounded booking-detail-profile zoom-in" data-enlargeable />
                              </div>
                              <div class="col-lg-8">
                                 <div class="row">
                                    <div class="col col-md-12">
                                       <h3 class="text-bold-500 primary mt-2">{{$bookingdata->handyman_name}}</h3>
                                    </div>
                                    <div class="w-100">
                                       <hr class="m-1">
                                    </div>
                                    <div class="col col-md-12 ">
                                       <div class="row">
                                          <div class="col-lg-12 col-md-6">
                                             <ul class="no-list-style pl-0">
                                                <li class="">
                                                   <span class="text-bold-500 primary"><i class="ft-mail font-small-3"></i> {{trans('labels.email')}}</span>
                                                   <span class="display-block overflow-hidden">{{$bookingdata->handyman_email}}</span>
                                                </li>
                                             </ul>
                                          </div>
                                          <div class="col-lg-12 col-md-6">
                                             <ul class="no-list-style pl-0">
                                                <li class="">
                                                   <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('labels.mobile')}}</span>
                                                   <span class="display-block overflow-hidden">{{$bookingdata->handyman_mobile}}</span>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="media">
                        <div class="media-body ml-2">
                           <div class="form-group row m-0">
                              <div class="col-lg-12">
                                 <div class="row">
                                    <div class="col col-md-12">
                                       <h3 class="text-bold-500 primary mt-2">{{trans('labels.status')}}</h3>
                                    </div>
                                    <div class="w-100">
                                       <hr class="m-1">
                                    </div>
                                    <div class="col col-md-12 ">
                                       <div class="row">
                                          <div class="col-lg-12 col-md-6">
                                             <ul class="no-list-style pl-0">
                                                <li class="">
                                                   <span class="text-bold-500 primary"><i class="ft-check font-small-3"></i> {{trans('labels.assigned')}}</span>
                                                   <span class="display-block overflow-hidden">{{trans('labels.handyman_has_been_assigned')}}</span>
                                                </li>
                                             </ul>
                                          </div>
                                          <div class="col-lg-12 col-md-6">
                                             <ul class="no-list-style pl-0">
                                                <li class="">
                                                   <span class="text-bold-500 @if($bookingdata->handyman_accept == 1) primary @elseif($bookingdata->handyman_accept == 2) danger @endif">
                                                      <i class="@if($bookingdata->handyman_accept == 1) ft-check @elseif($bookingdata->handyman_accept == 2) ft-x @endif font-small-3"></i>
                                                      @if($bookingdata->handyman_accept == 1) {{trans('labels.accepted')}} @elseif($bookingdata->handyman_accept == 2) {{trans('labels.rejected_by_handyman')}} @endif </span>
                                                   <span class="display-block overflow-hidden">
                                                      @if($bookingdata->handyman_accept == 1) {{trans('labels.accepted_by_handyman')}} @elseif($bookingdata->handyman_accept == 2) {{trans('labels.reason')}} : {{strip_tags($bookingdata->reason)}} @endif
                                                   </span>
                                                </li>
                                             </ul>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
               </div>
            </div>

         </div>
      </div>
   </div>
   @endif
</section>

@endsection
@section('scripts')
<script src="{{ asset('resources/views/booking/booking.js') }}" type="text/javascript"></script>
@endsection