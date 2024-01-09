@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.reviews')}}
@endsection
@section('front_content')
   <div class="col-xl-9 col-md-8" id="Review-page">
      <h4 class="widget-title">{{trans('labels.reviews')}}</h4>
      @if (!empty($rattingsdata) && count($rattingsdata)>0)
         <div class="review-card mb-0">
            <div class="">
               @foreach ($rattingsdata as $rdata)
                  <div class="review-list bg-white px-3 mb-3 flex-nowrap">
                     <div class="review-img">
                        <img class="rounded" 
                        @if ($rdata->service_image != "")
                           src="{{Helper::image_path($rdata->service_image)}}"
                        @else
                           src="{{Helper::image_path($rdata->provider_image)}}"
                        @endif
                        alt="{{trans('labels.image')}}">
                     </div>
                     <div class="review-info">
                        <h5>
                           @if ($rdata->service_name != "")
                              <a href="{{URL::to('/home/service-details/'.$rdata->service_slug)}}">{{$rdata->service_name}}</a>
                           @else
                              <a href="{{URL::to('/home/providers-services/'.$rdata->provider_slug)}}">{{$rdata->provider_name}}</a>
                           @endif
                        </h5>
                        <div class="review-date">{{Helper::date_format($rdata->date)}}</div>
                        <p class="mb-2">{{Str::limit($rdata->comment,100)}}</p>
                     </div>
                     <div class="review-count">
                        <div class="rating">
                           <i class="fas fa-star filled"></i>
                           <span class="d-inline-block average-rating">{{number_format($rdata->ratting,1)}}</span>
                        </div>
                     </div>
                  </div>

               @endforeach
                  
            </div>
         </div>
         <div class="d-flex justify-content-center">
            {{ $rattingsdata->links() }}
         </div>
      @else
         <div class="d-flex justify-content-center">
            {{trans('labels.no_data')}}
         </div>
      @endif
   </div>
@endsection
