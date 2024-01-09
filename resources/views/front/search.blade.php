@extends('front.layout.main')
@section('page_title',trans('labels.search'))
@section('content')
   <div class="breadcrumb-bar">
      <div class="container-fluid">
         <div class="row">
            <div class="col">
               <div class="breadcrumb-title">
                  <h2>{{trans('labels.find_professional')}}</h2>
               </div>
            </div>
            <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
               <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{trans('labels.search')}}</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>

   <div class="content bg-sec-img">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-3">
               <div class="card filter-card">
                  <div class="card-body">
                     <h4 class="card-title mb-4">{{trans('labels.search_filter')}}</h4>

                     <form id="search_form" action="{{ URL::to('/home/search') }}" method="GET">
                        @csrf
                        <div class="filter-widget">
                           <div class="filter-list">
                              <h4 class="filter-title">{{trans('labels.search_by')}}</h4>
                              <select class="form-control selectbox select" name="search_by" id="search_by" data-next-page="{{URL::to('/home/search')}}">
                                 <option value="service" @isset($filterservice) selected @endisset>{{trans('labels.service')}} </option>
                                 <option value="provider" @isset($providerdata) selected @endisset>{{trans('labels.provider')}} </option>
                              </select>
                              @error('search_by')<small class="text-danger" id="search_by_error"> {{ $message }}</small>@enderror
                           </div>
                           <div class="filter-list">
                              <h4 class="filter-title">{{trans('labels.keyword')}}</h4>
                              <input type="text" class="form-control" id="search_name" name="search_name" @isset($_GET['search_name']) value="{{$_GET['search_name']}}" @endisset placeholder="{{trans('labels.enter_keyword')}}">
                           </div>
                           <div class="filter-list">
                              <h4 class="filter-title">{{trans('labels.sort_by')}}</h4>
                              <select class="form-control selectbox select" name="sort_by" id="sort_by">
                                 <option value="newest"
                                    @isset($_GET['sort_by']) @if($_GET['sort_by'] == "newest") selected @endif @endisset>{{trans('labels.newest')}}</option>
                                 
                                 <option id="low_to_high" value="low_to_high" class="@isset($providerdata) dn @endisset" 
                                    @isset($_GET['sort_by']) @if($_GET['sort_by'] == "low_to_high") selected @endif @endisset>{{trans('labels.low_to_high')}}</option>
                                 
                                 <option id="high_to_low" value="high_to_low" class="@isset($providerdata) dn @endisset" 
                                    @isset($_GET['sort_by']) @if($_GET['sort_by'] == "oldest") selected @endif @endisset>{{trans('labels.high_to_low')}}</option>
                                 
                                 <option value="oldest"
                                    @isset($_GET['sort_by']) @if($_GET['sort_by'] == "oldest") selected @endif @endisset>{{trans('labels.oldest')}}</option>
                              </select>
                           </div>
                           <div class="filter-list @isset($providerdata) dn @endisset " id="category_id">
                              <h4 class="filter-title">{{trans('labels.category')}}</h4>
                              <select class="form-control form-control selectbox select" name="category" id="category" data-show-subtext="true" data-live-search="true">
                                 <option value="" selected disabled>{{trans('labels.select')}}</option>
                                 @foreach($categorydata as $cdata)
                                    <option value="{{$cdata->id}}" @isset($_GET['category']) @if($cdata->id == $_GET['category']) selected @endif @endisset >{{$cdata->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="filter-list">
                              <h4 class="filter-title">City</h4>
                              <select class="form-control selectbox select" name="city" id="city" data-show-subtext="true" data-live-search="true">
                                  <option value="" selected disabled>{{trans('labels.select')}}</option>
                                   @foreach($citydata as $cdata)
                                    <option value="{{$cdata->id}}" @isset($_GET['city']) @if($cdata->id == $_GET['city']) selected @endif @endisset >{{$cdata->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                           <div class="filter-list" style="margin-bottom: 40px;">
                              <h4 class="filter-title">Price</h4>
                              <div class="mall-slider-handles" data-start="{{ $max_price  ?? 0 }}" data-end="{{  10000 }}" data-min="{{ $max_price ?? 0 }}" data-max="{{ 10000 }}" data-target="price" style="width: 100%">
                              </div>
                             <input type="hidden" data-min="price" id="skip-value-lower" name="min_price" value="{{ $max_price  ?? 0 }}" readonly>  
                             <input type="hidden" data-max="price" id="skip-value-upper" name="max_price" value="10000" readonly>
                            </div>
                        </div>
                        <input class="btn btn-black pl-5 pr-5 btn-block get_services" type="submit" value="{{trans('labels.search')}}" >
                     </form>

                  </div>
               </div>
            </div>
            <div class="col-lg-9 pr-0">
               <div class="row align-items-center mb-4">
                  <div class="col-md-12 col mx-3">
                     <h4>
                        @isset($providerdata)
                           {{trans('labels.provider')}}
                        @endisset
                        @isset($servicedata)
                           {{trans('labels.service')}}
                        @endisset
                     </h4>
                  </div>
                  <!-- <div class="col-md-6 col-auto">
                     <div class="view-icons">
                        <a href="javascript:void(0);" class="grid-view active"><i class="fas fa-th-large"></i></a>
                     </div>
                  </div> -->
               </div>
               <div>
                  <div class="row match-height" id="data">

                     @isset($providerdata)
                    
                       <div id="popular-provider-owl" class="row">
                        @foreach($providerdata as $fpdata)
                        <div class="item shadow-none col-lg-4 col-md-6 col-sm-12 mx-0 mb-4">
                          <div class="img">
                             <img src="{{ Helper::image_path($fpdata->provider_image) }}" class="img-fluid" alt="" />
                             <span class="tag"><a href="#">{{$fpdata->provider_type}}</a></span>
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
                             <!-- <div class="rating">
                                <span class="d-inline-block">{{ Helper::distance($fpdata['latitude'], $fpdata['longitude'], 28.704060, 77.102493, "K") }} KM</span>
                            </div> -->
                             <!-- <div class="rating">
                                   <i class="fas fa-star filled"></i>
                                   <span class="d-inline-block average-rating">{{number_format($fpdata['rattings']->avg('ratting'),1)}}</span>
                             </div> -->
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
                           {{--<div class="col-lg-4 col-md-6">
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
                                          <a class="bg-yellow">{{$fpdata->provider_type}}</a>
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
                                          <span class="col-auto ser-contact">
                                             <i class="fas fa-phone-alt mr-1"></i>
                                             <span>{{$fpdata->mobile}}</span>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>--}}
                        @endforeach
                     </div>
                    
                     @endisset
                     
                     @isset($servicedata)
                      
                        @include('front.service_section_search')
                     
                     @endisset
                  
                  </div>

                  <div class="text-center" style="display:none">
                     <button type="button" class="btn btn-outline-dark m-1 ajax-load" onclick="next_page()">{{trans('labels.load_more')}}</button>
                     <p class="text-muted dn no-record">{{trans('labels.no_data')}}</p>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <!-- jquery -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
 
 <!-- Price nouislider-filter cdn -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.css" integrity="sha512-MKxcSu/LDtbIYHBNAWUQwfB3iVoG9xeMCm32QV5hZ/9lFaQZJVaXfz9aFa0IZExWzCpm7OWvp9zq9gVip/nLMg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js" integrity="sha512-T5Bneq9hePRO8JR0S/0lQ7gdW+ceLThvC80UjwkMRz+8q+4DARVZ4dqKoyENC7FcYresjfJ6ubaOgIE35irf4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <style>
         .mall-slider-handles{
         margin-top: 50px;
         }
         .noUi-connect {
            background: #E11F26;
         }
         .noUi-pips-horizontal{display:none;}
          
      </style>
<script>
   $(function () {
           //var $propertiesForm = $('.mall-category-filter');
           //var $body = $('body');
           $('.mall-slider-handles').each(function () {
               var el = this;
               noUiSlider.create(el, {
                   start: [el.dataset.start, el.dataset.end],
                   connect: true,
                   tooltips: true,
                   range: {
                       min: [parseFloat(el.dataset.min)],
                       max: [parseFloat(el.dataset.max)]
                   },
                   pips: {
                       mode: 'range',
                       density: 20
                   }
               }).on('change', function (values) {
                   $('[data-min="' + el.dataset.target + '"]').val(values[0])
                   $('[data-max="' + el.dataset.target + '"]').val(values[1])
                  // $propertiesForm.trigger('submit');
               });
           })
       })     
</script>
@endsection