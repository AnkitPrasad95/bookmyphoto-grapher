<div class="col-xl-3 col-md-4 mb-4">
   <div class="bg-white rounded p-3 mb-4" id="UserSidebar">
      <div class="mb-4">
            <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center ">
               <img alt="profile image" src="{{Helper::image_path(Auth::user()->image)}}" class="avatar-lg rounded-circle" />
               <div class="ml-sm-3 ml-md-0 ml-lg-3 mt-2 mt-sm-0 mt-md-2 mt-lg-0">
                  <h6 class="mb-0">{{Auth::user()->name}}</h6>
               </div>
            </div>
      </div>
      <div class="widget settings-menu mb-0">
         <ul role="tablist" class="nav nav-tabs">
            <li class="nav-item current">
               <a href="{{URL::to('/home/user/dashboard')}}" class="{{ request()->is('home/user/dashboard*') ? 'active' : '' }}">
               <i class="fas fa-chart-line"></i> <span>{{trans('labels.dashboard')}}</span> </a>
            </li>
            <li class="nav-item current">
               <a href="{{URL::to('/home/user/bookings')}}" class="{{ request()->is('home/user/bookings*') ? 'active' : '' }}">
                  <i class="far fa-calendar-check"></i> <span>{{trans('labels.my_bookings')}}</span>
                  @if(Helper::booking() > 0)
                     <span class="badge badge-pill bg-yellow white">{!!Helper::booking()!!}</span>
                  @endif
               </a>
            </li>
            <li class="nav-item">
               <a href="{{URL::to('/home/user/reviews')}}" class="{{ request()->is('home/user/reviews*') ? 'active' : '' }}">
               <i class="far fa-star"></i> <span>{{trans('labels.reviews')}}</span> </a>
            </li>
            <li class="nav-item">
               <a href="{{URL::to('/home/user/notifications')}}" onclick="clearnotification('{{URL::to('/home/user/clearnotification')}}','{{URL::to('/home/user/notifications')}}')" class="{{ request()->is('home/user/notifications*') ? 'active' : '' }}">
               <i class="far fa-bell"></i> <span>{{trans('labels.notifications')}}</span></a> 
               @if(Helper::notification() > 0)
                  <span class="badge badge-pill bg-yellow white">{!!Helper::notification()!!}</span>
               @endif
            </li>
            <li class="nav-item">
               <a href="{{URL::to('/home/user/wallet')}}" class="{{ request()->is('home/user/wallet*') ? 'active' : '' }}">
               <i class="far fa-money-bill-alt"></i> <span>{{trans('labels.wallet')}}</span> </a>
            </li>
            <li class="nav-item">
               <a href="{{URL::to('/home/user/profile')}}" class="{{ request()->is('home/user/profile*') ? 'active' : '' }}">
               <i class="far fa-user"></i> <span>{{trans('labels.profile_settings')}}</span> </a>
            </li>
            <li class="nav-item">
               <a href="{{URL::to('/home/user/change-password')}}" class="{{ request()->is('home/user/change*') ? 'active' : '' }}">
               <i class="fas fa-key"></i> <span>{{trans('labels.change_password')}}</span> </a>
            </li>
         </ul>
      </div>
   </div>
</div>