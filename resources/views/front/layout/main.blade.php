<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
   <title>{{Helper::appdata()->website_title}} | @yield('page_title')</title>
   <link rel="shortcut icon" href="{{ Helper::image_path(Helper::appdata()->favicon) }}">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&amp;display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/plugins/fontawesome/css/fontawesome.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/front-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/plugins/fontawesome/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/plugins/owlcarousel/owl.carousel.min.css') }}">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/plugins/owlcarousel/owl.theme.default.min.css') }}">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('storage/app/public/front-assets/css/main-style.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/front-assets/js/toaster/toastr.min.css')}}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/plugins/sweetalert/css/sweetalert.css') }}">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Engagement&display=swap" rel="stylesheet">
   <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css' />
   <meta name="csrf-token" content="{{ csrf_token() }}" />
   @yield('styles')
   <style>
      #modal-content {
         background: #f1f8ff;
      }

      #modal-content h3.modal-title {
         font-size: 21px;
         font-weight: 600;
      }

      #modal-content {}

      #modal-content .form-control {
         min-height: 37px;
         padding: 6px 10px;
      }

      #modal-content .popular-city label.active {
         border-color: #e11f26 !important;
         color: #e11f26;
      }

      #modal-content .popular-city label:hover {
         color: #e11f26;
      }

      #modal-content .Other-City .red_scrollbar {
         overflow-x: auto;
         max-height: 205px;
      }

      #modal-content .Other-City .icon-pincode {
         color: #e11f26;
      }

      .cursor-pointer {
         cursor: pointer;
      }

      .red_scrollbar::-webkit-scrollbar {
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

      .red_scrollbar::-webkit-scrollbar-thumb {
         border-radius: 10px;
         -moz-border-radius: 10px;
         -webkit-border-radius: 10px;
         background-color: #e11f26;
         -webkit-background-color: #e11f26;
         -moz-background-color: #e11f26;
      }

      .red_scrollbar::-webkit-scrollbar-track {
         border-radius: 10px;
         -moz-border-radius: 10px;
         -webkit-border-radius: 10px;
         background-color: #f0f0f0;
         -webkit-background-color: #f0f0f0;
         -moz-background-color: #f0f0f0;
         cursor: pointer;
      }

      #modal-content .popular-city label img {
         height: 50px;
         width: 100%;
         object-fit: cover;
         border-radius: 4px;
      }

      #modal-content .popular-city a{
         color: #000;
      }
   </style>
   
   

</head>
<?php 
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lastUriSegment = array_pop($uriSegments); 
if(empty($lastUriSegment) && $lastUriSegment == '') {
    $lastUriSegment = 'home';
}
?>

<body id="<?php echo $lastUriSegment.'-2'; ?>">

    <div class="page-loading" style="display:none;">
     <div class="preloader-inner">
        <div class="preloader-square-swapping">
           <div class="cssload-square-part cssload-square-green"></div>
           <div class="cssload-square-part cssload-square-pink"></div>
           <div class="cssload-square-blend"></div>
        </div>
     </div>
    </div>

   <div class="main-wrapper">


      @include('front.layout.header_navbar')

      @yield('content')

      <div class="modal fade slow pr-0" id="citiesModal" tabindex="-1" aria-labelledby="citiesModalLabel" aria-modal="true" role="dialog">
         <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content p-4" id="modal-content">
               <div class="row">

                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <h3 class="modal-title mt-0">Select Your Location</h3>
                     <div class="w-75 pt-4 mt-3">
                        <div class="sp-formField mb-2 d-flex position-relative form-group">
                            <div class="form-group">
                               <span class="mb-2 d-block" id="basic-addon1">Search for your city</span>
                               <!--<input name="city" id="ajax_city" url="{{URL::to('/home/find-cities')}}" autocomplete="off" type="text" class="form-control" value="">-->
                               <input type="text" class="form-control" name="city" id="ajax_city" placeholder="{{trans('labels.search_your_city')}}" url="{{URL::to('/home/find-cities')}}" spellcheck="false" autocomplete="off" data-ms-editor="true" aria-describedby="basic-addon1">
                           </div>
                           <div  class="item-list d-flex"></div>

                           <!--<div class="input-group">-->
                           <!--   <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>-->
                           <!--   <input type="text" class="form-control" name="city" id="ajax_city" placeholder="{{trans('labels.search_your_city')}}" url="{{URL::to('/home/find-cities')}}" spellcheck="false" autocomplete="off" data-ms-editor="true" aria-describedby="basic-addon1">-->
                           <!--</div>-->
                           <!--<div  class="item-list d-flex"></div>-->
                           
                        </div>
                     </div>
                  </div>

                  <div class="col-lg-12 col-md-12 col-sm-12">
                     <h6 class="mt-0">Popular City</h6>
                     <div class="px-2 row popular-city match-height" id="city_suggestion">
                         
                        @foreach(Helper::cities() as $cdata)
                        <div class="px-2 col-lg-2 col-md-2 col-4">
                       
                           <a onclick="setCookie('city_name','{{$cdata->name}}', 365)" href="#" >
                              <label class="mb-0 border d-block rounded py-3 px-2 my-2 text-center cursor-pointer">
                                 <img src="{{ Helper::image_path($cdata->image) }}" alt="Bangalore" class="mb-2 img-fluid">
                                 <span class="font-size-12 d-block red-hover font-semilight text-nowrap">{{$cdata->name}}</span>
                              </label>
                           </a>
                           
                        </div>
                        <?php //if($cdata->name == 'Prayagraj') break 1; ?>
                        @endforeach
                     </div>
                  </div>

               </div>

               <!--<div class="mb-3 Other-City row">-->
               <!--   <div class="col-lg-12 col-md-12 col-sm-12">-->
               <!--      <h6>Other City</h6>-->
               <!--      <div class="red_scrollbar px-0 col" id="city_suggestion2">-->
               <!--         @foreach(Helper::cities() as $cdata)-->
               <!--            <div class="py-2 font-size-14 d-flex L-height-16 border-bottom text-capitalize">-->
               <!--               <span class="icon-pincode fa fa-map-marker text-center align-self-center mr-2"></span>-->
               <!--               <span class="">-->
               <!--                  <a onclick="setCookie('city_name','{{$cdata->name}}', 365)" class="font-semilight red-hover text-dark d-block w-100" href="#">{{$cdata->name}}</a>-->
               <!--               </span>-->
               <!--            </div>-->
                          
               <!--         @endforeach -->
               <!--      </div>-->
               <!--   </div>-->
               <!--</div>-->

            </div>
   


         </div>
      </div>

      <div class="modal fade text-left add-rattings" id="add-rattings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h3 class="modal-title" id="myModalLabel35"> {{trans('labels.rattings_reviews')}} </h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               </div>
               <form class="form" id="change_password_form" action="{{ URL::to('/home/user/add-rattings')}}" method="POST">
                  @csrf
                  <div class="form-body">
                     <div class="form-group col-lg-12">
                        @error('service')<span class="text-danger">{{$message}}</span>@enderror
                        @error('provider')<span class="text-danger">{{$message}}</span>@enderror
                     </div>
                     <div class="form-group col-lg-12">
                        <label for="new_password"> {{trans('labels.service')}} </label>
                        <div class="controls">
                           <input type="text" class="form-control" value="{{@$bookingdata->service_name}}" disabled>
                           <input type="hidden" class="form-control" name="service" value="{{@$bookingdata->service_id}}" readonly>
                           <input type="hidden" class="form-control" name="provider" value="{{@$bookingdata->provider_id}}" readonly>
                        </div>
                     </div>

                     <div class="form-group col-lg-12 text-center">
                        <div class="star-rating">
                           <input id="five" type="radio" name="rating" value="five" onclick="$('#ratting').val('5');" />
                           <label for="five"><i class="active fa fa-star" aria-hidden="true"></i></label>
                           <input id="four" type="radio" name="rating" value="four" onclick="$('#ratting').val('4');" />
                           <label for="four"><i class="active fa fa-star" aria-hidden="true"></i></label>
                           <input id="three" type="radio" name="rating" value="three" onclick="$('#ratting').val('3');" />
                           <label for="three"><i class="active fa fa-star" aria-hidden="true"></i></label>
                           <input id="two" type="radio" name="rating" value="two" onclick="$('#ratting').val('2');" />
                           <label for="two"><i class="active fa fa-star" aria-hidden="true"></i></label>
                           <input id="one" type="radio" name="rating" value="one" onclick="$('#ratting').val('1');" />
                           <label for="one"><i class="active fa fa-star" aria-hidden="true"></i></label>
                           <span class="result"></span>
                        </div>
                        <input type="hidden" name="ratting" id="ratting">
                        @error('ratting')<br><span class="text-danger">{{$message}}</span>@enderror
                     </div>
                     <div class="form-group col-lg-12">
                        <textarea name="message" rows="4" class="form-control" placeholder="{{trans('labels.message')}}" required>{{old('message')}}</textarea>
                        @error('message')<span class="text-danger">{{$message}}</span>@enderror
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                        <input type="submit" id="btn_update_password" class="btn btn-raised btn-primary" value="{{trans('labels.add')}}">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>

      <footer class="footer">
         <div class="footer-top">
            <div class="container-fluid">
               <div class="row">

                  <div class="col-lg-3 col-md-6">
                     <div class="footer-widget footer-contact">
                        <h2 class="footer-title">{{trans('labels.contact_us')}}</h2>
                        <div class="footer-contact-info">
                           <div class="footer-address">
                              <span><i class="far fa-building"></i></span>
                              <p>{{Helper::appdata()->address}}</p>
                           </div>
                           <p><i class="fas fa-headphones"></i>{{Helper::appdata()->contact}}</p>
                           <p class="mb-0"><i class="fas fa-envelope"></i> {{Helper::appdata()->email}} </p>
                        </div>
                     </div>
                  </div>

                  <div class="col-lg-3 col-md-6">
                     <div class="footer-widget footer-menu">
                        <h2 class="footer-title">{{trans('labels.categories')}}</h2>
                        <ul>
                           @foreach(Helper::categories() as $categories)
                           <li><a href="{{URL::to('/home/services/'.$categories->slug)}}">{{$categories->name}}</a></li>
                           @endforeach
                        </ul>
                     </div>
                  </div>



                  <div class="col-lg-3 col-md-6">
                     <div class="footer-widget footer-menu">
                        <h2 class="footer-title">{{trans('labels.quick_links')}}</h2>
                        <ul>
                           <li><a href="{{ URL::to('/home/providers') }}">{{trans('labels.providers')}}</a></li>
                           <li><a href="{{URL::to('/home/about-us')}}">{{trans('labels.about_us')}}</a></li>
                           <li><a href="{{URL::to('/home/contact-us')}}">{{trans('labels.contact_us')}}</a></li>
                           <li>
                              @if(Auth::check() && (Auth::user()->type == 4) )
                              <a href="{{URL::to('/home/help')}}">{{trans('labels.help')}}</a>
                              @else
                              <a href="{{URL::to('/home/login')}}">{{trans('labels.help')}}</a>
                              @endif
                           </li>
                        </ul>
                     </div>
                  </div>

                  <div class="col-lg-3 col-md-6">
                     <div class="footer-widget">
                        <h2 class="footer-title">{{trans('labels.follow_us')}}</h2>
                        <div class="social-icon">
                           <ul>
                              <li><a href="{{Helper::appdata()->facebook_link}}" target="_blank"><i class="fab fa-facebook-f"></i> </a></li>
                              <li><a href="{{Helper::appdata()->instagram_link}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                              <li><a href="{{Helper::appdata()->linkedin_link}}" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                              <li><a href="{{Helper::appdata()->twitter_link}}" target="_blank"><i class="fab fa-twitter"></i> </a></li>
                           </ul>
                        </div>
                        <div class="subscribe-form">
                           <form action="{{URL::to('/subscribe')}}" method="POST">
                              @csrf
                              <input type="email" class="form-control @error('sub_email') border-danger @enderror" name="sub_email" placeholder="{{trans('labels.enter_email')}}">
                              <button type="submit" class="btn footer-btn"><i class="fas fa-paper-plane"></i></button>
                              @error('sub_email')<span class="text-danger">{{$message}}</span>@enderror
                           </form>
                        </div>
                     </div>
                  </div>

               </div>
            </div>
         </div>

         <div class="footer-bottom">
            <div class="container-fluid">
               <div class="copyright">
                  <div class="row">
                     <div class="col-md-6 col-lg-6">
                        <div class="copyright-text">
                           <p class="mb-0">{{helper::appdata()->copyright}}</p>
                        </div>
                     </div>
                     <div class="col-md-6 col-lg-6">
                        <div class="copyright-menu">
                           <ul class="policy-menu">
                              <li><a href="{{URL::to('/home/terms-condition')}}">{{trans('labels.terms_conditions')}}</a></li>
                              <li><a href="{{URL::to('/home/privacy-policy')}}">{{trans('labels.privacy_policy')}}</a></li>
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </footer>

   </div>
</body>

@include('cookieConsent::index')
<script src="{{ asset('storage/app/public/front-assets/js/jquery-3.5.0.min.js')}}"></script>
<script src="{{ asset('storage/app/public/front-assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('storage/app/public/front-assets/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{ asset('storage/app/public/front-assets/js/script.js')}}"></script>
<script src="{{ asset('storage/app/public/front-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/plugins/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script src="{{ asset('storage/app/public/front-assets/booking.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/front-assets/checkout.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/front-assets/home.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/front-assets/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/front-assets/search.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/front-assets/wallet.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/front-assets/js/custom.js')}}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js'>
   < script >
      $(function() {
         $('select').selectpicker();
      });
</script>
<script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
       });
   </script>
<script type="text/javascript">
   @if(Session::has('success'))
   toastr.options = {
      "closeButton": true,
      "progressBar": true
   }
   toastr.success("{{ session('success') }}");
   @endif
   @if(Session::has('error'))
   toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "timeOut": 10000
   }
   toastr.error("{{ session('error') }}");
   @endif
</script>
@yield('scripts')

<style>
   /* .tag-2 span {display:none;} */
   .kilomiter-tag {
      background: #e11f26;
      color: #fff;
      padding: 1px 5px;
      border-radius: 5px;
      font-size: 10px;
      font-weight: 400;
      display: inline-block;
      position: absolute;
      top: 45px;
      right: 15px;
   }

   .booking-list .booking-widget {
      flex: 0 0 calc(100% - 0px) !important;
   }

   .booking-list .booking-det-info {
      width: 100%;
   }
</style>

</html>