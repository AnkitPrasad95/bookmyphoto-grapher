@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.notifications')}}
@endsection
@section('front_content')
      <div class="col-xl-9 col-md-8" id="notification-page">
         <div class="container">
            <h4 class="widget-title">{{trans('labels.notifications')}}</h4>
            @if(!empty($notifications) && count($notifications)>0)
               <div class="row">
                  @foreach($notifications as $noti)
                     <div class="col-lg-12">
                     <div class="review-list bg-white px-3 mb-3 rounded">
                        <div class="review-img">
                           @if($noti->booking_status == 1)
                              <?php $image = 'booking-pending.png';?>
                           @elseif($noti->booking_status == 2)
                              <?php $image = 'booking-confirmed.png';?>
                           @elseif($noti->booking_status == 3)
                              <?php $image = 'booking-confirmed.png';?>
                           @elseif($noti->booking_status == 4)
                              <?php $image = 'booking-cancel.png';?>
                           @else
                              <?php $image = '';?>
                           @endif
                           <img class="rounded img-fluid w-60" src="{{Helper::image_path($image)}}" alt="">
                        </div>
                        <div class="review-info col-md-10">
                           <h5><a href="{{URL::to('/home/user/bookings/'.$noti->booking_id)}}">{{$noti->title}}</a>
                              <small class="review-date float-right text-muted">{{Helper::date_format($noti->date)}}</small>
                           </h5>
                           <p class="mb-2">{{$noti->message}}</p>
                        </div>
                     </div>
                     </div>

                  @endforeach

               </div>
               <div class="d-flex justify-content-center">
                  {{ $notifications->links() }}
               </div>
            @else
               <p class="text-center">{{trans('labels.not_available')}}</p>
            @endif
         </div>
      </div>
@endsection
