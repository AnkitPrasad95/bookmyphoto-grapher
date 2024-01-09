@isset($servicedata)
<div class="text-left mt-1">
   <ul class="list-group suggestion_scroll col-sm-12 col-md-12 col-lg-12 ">
      @if(!empty($servicedata))
      @if(count($servicedata)>0)
      @foreach($servicedata as $service)
      <li class="list-group-item"><a href="{{URL::to('/home/service-details/'.$service->service_slug)}}" class="text-dark" style="font-weight: bolder;">{{$service->service_name}}</a></li>
      @endforeach
      @else

      <p class="list-group-item">{{trans('labels.no_result')}}</p>

      @endif
      @endif
   </ul>
</div>
@endisset


@isset($citydata)
@if(!empty($citydata) && count($citydata)>0)

@foreach($citydata as $city)

<!-- <div class="col-lg-2 col-md-3 col-sm-2">
            <div class="card-deck text-center">
               <div class="card-body m-2 p-0">
                  <a onclick="setCookie('city_name','{{$city->name}}', 365)" href="#" >
                     <img class="card-img-top h-80 w-80 city-modal-img" src="{{ Helper::image_path($city->image) }}" alt="{{trans('labels.city')}}">
                  </a>
                  <div class="card-footer text-dark m-0">
                     {{$city->name}}
                  </div>
               </div>
            </div>
         </div> -->

<div class="px-2 col-lg-2 col-md-2 col-4">

   <a onclick="setCookie('city_name','{{$city->name}}', 365)" href="#">
      <label class="mb-0 border d-block rounded py-3 px-2 my-2 text-center cursor-pointer">
         <img src="{{ Helper::image_path($city->image) }}" alt="Bangalore" class="mb-2 img-fluid">
         <span class="font-size-12 d-block red-hover font-semilight text-nowrap">{{$city->name}}</span>
      </label>
   </a>

</div>

<!--<div class="py-2 font-size-14 d-flex L-height-16 border-bottom text-capitalize">-->
<!--   <span class="icon-pincode fa fa-map-marker text-center align-self-center mr-2"></span>-->
<!--   <span class="">-->
<!--      <a onclick="setCookie('city_name','{{$city->name}}', 365)" class="font-semilight red-hover text-dark d-block w-100" href="#">{{$city->name}}</a>-->
<!--   </span>-->
<!--</div>-->
<?php //if($city->name == 'Prayagraj') break 1; ?>

@endforeach
@else
<div class="text-center">
   {{trans('labels.no_result')}}
</div>
@endif
@endisset