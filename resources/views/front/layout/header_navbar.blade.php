         <style>
            .header .main-nav a.nav-link.Intant_Booking {
               border: 1px solid #fff;
               border-width: 1px;
               border-radius: 10px;
               line-height: normal;
               vertical-align: middle;
               padding: 10px 20px !important;
               display: block;
               margin-top: 20px;
               background: #fff;
               color: #e11f26;
            }

            .header .main-nav a.nav-link.Intant_Booking:after {
               display: none;
            }

            .IntantBooking {
               position: fixed;
               top: 116px;
               background: #000;
               border-radius: 5px;
               left: 0;
               right: 0;
               margin: 0 auto;
               text-align: center;
               width: fit-content;
               z-index: 99;
            }

            .IntantBooking  a{
               outline: double 2px #e11f26;
               color: #fff;
               display: block;
               padding: 8px 10px;
               border: 2px double #ffffff;
               box-shadow: 0 0 11px 0 #2f2f2f;
               border-radius: 5px;
            }
         </style>
         <header class="header">
            <div class="top-bar">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-lg-6 col-8">
                        <div class="d-flex">
                           <a href="tel:+12345678910" class="mr-2 d-flex text-nowrap font-semiBold">
                              <span class="mr-2"> Call to Book</span>
                              <span class="mr-2" style="width:12px;">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024" class="img-fluid call-icon">
                                    <path fill="#FFFFFF" d="M941.838 672.142c-62.694 0-124.256-9.805-182.586-29.082-28.582-9.752-63.725-.806-81.171 17.107l-115.136 86.918c-133.528-71.277-215.779-153.501-286.083-286.026l84.36-112.138c21.917-21.888 29.779-53.862 20.36-83.862-19.36-58.64-29.195-120.168-29.195-182.888C352.39 36.861 315.529 0 270.222 0H82.168C36.862 0 0 36.861 0 82.168 0 601.502 422.501 1024 941.837 1024c45.306 0 82.163-36.864 82.163-82.17V754.304c0-45.306-36.864-82.163-82.163-82.163z"></path>
                                 </svg>
                              </span>
                              <span>{{Helper::appdata()->contact}}</span>
                           </a>


                           <div class="col-auto border-left d-lg-flex d-none d-md-flex col">
                              <div class="mr-2" style="width:15px;">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024" class="img-fluid mail-icon">
                                    <path fill="#FFFFFF" d="M597.582 622.808c-25.478 17.309-55.07 26.458-85.58 26.458s-60.101-9.149-85.577-26.458L6.818 337.728A152.69 152.69 0 0 1 0 332.802v467.136C0 853.496 42.65 896 94.266 896h835.47c52.556 0 94.262-43.464 94.262-96.062V332.8a149.44 149.44 0 0 1-6.83 4.937L597.58 622.809z"></path>
                                    <path fill="#FFFFFF" d="m40.101 295.722 419.606 277.331c15.884 10.499 34.089 15.747 52.291 15.747 18.206 0 36.413-5.25 52.296-15.747L983.9 295.722c25.114-16.586 40.1-44.344 40.1-74.303 0-51.513-42.274-93.42-94.234-93.42H94.235c-51.96.002-94.234 41.909-94.234 93.47 0 29.909 14.992 57.668 40.1 74.253z"></path>
                                 </svg>
                              </div>
                              <a href="mailto:{{Helper::appdata()->email}}"> {{Helper::appdata()->email}}</a>
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-6 col-4">
                        <div class="d-flex justify-content-end">
                             <!--<li>-->
                             <!--   <a href="javascript:void(0);" class="nav-link" data-toggle="modal" data-target="#citiesModal" aria-expanded="false" id="selected_city"></a>-->
                             <!--</li>-->
                           <div class="text-white"><span><i class="fa fa-map-marker d-inline-block mr-2 fontAwesome4" aria-hidden="true"></i></span><a href="javascript:void(0);" class="nav-link p-0 d-inline-block" data-toggle="modal" data-target="#citiesModal" aria-expanded="false" id="selected_city"></a></div>
                           <div class="d-lg-block d-none d-md-block ml-3 pl-2  border-left">
                              <ul class="list-unstyled mb-0">
                                 <!-- <li>-->
                                 <!--   <a href="javascript:void(0)" rel="noreferrer" target="_blank" class="d-block" style="width:15px;">-->
                                 <!--      <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024" fill="#FFFFFF" class="img-fluid">-->
                                 <!--         <path d="M674.537 170.027h93.485V7.211C751.894 4.992 696.425 0 631.829 0 497.045 0 404.714 84.779 404.714 240.597V384H255.978v182.016h148.736V1024h182.357V566.059h142.717l22.656-182.016H587.028V258.645c.043-52.608 14.208-88.618 87.508-88.618z"></path>-->
                                 <!--       </svg>-->


                                 <!--   </a>-->
                                 <!--</li>-->
                                 <li>
                                    <a href="{{Helper::appdata()->facebook_link}}" rel="noreferrer" target="_blank" class="d-block" style="width:15px;">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" class="img-fluid" viewBox="0 0 1024 1024">
                                          <path fill="#FFFFFF" d="M674.537 170.027h93.485V7.211C751.894 4.992 696.425 0 631.829 0 497.045 0 404.714 84.779 404.714 240.597V384H255.978v182.016h148.736V1024h182.357V566.059h142.717l22.656-182.016H587.028V258.645c.043-52.608 14.208-88.618 87.508-88.618z"></path>
                                       </svg>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="{{Helper::appdata()->twitter_link}}" rel="noreferrer" target="_blank" class="d-block" style="width:15px;">
                                       <svg version="1.1" xmlns="http://www.w3.org/2000/svg" class="img-fluid" width="1024" height="1024" viewBox="0 0 1024 1024">
                                          <g id="twitterIcon"></g>
                                          <path fill="#FFFFFF" d="M1097.143 149.139c-43.52 19.090-89.893 31.744-138.24 37.888 49.737-29.696 87.698-76.361 105.545-132.608-46.373 27.648-97.573 47.177-152.137 58.075-44.032-46.885-106.789-75.922-175.25-75.922-132.827 0-239.762 107.813-239.762 239.982 0 19.017 1.609 37.303 5.559 54.711-199.461-9.728-375.954-105.326-494.519-250.953-20.699 35.913-32.841 77.019-32.841 121.271 0 83.090 42.789 156.745 106.569 199.387-38.546-0.731-76.361-11.922-108.398-29.55 0 0.731 0 1.682 0 2.633 0 116.59 83.163 213.431 192.219 235.739-19.529 5.339-40.814 7.899-62.903 7.899-15.36 0-30.866-0.878-45.422-4.096 31.086 95.013 119.296 164.864 224.183 167.131-81.627 63.854-185.271 102.327-297.472 102.327-19.675 0-38.546-0.878-57.417-3.291 106.277 68.535 232.229 107.666 368.055 107.666 441.49 0 682.862-365.714 682.862-682.715 0-10.606-0.366-20.846-0.878-31.013 47.616-33.792 87.625-75.995 120.247-124.562z"></path>
                                       </svg>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="#" rel="noreferrer" target="_blank" class="d-block" style="width:15px;">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" class="img-fluid" viewBox="0 0 1024 1024">
                                          <path fill="#FFFFFF" d="M1013.6 307.3s-10-70.6-40.8-101.6c-39-40.8-82.6-41-102.6-43.4C727 151.9 512 151.9 512 151.9h-.4s-215 0-358.2 10.4c-20 2.4-63.6 2.6-102.6 43.4-30.8 31-40.6 101.6-40.6 101.6S0 390.1 0 473.1v77.6c0 82.8 10.2 165.8 10.2 165.8s10 70.6 40.6 101.6c39 40.8 90.2 39.4 113 43.8 82 7.8 348.2 10.2 348.2 10.2s215.2-.4 358.4-10.6c20-2.4 63.6-2.6 102.6-43.4 30.8-31 40.8-101.6 40.8-101.6s10.2-82.8 10.2-165.8v-77.6c-.2-82.8-10.4-165.8-10.4-165.8zM406 644.9V357.1l276.6 144.4L406 644.9z"></path>
                                       </svg>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="{{Helper::appdata()->instagram_link}}" rel="noreferrer" target="_blank" class="d-block" style="width:15px;">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" class="img-fluid" viewBox="0 0 1024 1024">
                                          <path fill="#FFFFFF" d="M1021.297 301.056c-2.4-54.409-11.194-91.814-23.802-124.227-12.998-34.405-33.005-65.208-59.213-90.815-25.606-26.005-56.614-46.212-90.618-59.011C815.062 14.399 777.853 5.6 723.446 3.202 668.63.6 651.228-.002 512.199-.002 373.172-.002 355.77.6 301.158 2.999c-54.409 2.399-91.815 11.205-124.22 23.802-34.413 13.003-65.216 33.006-90.822 59.215-26.005 25.607-46.204 56.612-59.011 90.62-12.604 32.608-21.403 69.811-23.801 124.22C.702 355.671.1 373.073.1 512.1c0 139.03.602 156.431 3.001 211.043C5.5 777.549 14.306 814.957 26.91 847.367c13.002 34.406 33.202 65.21 59.207 90.816 25.606 26.003 56.612 46.214 90.619 59.014 32.608 12.602 69.811 21.402 124.227 23.802 54.605 2.406 72.014 3.002 211.041 3.002s156.428-.595 211.039-3.002c54.413-2.4 91.814-11.2 124.224-23.802 68.813-26.611 123.226-81.018 149.83-149.83 12.595-32.608 21.402-69.818 23.802-124.224 2.4-54.611 3.002-72.013 3.002-211.043 0-139.027-.205-156.429-2.605-211.041zm-92.211 418.083c-2.202 50.01-10.605 77.011-17.606 95.014-17.203 44.614-52.608 80.019-97.222 97.222-18.003 7.002-45.203 15.405-95.014 17.6-54.01 2.406-70.208 3.002-206.839 3.002-136.628 0-153.03-.595-206.845-3.002-50.01-2.195-77.014-10.598-95.018-17.6-22.2-8.205-42.406-21.203-58.808-38.208-17.003-16.608-30.006-36.608-38.211-58.81-7.001-18.003-15.401-45.21-17.597-95.021-2.407-54.01-3.001-70.214-3.001-206.842s.594-153.03 3.001-206.837c2.196-50.01 10.596-77.015 17.597-95.019 8.205-22.207 21.208-42.406 38.414-58.816 16.596-17.004 36.601-30.006 58.808-38.203 18.003-7.002 45.212-15.402 95.018-17.605 54.01-2.399 70.216-3 206.836-3 136.833 0 153.031.602 206.842 3 50.01 2.204 77.018 10.604 95.021 17.605 22.202 8.197 42.406 21.199 58.81 38.203 17.005 16.605 30.003 36.609 38.208 58.816 7.002 18.004 15.405 45.204 17.606 95.019 2.4 54.01 3.002 70.209 3.002 206.837s-.602 152.634-3.002 206.644z"></path>
                                          <path fill="#FFFFFF" d="M512.184 249.044c-145.224 0-263.052 117.82-263.052 263.052s117.828 263.05 263.052 263.05c145.235 0 263.052-117.818 263.052-263.05S657.418 249.044 512.184 249.044zm0 433.686c-94.214 0-170.635-76.413-170.635-170.634s76.421-170.635 170.635-170.635c94.221 0 170.636 76.413 170.636 170.635S606.405 682.73 512.184 682.73zM847.057 238.644c0 33.913-27.501 61.411-61.421 61.411-33.914 0-61.408-27.498-61.408-61.411 0-33.921 27.494-61.411 61.408-61.411 33.92 0 61.421 27.49 61.421 61.411z"></path>
                                       </svg>
                                    </a>
                                 </li>
                                 <li>
                                    <a href="{{Helper::appdata()->linkedin_link}}" rel="noreferrer" target="_blank" class="d-block" style="width:15px;"><svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" class="img-fluid" viewBox="0 0 1024 1024">
                                          <path fill="#FFFFFF" d="M1023.741 1024v-.045h.256V648.403c0-183.721-39.552-325.247-254.336-325.247-103.258 0-172.547 56.661-200.835 110.379h-2.987v-93.227H362.19v683.647h212.054V685.44c0-89.131 16.896-175.318 127.276-175.318 108.755 0 110.381 101.718 110.381 181.033V1024h211.84zM16.909 340.351h212.309V1024H16.909V340.351zM122.968 0C55.086 0 .003 55.083.003 122.965s55.083 124.118 122.965 124.118c67.883 0 122.966-56.235 122.966-124.118C245.891 55.083 190.808 0 122.968 0z"></path>
                                       </svg>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>


                  </div>
               </div>
            </div>
            <nav class="navbar navbar-expand-lg header-nav">
               <div class="navbar-header">
                  <a id="mobile_btn" href="javascript:void(0);">
                     <span class="bar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                     </span>
                  </a>
                  <a href="{{ URL::to('/') }}" class="navbar-brand logo"><img src="{{ Helper::image_path(Helper::appdata()->logo)}}" class="img-fluid" alt="Logo"></a>
                  <a href="{{ URL::to('/') }}" class="navbar-brand logo-small"><img src="{{ Helper::image_path(Helper::appdata()->logo)}}" class="img-fluid" alt="Logo"></a>
               </div>
               <div class="main-menu-wrapper">
                  <div class="menu-header">
                     <a href="{{ URL::to('/') }}" class="menu-logo"><img src="{{ Helper::image_path(Helper::appdata()->logo) }}" class="img-fluid" alt="Logo"></a>
                     <a id="menu_close" class="menu-close" href="javascript:void(0);"> <i class="fas fa-times"></i></a>
                  </div>
                  <ul class="main-nav">
                      <li><a href="{{URL::to('/home/instant-booking')}}" class="nav-link Intant_Booking">Instant Booking</a></li>
                     <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ URL::to('/') }}">{{trans('labels.home')}}</a></li>
                     <!-- <li class="{{ request()->is('home/categories*') ? 'active' : '' }}"><a href="{{ URL::to('/home/categories') }}">{{trans('labels.categories')}}</a></li> -->
                     <li class="{{ request()->is('home/services*') ? 'active' : '' }}"><a href="{{ URL::to('/home/services') }}">{{trans('labels.services')}}</a></li>
                     <li class="{{ request()->is('home/search*') ? 'active' : '' }}"><a href="{{ URL::to('/home/search') }}">{{trans('labels.search')}}</a></li>
                     @if (!Session::get('id'))
                     <li class="{{ request()->is('home/register-provider*') ? 'active' : '' }}"><a href="{{ URL::to('/home/register-provider') }}">Create Your Studio</a></li> <!--{{trans('labels.become_provider')}} -->
                     <li class="{{ request()->is('home/login*') ? 'active' : '' }} "><a href="{{ URL::to('/home/login') }}">{{trans('labels.login')}}</a></li>
                     @endif
                     <!--<li>-->
                     <!--   <a href="javascript:void(0);" class="nav-link" data-toggle="modal" data-target="#citiesModal" aria-expanded="false" id="selected_city"></a>-->
                     <!--</li>-->

                     
                  </ul>
               </div>
               <ul class="nav header-navbar-rht">
                  @if (Session::get('id'))
                  <li class="nav-item desc-list wallet-menu">
                     <a href="{{URL::to('/home/user/wallet')}}" class="nav-link header-login">
                        <img src="{{Helper::image_path('wallet.png')}}" alt="" class="mr-2 wallet-img" /><span>{{trans('labels.wallet')}}</span> : {{Helper::currency_format(Helper::wallet())}}
                     </a>
                  </li>
                  <li class="nav-item dropdown logged-item">
                     <a href="" onclick="clearnotification('{{ URL::to('/home/user/clearnotification') }}','{{URL::to('/home/user/notifications')}}')" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @if(Helper::notification() > 0)
                        <span class="badge badge-pill bg-yellow">{{Helper::notification()}}</span>
                        @endif
                     </a>
                  </li>
                  <li class="nav-item dropdown has-arrow logged-item">
                     <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false">
                        <span class="user-img">
                           <img class="rounded-circle" src="{{Helper::image_path(@Auth::user()->image)}}" alt="" />
                        </span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right left-auto">
                        <a class="dropdown-item" href="{{URL::to('/home/user/dashboard')}}">{{trans('labels.dashboard')}}</a>
                        <a class="dropdown-item" href="{{URL::to('/home/user/bookings')}}">{{trans('labels.my_bookings')}}</a>
                        <a class="dropdown-item" href="{{URL::to('/home/user/profile')}}">{{trans('labels.profile_settings')}}</a>
                        <a class="dropdown-item" href="{{URL::to('/logout')}}">{{ trans('labels.logout') }}</a>
                     </div>
                  </li>
                  @endif
               </ul>
            </nav>
         </header>
       
         <div class="IntantBooking d-lg-none d-md-none d-sm-none d-block">
             @if($lastUriSegment == 'home') 
              <a href="{{URL::to('/home/instant-booking')}}" >Instant Booking</a>
             @endif
        
         </div>