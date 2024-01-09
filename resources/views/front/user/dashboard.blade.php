@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.dashboard')}}
@endsection
@section('front_content')
   <div class="col-xl-9 col-md-8">
      <div class="row">
         <div class="col-lg-4">
            <a href="{{URL::to('/home/user/bookings')}}" class="dash-widget dash-bg-3">
               @if(!empty($bookings))
               <span class="dash-widget-icon">{{count($bookings)}}</span>
               <div class="dash-widget-info">
                  <span>{{trans('labels.bookings')}}</span>
               </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </a>
         </div>
         <div class="col-lg-4">
            <a href="{{URL::to('/home/user/reviews')}}" class="dash-widget dash-bg-3">
               @if(!empty($reviews))
               
               <span class="dash-widget-icon">{{count($reviews)}}</span>
               <div class="dash-widget-info">
                  <span>{{trans('labels.reviews')}}</span>
               </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </a>
         </div>
        
         <div class="col-lg-4">
            <a href="" onclick="clearnotification()" class="dash-widget dash-bg-3">
                @if(!empty($notifications))
                
               <span class="dash-widget-icon">{{count($notifications)}}</span>
               <div class="dash-widget-info">
                  <span>{{trans('labels.notifications')}}</span>
               </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </a>
         </div>
      </div>
   </div>

@endsection