<div class="col-12 px-lg-0">
   <div id="popular-provider-owl" class="inner_list row">
        
@foreach($providerdata as $fpdata)
<?php //print_r($fpdata); ?>
   <div class="item shadow-none col-xl-3 col-lg-4 col-md-6 col-sm-12 mx-0 mb-4">
      <div class="img">
         <img src="{{ Helper::image_path($fpdata->provider_image) }}" class="img-fluid" alt="" />
         <span class="tag"><a href="#">{{$fpdata->provider_type}}</a></span>
         @if($fpdata->verified_flag == 1)
         <div class="tag-3">
                     <span><i class="fas fa-light fa-certificate mr-1"></i>Verified</span>
                  </div>
                  @endif
         <div class="tag-2">
          <span><i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ Helper::distance($fpdata['latitude'], $fpdata['longitude'], 28.704060, 77.102493, "K") }} KM</span>
         </div>
      </div>
      <div class="contents bg-white">
         <div class="d-flex">
         <h3 class="service-name w-100 mt-0">{{$fpdata->provider_name}}</h3>
         <div class="rating w-25">
               <i class="fas fa-star filled"></i>
               <span class="d-inline-block average-rating">{{number_format($fpdata['rattings']->avg('ratting'),1)}}</span>
         </div>
         </div>
         <p>{{Str::limit(strip_tags($fpdata->about),50)}}</p>
        
         <div class="d-flex">
            <div class="amount w-100">
                        <span class="span align-self-center d-block">Starting at</span>
                        <?php $users = DB::table('services')
                         ->select(DB::raw('MIN(price) AS minPrice'))
            ->where('provider_id', $fpdata->id)->limit(1)->get(); 
            ?>
                        <span class="price "><i class="fa fa-inr mr-1" aria-hidden="true"></i>{{$users[0]->minPrice?$users[0]->minPrice:0}}</span>
            </div>
            <a href="{{URL::to('/home/providers-services/'.$fpdata->slug)}}" class="btn w-100">Request Now</a>
         </div>
      </div>
   </div>

   {{--<div class="col-lg-3 col-md-6">
      <div class="service-widget">
         <div class="service-img">
            <a href="{{URL::to('/home/providers-services/'.$fpdata->slug)}}">
               <img class="img-fluid serv-img popular-services-img" alt="provider Image" src="{{ Helper::image_path($fpdata->provider_image) }}">
            </a>
            <div class="item-info">
               <div class="service-user">
                  <span class="service-price">{{$fpdata->provider_name}}</span>
               </div>
               <div class="cate-list">
                  <a class="bg-primary-color">{{$fpdata->provider_type}}</a>
               </div>
            </div>
         </div>
         <div class="service-content">
            <span>{{Str::limit(strip_tags($fpdata->about),50)}}</span>
            <div class="rating">
               <i class="fas fa-star filled"></i>
               <span class="d-inline-block average-rating">{{number_format($fpdata['rattings']->avg('ratting'),1)}}</span>
            </div>
            <div class="user-info">
               <div class="row">
               <a href="tel:{{$fpdata->mobile}}">
                  <span class="col-auto ser-contact">
                     <i class="fas fa-phone-alt mr-1"></i>
                    <?php /*<span>{{$fpdata->mobile}}</span>*/ ?>
                  </span>
               </a>
               </div>
            </div>
         </div>
      </div>
   </div>--}}
@endforeach
   </div>
</div>