
     
      @if(!empty($instantData))
      <div id="popular-provider-owl" class="row Instant-booking">
         @foreach($instantData as $fpdata)

         <div class="item shadow-none col-lg-3 col-md-6 col-sm-12 mx-0 mb-4">
            <div class="img">
               <img src="{{ url('storage/app/public/provider/'.$fpdata['studioImage']) }}" class="img-fluid" alt="">
               <span class="tag"><a href="http://gautamgupta.info/home/services/trip photography &amp; videography">{{ $fpdata['studioName'] }}</a></span>
               @if($fpdata['verified_flag'] == 1)
               <div class="tag-3" data-toggle="tooltip" data-placement="top" title="Studio is verified by Book my photografer etc..">
                  <span><i class="fas fa-light fa-certificate mr-1"></i>Verified</span>
               </div>
              @endif
            </div>
            <div class="contents bg-white position-relative">
               <div class="d-flex">
                  <div class="d-flex w-100">
                     <img src="{{ url('storage/app/public/handyman/'.$fpdata['photographer_image']) }}" class="user img-fluid" alt="">
                     <span class="user-name w-100"><a href="javascript(0);">{{ $fpdata['photographer_name'] }}</a></span>
                     <!--<span class="user-name w-100"><a href="http://gautamgupta.info/home/providers-services/sangeeta-das">{{ $fpdata['photographer_name'] }}</a></span>-->
                  </div>
                  <div class="w-25">
                     <div class="rating mt-1">
                        <i class="fas fa-star filled"></i>
                        <span class="d-inline-block average-rating">0.0</span>
                     </div>

                     <div class="kilomiter-tag">
                        <span><i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ Helper::distance($fpdata['latitude'], $fpdata['longitude'], 28.704060, 77.102493, "K") }} KM</span>
                     </div>
                  </div>
               </div>


               <h3 class="service-name w-100"></h3>


               <p class="">{{Str::limit(strip_tags($fpdata['photographer_description']),80)}}</p>
              

               <div class="amount d-flex">
                  <span class="span align-self-center">Starting at</span>
                  <span class="price">₹{{ $fpdata['booking_price'] }} /

                     Hourly
                  </span>
               </div>
               <a href="@if(Auth::user()) {{URL::to('/home/instant/continue/'.$fpdata['photographer_slug'])}} @else {{URL::to('/home/login')}} @endif" class="btn">Book Now</a>
            </div>
         </div>

         @endforeach



      </div>
      @else
      <div class="text-center" style="display:none">
         <button type="button" class="btn btn-outline-dark m-1 ajax-load" onclick="next_page()">{{trans('labels.load_more')}}</button>
         <p class="text-muted dn no-record">{{trans('labels.no_data')}}</p>
      </div>
     @endif
