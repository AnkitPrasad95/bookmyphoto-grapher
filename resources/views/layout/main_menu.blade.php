
<!-- main menu-->
   <div data-active-color="white" data-background-color="black" data-image="{{ asset('storage/app/public/admin-assets/img/sidebar-bg/04.jpg') }}" class="app-sidebar">
      <!-- main menu header-->
      <div class="sidebar-header">
         <div class="logo clearfix">
            <a href="{{ URL::to('/dashboard')}}" class="logo-text float-left">
               <span class="text align-middle">
                  @if(Auth::user()->type == 1)
                     {{ trans('labels.admin') }}
                  @elseif(Auth::user()->type == 2)
                     {{trans('labels.provider')}}
                  @endif
               </span>
            </a>
            <a id="sidebarToggle" href="javascript:;" class="nav-toggle d-none d-sm-none d-md-none d-lg-block"><i data-toggle="expanded" class="ft-toggle-right toggle-icon"></i></a>
            <a id="sidebarClose" href="javascript:;" class="nav-close d-block d-md-block d-lg-none d-xl-none"><i class="ft-x"></i></a>
         </div>
      </div>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="sidebar-content">
         <div class="nav-container">
            <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
               <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
                  <a href="{{ URL::to('/dashboard')}}" class="menu-item"><i class="ft-home"></i><span data-i18n="" class="menu-title">{{ trans('labels.home') }}</span></a>
               </li>
               @if (Auth::user()->type == 1)
                  <li class="{{ request()->is('categories*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/categories')}}" class="menu-item"><i class="ft-briefcase"></i><span data-i18n="" class="menu-title">{{ trans('labels.category') }}</span></a>
                  </li> 
                  <li class="{{ request()->is('master-services*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/master-services')}}" class="menu-item"><i class="ft-briefcase"></i><span data-i18n="" class="menu-title">{{ trans('Master Services') }}</span></a>
                  </li> 
                  <li class="{{ request()->is('cities*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/cities')}}" class="menu-item"><i class="ft-map"></i><span data-i18n="" class="menu-title">{{ trans('labels.city') }}</span></a>
                  </li>
                  <li class="{{ request()->is('provider_types*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/provider_types')}}" class="menu-item"><i class="ft-list"></i><span data-i18n="" class="menu-title">{{ trans('labels.provider_type') }}</span></a>
                  </li>
                  <li class="{{ request()->is('providers*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/providers')}}" class="menu-item"><i class="ft-users"></i><span data-i18n="" class="menu-title">{{ trans('labels.provider') }}</span></a>
                  </li>
                  <li class="{{ request()->is('handymans*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/handymans')}}" class="menu-item"><i class="fa fa-users"></i><span data-i18n="" class="menu-title">{{ trans('labels.handyman') }}</span></a>
                  </li>
                  <li class="{{ request()->is('users*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/users')}}" class="menu-item"><i class="ft-users"></i><span data-i18n="" class="menu-title">{{ trans('labels.users') }}</span></a>
                  </li>
                  <li class="{{ request()->is('services*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/services')}}" class="menu-item"><i class="ft-heart"></i><span data-i18n="" class="menu-title">{{ trans('labels.service') }}</span></a>
                  </li>
                  <li class="{{ request()->is('bookings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/bookings')}}" class="menu-item"><i class="ft-calendar"></i><span data-i18n="" class="menu-title">{{ trans('labels.booking') }}</span></a>
                  </li>
                  
                  <li class="{{ request()->is('coupons*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/coupons')}}" class="menu-item"><i class="fa fa-gift"></i><span data-i18n="" class="menu-title">{{ trans('labels.coupon') }}</span></a>
                  </li>
                  {{--<li class="{{ request()->is('payment-methods*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/payment-methods')}}" class="menu-item"><i class="fa fa-money"></i><span data-i18n="" class="menu-title">{{ trans('labels.payment_method') }}</span></a>
                  </li>--}}
                  <li class="{{ request()->is('banners*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/banners')}}" class="menu-item"><i class="ft-image"></i><span data-i18n="" class="menu-title">{{ trans('labels.banner') }}</span></a>
                  </li>
                  <li class="{{ request()->is('subscribers*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/subscribers')}}" class="menu-item"><i class="ft-check"></i><span data-i18n="" class="menu-title">{{ trans('labels.subscribers') }}</span></a>
                  </li>
                  {{--<li class="{{ request()->is('help*') ? 'active' : '' }}">
                     <a onclick="clearhelp()" class="menu-item">
                        <i class="fa fa-question-circle"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.help') }}</span>
                        @if(Helper::help() > 0)
                           <span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">{!!Helper::help()!!}</span>
                        @endif
                     </a>
                  </li>--}}
                  <li class="{{ request()->is('payout*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/payout')}}" class="menu-item">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span class="menu-title">{{ trans('labels.payout_request') }}</span>
                        @if(Helper::payout_request() > 0)
                           <span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">{!!Helper::payout_request()!!}</span>
                        @endif
                     </a>
                  </li>
                   <li class="{{ request()->is('cod_payout') ? 'active' : '' }}">
                     <a href="{{ URL::to('/cod_payout')}}" class="menu-item">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span class="menu-title">Cod Payout Request</span>
                       
                     </a>
                  </li>
                  <li class="{{ request()->is('settings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/settings')}}" class="menu-item"><i class="fa fa-cog"></i><span data-i18n="" class="menu-title">{{ trans('labels.settings') }}</span></a>
                  </li>
                  <li class="{{ request()->is('home-settings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/home-settings/home')}}" class="menu-item"><i class="fa fa-cog"></i><span data-i18n="" class="menu-title">{{ trans('labels.home_settings') }}</span></a>
                  </li>

                  <li class="has-sub nav-item "><a href="#"><i class="fa fa-list"></i><span class="menu-title">{{trans('labels.cms_pages')}}</span></a>
                     <ul class="menu-content">
                        <li class="{{ request()->is('about*') ? 'active' : '' }}"><a href="{{ URL::to('/about')}}"><span class="menu-title">{{ trans('labels.about') }}</span></a></li>
                        <li class="{{ request()->is('privacy*') ? 'active' : '' }}"><a href="{{ URL::to('/privacy-policy')}}"><span class="menu-title">{{ trans('labels.privacy_policy') }}</span></a></li>
                        <li class="{{ request()->is('terms*') ? 'active' : '' }}"><a href="{{ URL::to('/terms-conditions')}}"><span class="menu-title">{{ trans('labels.terms_conditions') }}</span></a></li>
                     </ul>
                  </li>
               @endif
               @if (Auth::user()->type == 2)
                  <li class="{{ request()->is('handymans*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/handymans')}}" class="menu-item"><i class="fa fa-users"></i><span data-i18n="" class="menu-title">{{ trans('labels.handyman') }}</span></a>
                  </li>
                  <li class="{{ request()->is('services*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/services')}}" class="menu-item"><i class="ft-heart"></i><span data-i18n="" class="menu-title">{{ trans('labels.services') }}</span></a>
                  </li>
                  <li class="{{ request()->is('bookings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/bookings')}}" class="menu-item">
                        <i class="ft-calendar"></i>
                        <span data-i18n="" class="menu-title">{{ trans('labels.bookings') }}</span>
                        @if(Helper::booking() > 0)
                           <span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">{!!Helper::booking()!!}</span>
                        @endif
                     </a>
                  </li>
                   <li class="{{ request()->is('coupons*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/coupons')}}" class="menu-item"><i class="fa fa-gift"></i><span data-i18n="" class="menu-title">{{ trans('labels.coupon') }}</span></a>
                  </li>
                   <li class="{{ request()->is('gallery*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/gallery')}}" class="menu-item"><i class="ft-calendar"></i><span data-i18n="" class="menu-title">{{ trans('labels.gallery') }}</span></a>
                  </li>
                  <li class="{{ request()->is('timings*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/timings')}}" class="menu-item"><i class="ft-clock"></i><span data-i18n="" class="menu-title">{{trans('labels.timing')}}</span></a>
                  </li>
                  <li class="{{ request()->is('payout*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/payout')}}" class="menu-item">
                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                        <span class="menu-title">{{ trans('labels.payout_request') }}</span>
                        @if(Helper::payout_request() > 0)
                           <span class="tag badge badge-pill badge-danger float-right mr-1 mt-1">{!!Helper::payout_request()!!}</span>
                        @endif
                     </a>
                  </li>
                  <li class="{{ request()->is('reviews*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/reviews')}}" class="menu-item"><i class="ft-star"></i><span data-i18n="" class="menu-title">{{trans('labels.reviews')}}</span></a>
                  </li>
                  <li class="{{ request()->is('notification*') ? 'active' : '' }}">
                     <a href="" onclick="clearnotification('{{Auth::user()->id}}')" class="menu-item"><i class="ft-bell"></i> <span data-i18n="" class="menu-title">{{trans('labels.notifications')}}</span>
                        @if(Helper::notification() > 0)
                           <span class="tag notification badge badge-pill badge-danger float-right mr-1 mt-1">{!!Helper::notification()!!}</span>
                        @endif
                     </a>
                  </li>
                  <li class="{{ request()->is('profile*') ? 'active' : '' }}">
                     <a href="{{ URL::to('/profile-settings')}}" class="menu-item"><i class="fa fa-cog"></i><span data-i18n="" class="menu-title">{{trans('labels.profile_settings')}}</span></a>
                  </li>
               @endif
            </ul>
         </div>
      </div>
      <!-- main menu content-->
      <div class="sidebar-background"></div>
   </div>
<!-- / main menu-->