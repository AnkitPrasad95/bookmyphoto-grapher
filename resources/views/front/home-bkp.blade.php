@extends('front.layout.main')
@section('page_title',trans('labels.home'))
@section('content')

<style>
   .custom-select {
  width: 100%;
  position: relative;
  /* margin: 20px 0; */
  border:0px;
  height: 57px;
    padding: 18px 10px;
    font-size: 15px;
    color: #646464;
}

.custom-select select {
  display: block;
}

.custom-select .selected-item {
   background: #fff;
    color: #000;
  /* padding: 5px 20px; */
  cursor: pointer;
  z-index: 99;
  text-align: left;
}

.custom-select .selected-item:after {
  font-family: FontAwesome;
  content: "\f107";
  font-size: 20px;
  color: #505050;
  position: absolute;
  right: 10px;
  transition: 0.5s;
}

.custom-select .arrowanim.selected-item:after {
  transform: rotate(180deg);
}

.custom-select .item {
   background: #ffffff;
    color: #1e1e1e;
    border-top: 1px solid #ebebeb;
    cursor: pointer;
    text-align:left;
    padding: 4px 10px;
}

.custom-select .item:hover {
   background: #e11f26;
    color: #fff;
}

.custom-select .all-items {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  z-index: 100;
  max-height: 150px;
    overflow-y: scroll;
}

.custom-select .all-items::-webkit-scrollbar {
    background-color: #e11f26;
    -webkit-background-color: #e11f26;
    -moz-background-color: #e11f26;
    width: 10px;
    background-color: #f0f0f0;
    border-radius: 10px;
    -webkit-width: 10px;
    -moz-width: 10px;
    -webkit-background-color: #f0f0f0;
    -moz-background-color: #f0f0f0;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
}

.custom-select .all-items::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    background-color: #e11f26;
    -webkit-background-color: #e11f26;
    -moz-background-color: #e11f26;
}

.custom-select .all-items::-webkit-scrollbar-track {
    border-radius: 10px;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    background-color: #f0f0f0;
    -webkit-background-color: #f0f0f0;
    -moz-background-color: #f0f0f0;
    cursor: pointer;
}

.custom-select .all-items-hide {
  display: none;
}

.custom-select .sdf {
  border: 1px solid red;
}


</style>

<section class="hero-section">
   <div class="layer">
      <div class="home-banner" style="background-image:url('{{Helper::image_path(Helper::appdata()->banner)}}')"></div>
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-lg-12">
               <div class="section-search">
                  <h3>Request to your Pocket Friendly </br>Photographer</h3>
                  <p>Search From Awesome Verified Services</p>
                  <!-- <h3>{{trans('labels.banner_main_title')}}</h3>
                     <p>{{trans('labels.banner_sub_title')}}</p> -->
                     <div class="row">
                        <div class="col-lg-4 col-md-5">
                           <!--<div class="search-box  d-block mr-3">-->
                           <!--   <div class="custom-select">-->
                           <!--      <select class="select_cat js-example-programmatic">-->
                           <!--         <option value="">Select any Category</option>-->
                           <!--         @if(!empty($searchcategorydata))-->
                           <!--         @foreach($searchcategorydata as $categorydataRow)-->
                           <!--         <option value="{{ $categorydataRow->id }}">{{ $categorydataRow->name }}</option>-->
                           <!--         @endforeach-->
                           <!--         @endif-->
                           <!--      </select>-->
                           <!--   </div>-->
                           <!--</div>-->
                           <div class="search-box  d-block mr-3">
								<div class="question-add-dropdown" id="mydiv">
									<select class="form-control custom-select select_cat">
									    <option value="">Select any Category</option>
										@if(!empty($searchcategorydata))
                                        @foreach($searchcategorydata as $categorydataRow)
                                        
										<option value="{{ $categorydataRow->id}}">{{ $categorydataRow->name }}</option>
										@endforeach
										@endif
									</select>
								</div>
							</div>
                        </div>

                        <div class="col-lg-8 col-md-7">
                           <div class="search-box w-100">
                              <div class="search-input w-100">
                                 <i class="fas fa-search bficon"></i>
                                 <div class="form-group mb-0"><!-- placeholder="{{trans('labels.looking_for_service')}}" -->
                                    <!--<input type="text" class="form-control" name="search_box" id="search_box" placeholder="Looking for services?" url="{{URL::to('/home/find-service')}}">-->
                                    <input type="text" class="form-control" name="search_box" id="search_input" placeholder="Looking for services?">
                                    <div class="item-list" id="suggestion"></div>
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
</section>

<!-- @if(!empty($bannerdata) && count($bannerdata)>0)
      <section class="popular-services">
         <div class="container-fluid">
            <div class="row">
               <div class="col-lg-12">
                  <div class="service-carousel">
                     <div class="service-slider owl-carousel owl-theme">
                        @foreach($bannerdata as $bdata)
                           <div class="service-widget">
                              <a href="@if($bdata['service_id'] != '') {{URL::to('/home/service-details/'.$bdata['service_slug'])}} @elseif($bdata['category_id'] != '') {{URL::to('/home/services/'.$bdata['category_slug'])}} @else href='#' @endif ">
                                 <img class="img-fluid serv-imgn rounded popular-services-img" src="{{ Helper::image_path($bdata['image']) }}" alt="{{trans('labels.service_image')}}">
                              </a>
                           </div>
                        @endforeach
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   @endif -->

<section class="about-sec">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-6 col-md-6 align-self-center">
            <div class="content p-0 m-0">
               <h2>Start As <span class="text-primary-color">Photographer</span></h2>
               <p>The Moto of BMP is to make available a photographer at any location in India either On - Demand or on a Scheduled day to capture your moments </p>
               <ul>
                  <li>India’s largest online platform to sync a camera with moments</li>
                  <li>Fastest, and most efficient way to book a Photographer!</li>
                  <li>Photographers that fits into Budget</li>
               </ul>

               <a href="/home/register-provider" class="mt-4">Become Photographer</a>
            </div>
         </div>

         <div class="col-lg-6 col-md-6">
            <div class="img">
               <img src="{{ Helper::image_path('about-sec-img.jpg') }}" class="img-fluid" alt="">
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Category section -->
<section class="category-section">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="row">
               <div class="col-md-6">
                  <div class="heading">
                     <h2>{{trans('labels.featured_categories')}}</h2>
                     <span>{{trans('labels.what_looking_for')}}</span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="viewall d-none d-lg-block d-md-block">
                     <h4><a href="{{URL::to('/home/categories')}}"> {{trans('labels.view_all')}} <i class="fas fa-angle-right"></i></a></h4>
                     <!-- <span>{{trans('labels.featured_categories')}}</span> -->
                  </div>
               </div>
            </div>
            @include('front.category_section')

            <div class="viewall d-block d-lg-none d-md-none text-center mt-3">
               <h4><a href="{{URL::to('/home/categories')}}"> {{trans('labels.view_all')}} <i class="fas fa-angle-right"></i></a></h4>
               <!-- <span>{{trans('labels.featured_categories')}}</span> -->
            </div>
         </div>
      </div>
   </div>
</section>


<!-- Services section -->
<section class="popular-services pb-0">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="row">
               <div class="col-md-6">
                  <div class="heading">
                     <h2>{{trans('labels.popular_services')}}</h2>
                     <span>{{trans('labels.explore_services')}}</span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="viewall d-none d-lg-block d-md-block">
                     <h4><a href="{{URL::to('/home/services')}}">{{trans('labels.view_all')}}<i class="fas fa-angle-right"></i></a></h4>
                     <!-- <span>{{trans('labels.most_popular')}}</span> -->
                  </div>
               </div>
            </div>


            <div class="catsec">
               @if(!empty($servicedata) && count($servicedata)>0)
               <div class="row">
                  @if(Route::current()->uri() === '/')
                  @include('front.service_section')
                  @else
                  @include('front.service_section_list')
                  @endif
               </div>
               @else
               <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>

            <div class="viewall d-block d-lg-none d-md-none text-center">
               <h4><a href="{{URL::to('/home/services')}}">{{trans('labels.view_all')}}<i class="fas fa-angle-right"></i></a></h4>
               <!-- <span>{{trans('labels.most_popular')}}</span> -->
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Providers section -->
<section class="popular-services">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="row">
               <div class="col-md-6">
                  <div class="heading">
                     <h2>{{trans('labels.top_providers')}}</h2>
                     <span>{{trans('labels.trust_providers')}}</span>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="viewall d-none d-lg-block d-md-block">
                     <h4><a href="{{URL::to('/home/providers')}}">{{trans('labels.view_all')}}<i class="fas fa-angle-right"></i></a></h4>
                     <!-- <span>{{trans('labels.top_providers')}}</span> -->
                  </div>
               </div>
            </div>

            <div class="catsec">
               @if(!empty($providerdata) && count($providerdata)>0)
               <div class="row">
                  @if(Route::current()->uri() === '/')
                  @include('front.provider_section')
                  @else
                  @include('front.provider_section_list')
                  @endif
               </div>
               @else
               <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>

            <div class="viewall d-block d-lg-none d-md-none text-center">
               <h4><a href="{{URL::to('/home/providers')}}">{{trans('labels.view_all')}}<i class="fas fa-angle-right"></i></a></h4>
               <!-- <span>{{trans('labels.top_providers')}}</span> -->
            </div>
         </div>
      </div>
   </div>
</section>
<section id="app-sec" class="">
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12 col-md-6 col-lg-5 align-self-center">
            <div class="contents">
               <h3>Get the BookMyPhotographer <br>app</h3>
               <p>Book your Photographer & that <br>fits into Budget</p>
               <div class="d-flex mt-lg-5 mt-4">
                  <div class="mr-3">
                     <img src="{{ Helper::image_path('logo-android.webp') }}" class="img-fluid" />
                  </div>
                  <div class="">
                     <img src="{{ Helper::image_path('logo-ios.webp') }}" class="img-fluid" />
                  </div>
               </div>
            </div>
         </div>

         <div class="col-sm-12 col-md-6 col-lg-7">
            <img src="{{ Helper::image_path('logo-bg-app.jpg') }}" class="img-fluid app-img" />
         </div>
      </div>
   </div>
</section>
@include('front.how_work')


@endsection
<!--<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>-->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#search_input').on('input', function () {
            // Get the search query from the input field
            var service = $(this).val();
            var select_cat = $('.select_cat').val();
            //console.log(service, select_cat);
            // Send an AJAX request to the Laravel route for search
            $.ajax({
                method: 'POST',
                url: '{{URL::to('/home/find-service')}}',
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { "query": service, "select_cat": select_cat },
                success: function (response) {
                    
                    const data = JSON.parse(response);
                    if(data.services.length > 0) {
                        var SITEURL = window.location.origin;
                    
                        dataSet = '<div class="text-left mt-1">';
                            dataSet +='<ul class="list-group suggestion_scroll col-sm-12 col-md-12 col-lg-12 ">';
                              data.services.forEach(function(element) {
                                  var fullURL = SITEURL + '/home/service-details/'+element.service_slug;
                               dataSet +='<li class="list-group-item"><a href="'+fullURL+'" class="text-dark" style="font-weight: bolder;">'+element.service_name+'</a></li>';
                              });
                           dataSet +='</ul>';
                        dataSet +='</div>';
                    } else {
                        dataSet = '';
                    }
                    
                    
                    

                    $('#suggestion').html(dataSet);

                    
                },
                error: function (error) {
                    console.error(error);
                }
            });
        });
    });
</script>
<script>
//   (function($) {
//       $(document).ready(function() {
//          var customSelect = $(".custom-select");

//          customSelect.each(function() {
//             var thisCustomSelect = $(this),
//               options = thisCustomSelect.find("option"),
//               firstOptionText = options.first().text();

//             var selectedItem = $("<div></div>", {
//                   class: "selected-item"
//               })
//               .appendTo(thisCustomSelect)
//               .text(firstOptionText);

//             var allItems = $("<div></div>", {
//               class: "all-items all-items-hide"
//             }).appendTo(thisCustomSelect);

//             options.each(function() {
//               var that = $(this),
//                   optionText = that.text();

//               var item = $("<div></div>", {
//                      class: "item",
//                      on: {
//                         click: function() {
//                           var selectedOptionText = that.text();
//                           selectedItem.text(selectedOptionText).removeClass("arrowanim");
//                           allItems.addClass("all-items-hide");
//                         }
//                      }
//                   })
//                   .appendTo(allItems)
//                   .text(optionText);
//             });
//          });

//          var selectedItem = $(".selected-item"),
//             allItems = $(".all-items");

//          selectedItem.on("click", function(e) {
//             var currentSelectedItem = $(this),
//               currentAllItems = currentSelectedItem.next(".all-items");

//             allItems.not(currentAllItems).addClass("all-items-hide");
//             selectedItem.not(currentSelectedItem).removeClass("arrowanim");

//             currentAllItems.toggleClass("all-items-hide");
//             currentSelectedItem.toggleClass("arrowanim");

//             e.stopPropagation();
//          });

//          $(document).on("click", function() {
//             var opened = $(".all-items:not(.all-items-hide)"),
//               index = opened.parent().index();

//             customSelect
//               .eq(index)
//               .find(".all-items")
//               .addClass("all-items-hide");
//             customSelect
//               .eq(index)
//               .find(".selected-item")
//               .removeClass("arrowanim");
//          });
//       });
//   })(jQuery);


</script>