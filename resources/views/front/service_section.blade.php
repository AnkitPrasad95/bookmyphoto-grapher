<div class="col-12">
   <div id="popular-service-owl" class="popular-service-owl-4 owl-carousel owl-theme">
       <?php 
    //   echo "<pre>";
    //   print_r($servicedata);
    //   echo "</pre>";
       ?>
      @foreach($servicedata as $sdata)
       

      <div class="item">
         <div class="img">
            <img src="{{ Helper::image_path($sdata->service_image) }}" class="img-fluid" alt="" />
            <span class="tag"><a href="{{URL::to('/home/services/'.strtolower($sdata->category_slug))}}">{{$sdata->category_name}}</a></span>
            @if($sdata->verified_flag == 1) 
             <div class="tag-3">
               <span><i class="fas fa-light fa-certificate mr-1"></i>Verified</span>
            </div>
            @endif
            
            <!-- <div class="tag-2"><span><i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ Helper::distance($sdata['latitude'], $sdata['longitude'], 28.704060, 77.102493, "K") }} KM</span></div> -->
         </div>
         <div class="contents bg-white position-relative">
            <div class="d-flex">
               <div class="d-flex w-100">
                  <img src="{{Helper::image_path($sdata->user_image) }}" class="user img-fluid" alt="" />
                  <span class="user-name w-100"><a href="{{URL::to('/home/providers-services/'.strtolower($sdata->user_slug))}}" class="text-black">{{$sdata->username}}</a></span>
               </div>
               <div class="w-25">
                  <div class="rating mt-1">
                     <i class="fas fa-star filled"></i>
                     <span class="d-inline-block average-rating">{{number_format($sdata['rattings']->avg('ratting'),1)}}</span>
                  </div>

                  <div class="kilomiter-tag"><span><i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ Helper::distance($sdata['latitude'], $sdata['longitude'], 28.704060, 77.102493, "K") }} KM</span></div>
               </div>
            </div>


            <h3 class="service-name w-100">{{$sdata->service_name}}</h3>


            <p class="">{{Str::limit(strip_tags($sdata->description),100)}}</p>
            <!-- <div class="rating1">
               
                         <span class="d-inline-block">{{ Helper::distance($sdata['latitude'], $sdata['longitude'], 28.704060, 77.102493, "K") }} KM</span>
                     </div> -->

            <div class="amount d-flex">
               <span class="span align-self-center">Starting at</span>
               <span class="price ">{{ Helper::currency_format($sdata->price) }} /

                  @if($sdata->price_type == "Fixed")

                  @if ($sdata->duration_type == 1)
                  {{$sdata->duration.trans('labels.minutes')}}
                  @elseif ($sdata->duration_type == 2)
                  {{$sdata->duration.trans('labels.hours')}}
                  @elseif ($sdata->duration_type == 3)
                  {{$sdata->duration.trans('labels.days')}}
                  @else
                  {{$sdata->duration.trans('labels.minutes')}}
                  @endif

                  @else
                  {{$sdata->price_type}}
                  @endif
               </span>
            </div>
            <a href="{{URL::to('/home/service-details/'.$sdata->slug)}}" class="btn">Request Now</a>
         </div>
      </div>







      {{--<div class="col-lg-3 col-md-6">
      <div class="service-widget">
         <div class="service-img">
            <a href="{{URL::to('/home/service-details/'.$sdata->slug)}}">
      <img class="img-fluid serv-img popular-services-img" src="{{ Helper::image_path($sdata->service_image) }}" alt="{{trans('labels.service_image')}}">
      </a>
      <div class="item-info">
         <div class="service-user">
            <span class="service-price">{{ Helper::currency_format($sdata->price) }}</span>
         </div>
         <div class="cate-list">
            <a class="bg-primary-color">{{$sdata->category_name}}</a>
         </div>
      </div>
   </div>
   <div class="service-content">
      <h3 class="title">
         <a href="{{URL::to('/home/service-details/'.$sdata->slug)}}">{{$sdata->service_name}}</a>
      </h3>
      <div class="rating">
         <i class="fas fa-star filled"></i>
         <span class="d-inline-block average-rating">{{number_format($sdata['rattings']->avg('ratting'),1)}}</span>
      </div>
      <div class="user-info">
         <div class="row">
            <a href="tel:{{$sdata->mobile}}">
               <span class="col-auto ser-contact"><i class="fas fa-phone-alt mr-1"></i>
                  <span><!--{{$sdata->mobile}} --></span>
               </span>
            </a>
            <span class="col ser-location">
               @if($sdata->price_type == "Fixed")
               <span>
                  @if ($sdata->duration_type == 1)
                  {{$sdata->duration.trans('labels.minutes')}}
                  @elseif ($sdata->duration_type == 2)
                  {{$sdata->duration.trans('labels.hours')}}
                  @elseif ($sdata->duration_type == 3)
                  {{$sdata->duration.trans('labels.days')}}
                  @else
                  {{$sdata->duration.trans('labels.minutes')}}
                  @endif
               </span><i class="fas fa-clock ml-1"></i>
               @else
               <span>{{$sdata->price_type}}</span><i class="fas fa-clock ml-1"></i>
               @endif
            </span>
         </div>
      </div>
   </div>
</div>
</div>--}}
@endforeach
</div>
</div>

<script>
   function distance(lat1, lon1, lat2, lon2, unit) {
      var radlat1 = Math.PI * lat1 / 180
      var radlat2 = Math.PI * lat2 / 180
      var theta = lon1 - lon2
      var radtheta = Math.PI * theta / 180
      var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
      if (dist > 1) {
         dist = 1;
      }
      dist = Math.acos(dist)
      dist = dist * 180 / Math.PI
      dist = dist * 60 * 1.1515
      if (unit == "K") {
         dist = dist * 1.609344
      }
      if (unit == "N") {
         dist = dist * 0.8684
      }
      return dist
   }
</script>