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
                           </div >
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
   <script>
   $(function () {
    $('select').selectpicker();
});

</script>
   <script type="text/javascript">
      @if(Session::has('success'))
         toastr.options = {
            "closeButton" : true,
            "progressBar" : true
         }
         toastr.success("{{ session('success') }}");
      @endif
      @if(Session::has('error'))
         toastr.options ={
            "closeButton" : true,
            "progressBar" : true,
            "timeOut" : 10000
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
       .booking-list .booking-widget {flex: 0 0 calc(100% - 0px) !important;}
       .booking-list .booking-det-info { width:100%;}
   </style>
   
   <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->
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

</html>