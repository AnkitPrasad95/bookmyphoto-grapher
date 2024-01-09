@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.my_bookings')}}
@endsection
<style>
    span.otp-btn {
        float: right;
    }
</style>
@section('front_content')
      <div class="col-xl-9 col-md-8">
         <div class="row align-items-center mb-4">
            <div class="col-md-3 mb-3">
               <h4 class="widget-title mb-0">{{trans('labels.my_bookings')}}</h4>
            </div>
            <div class="col-md-3 mb-2">
               <div class="sort-by">
                  <select class="form-control searchFilter" name="search_by" id="search_by" url="{{URL::to('/home/user/get-bookings-by')}}">
                     <option value="all" selected>{{trans('labels.all')}}</option>
                     <option value="1">{{trans('labels.pending')}}</option>
                     <option value="2">{{trans('labels.inprogress')}}</option>
                     <option value="5">{{trans('Photographer Arrived')}}</option>
                     <option value="3">{{trans('labels.completed')}}</option>
                     <option value="4">{{trans('labels.cancelled')}}</option>
                     <option value="6">{{trans('Not Available')}}</option>
                  </select>
               </div>
            </div>
            <div class="input-group col-md-6 float-right">
               <input type="text" name="search_booking" id="search_booking" class="form-control" placeholder="{{trans('labels.search_booking_by_id')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" url="{{URL::to('/home/user/get-bookings')}}"/>
            </div>
         </div>
         <div class="bookings">
            @if(!empty($bookingdata) && count($bookingdata)>0)
               @foreach ($bookingdata as $bdata)
               <?php
               if(!empty($bdata->handyman_id)){
                   
                   //$handymanData = app('App\Http\Controllers\FrontUserController')->getHandymanData($bdata->handyman_id);
               }
                
                //   echo "<pre>";
                //   print_r($bdata->toArray());
                //   echo "</pre>";
                ?>
                  <div class="booking-list">
                     <div class="booking-widget">
                        <a href="{{URL::to('/home/user/bookings/'.$bdata->booking_id)}}" class="booking-img text-center">
                           <img src="{{Helper::image_path($bdata->service_image)}}" alt="{{trans('labels.service_image')}}">
                           <!-- <span class="badge bg-success-light">{{trans('labels.booking')}} : <strong>{{$bdata->booking_id}}</strong></span> -->
                        </a>
                        <div class="booking-det-info">
                           <h3>
                              <a href="{{URL::to('/home/user/bookings/'.$bdata->booking_id)}}">{{$bdata->service_name}}</a>
                              
                              @if ($bdata->status == 1)
                                 <span class="badge bg-warning-light">{{trans('labels.pending')}}</span>
                              @elseif ($bdata->status == 2 && $bdata->handyman_id == '' && $bdata->handyman_accept == '')
                                 <span class="badge bg-info-light">{{trans('labels.accepted')}}</span>     
                              @elseif ($bdata->status == 2 && $bdata->handyman_id != '' && $bdata->handyman_accept == '')
                                 <span class="badge bg-info-light">{{trans('labels.handyman_assigned')}}</span>
                             @elseif ($bdata->status == 2 && $bdata->handyman_id != '' && $bdata->handyman_accept == 1)
                                 <span class="badge bg-info-light">{{trans('labels.photographer')}}</span>  
                             @elseif ($bdata->status == 2 && $bdata->handyman_id != '' && $bdata->handyman_accept == 2)
                                 <span class="badge bg-info-light">{{trans('labels.rejected_by_handyman')}}</span>
                             @elseif ($bdata->status == 5)
                                 <span class="badge bg-info-light">{{trans('labels.booking_inprogress')}}</span>     
                              @endif
                              
                              @if($bdata->status == 2 && $bdata->handyman_accept == 1)
                              <span class="otp-btn badge bg-success-light">{{trans('Arrival OTP')}} :- {{$bdata->assign_otp}} </span>
                                
                              @elseif($bdata->status == 5) 
                              <span class="otp-btn badge bg-success-light">{{trans('Complete OTP')}} :- {{$bdata->completed_otp}} </span>
                                
                              @endif
                           </h3>
                           
                           <ul class="booking-details">
                              <li><span>{{trans('labels.booking')}} Id</span>
                              <a href="{{URL::to('/home/user/bookings/'.$bdata->booking_id)}}"><span class="mb-0 text-success"><strong>{{$bdata->booking_id}}</strong></span></a></li>
                              <li><span>{{trans('labels.booking_date')}}</span><p class="mb-0">{{Helper::date_format($bdata->date)}}</p></li>
                              <li><span>{{trans('labels.booking_time')}}</span> <p class="mb-0">{{$bdata->time}}</p></li>
                              <li><span>{{trans('labels.amount')}}</span> <p class="mb-0">{{Helper::currency_format($bdata->total_amt)}}</p></li>
                               
                              <li>
                                 <span>{{trans('labels.provider')}}</span>
                                 
                                 <div class="avatar avatar-xs mr-1">
                                    <img class="avatar-img rounded-circle" alt="{{trans('labels.provider_image')}}" src="{{Helper::image_path($bdata->provider_image)}}">
                                 </div>
                                 <p class="mb-0">
                                 <a href="{{URL::to('/home/providers-services/'.$bdata->provider_slug)}}" class="text-muted">{{$bdata->provider_name}}</a></p>
                              </li>
                               @if ($bdata->cancel_reason != '')
                                <li><span>{{trans('labels.cancel')}} Reason</span> <p class="mb-0">{{Str::limit(strip_tags($bdata->cancel_reason),350)}}</p></li>
                              @endif
                              @if ($bdata->status == 3)
                                <li><span>View Gallery </span>   <p class="mb-0"> <a class="text-dark" href="{{URL::to('/home/user/gallery/'.$bdata->booking_id)}}">Click me</a></li>
                              @endif
                           </ul>
                        </div>

                        <div class="booking-action justify-content-lg-end d-lg-block d-none text-lg-right">
                           @if ($bdata->status == 1)
                              <a class="btn btn-sm bg-danger-light" onclick="cancelbooking('{{$bdata->booking_id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/home/user/bookings/cancel') }}','{{ trans('messages.wrong') }} :(','{{ trans('messages.record_safe') }}')"><i class="fas fa-close"></i> {{trans('labels.cancel_booking')}}</a>
                           @elseif ($bdata->status == 2)
                              <h5><span class="badge bg-primary-light"><i class="fas fa-clock"></i> {{trans('labels.inprogress')}} </span></h5>
                           @elseif ($bdata->status == 5)
                              <h5><span class="badge bg-primary-light"><i class="fas fa-clock"></i> {{trans('labels.inprogress')}} </span></h5>
                           @elseif ($bdata->status == 3)
                              <h5><span class="badge bg-success-light"><i class="fas fa-check"></i> {{trans('labels.completed')}} </span></h5>
                           @elseif ($bdata->status == 4)
                              <a class="btn btn-sm bg-danger-light"><i class="fas fa-close"></i>
                                 @if ($bdata->canceled_by==1)
                                    {{trans('labels.cancel_by_provider')}}
                                 @endif
                                 @if ($bdata->canceled_by==2)
                                    {{trans('labels.cancel_by_you')}}
                                 @endif
                              </a>
                           @elseif ($bdata->status == 6)  
                           <a class="btn btn-sm bg-danger-light"><i class="fas fa-close"></i> {{trans('Customer Not Avalable')}}</a>
                           @endif
                        </div>
                     </div>
                     <div class="booking-action d-xl-none d-block">
                        @if ($bdata->status == 1)
                           <a class="btn btn-sm bg-danger-light" onclick="cancelbooking('{{$bdata->booking_id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/home/user/bookings/cancel') }}','{{ trans('messages.wrong') }} :(','{{ trans('messages.record_safe') }}')"><i class="fas fa-close"></i> {{trans('labels.cancel_booking')}}</a>
                        @elseif ($bdata->status == 2)
                           <h5><span class="badge bg-primary-light"><i class="fas fa-clock"></i> {{trans('labels.inprogress')}} </span></h5>
                        @elseif ($bdata->status == 5)
                           <h5><span class="badge bg-primary-light"><i class="fas fa-clock"></i> {{trans('labels.inprogress')}} </span></h5>
                        @elseif ($bdata->status == 3)
                           <h5><span class="badge bg-success-light"><i class="fas fa-check"></i> {{trans('labels.completed')}} </span></h5>
                        @elseif ($bdata->status == 4)
                           <a class="btn btn-sm bg-danger-light"><i class="fas fa-close"></i>
                              @if ($bdata->canceled_by==1)
                                 {{trans('labels.cancel_by_provider')}}
                              @endif
                              @if ($bdata->canceled_by==2)
                                 {{trans('labels.cancel_by_you')}}
                              @endif
                           </a>
                         @elseif ($bdata->status == 6)  
                          <a class="btn btn-sm bg-danger-light"><i class="fas fa-close"></i> {{trans('Customer Not Avalable')}}</></a>
                        @endif
                     </div>
                  </div>
               @endforeach
               <div class="d-flex justify-content-center">
                  {{ $bookingdata->links() }}
               </div>
            @else
            <p class="no-center">{{trans('labels.no_data')}}</p>
            @endif
         </div>
      </div>
      
@endsection