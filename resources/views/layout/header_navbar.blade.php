<!-- Navbar (Header) Start -->
<nav class="navbar navbar-expand-lg navbar-light bg-faded header-navbar">
   <div class="container-fluid">
      <div class="navbar-header">
         <button type="button" data-toggle="collapse" class="navbar-toggle d-lg-none float-left"><span class="sr-only">Toggle Navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button><span class="d-lg-none navbar-right navbar-collapse-toggle"><a aria-controls="navbarSupportedContent" href="javascript:;" class="open-navbar-container black"><i class="ft-more-vertical"></i></a></span>

         <div role="search" class="navbar-form navbar-right mt-1">
            <div class="position-relative has-icon-right">
               <div class="position-relative has-icon-right">

                  @if(Session::get('back_admin'))
                     <a class="btn btn-dark btn-raised mr-1" href="{{URL::to('/go-back')}}" type="button">
                        {{trans('labels.back_to_admin')}}
                     </a>
                  @endif

                  @if(Auth::user()->type == 1)
                  <a class="btn btn-info btn-raised mr-1" href="{{URL::to('/clear-cache')}}" type="button">
                     {{trans('labels.clear_cache')}}
                  </a>
                  @endif
                  <form method="POST" action="{{URL::to('/payout-create')}}" class="navbar-form navbar-right">
                     @csrf
                     <button class="btn btn-primary btn-raised" type="button">
                        {{trans('labels.earnings')}} <span class="badge badge-light">{{Helper::currency_format(Helper::wallet())}}</span>
                     </button>
                     <input type="hidden" name="balance" value="{{Helper::wallet()}}">
                     @if( (Helper::wallet() >= Helper::appdata()->withdrawable_amount) && (Helper::payout_request() <= 0) && (Auth::user()->type == 2) )
                     <button class="btn btn-info btn-raised" type="submit">
                        {{trans('labels.withdrawal_request')}}
                     </button>
                     @endif
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="navbar-container">
         <div id="navbarSupportedContent" class="collapse navbar-collapse">
            <h4>{{Auth::user()->name}}</h4>
            <ul class="navbar-nav">
               <li class="dropdown nav-item">
                  <a id="dropdownBasic2" href="" onclick="clearnotification('{{Auth::user()->id}}')" data-toggle="dropdown" class="nav-link position-relative">
                     <i class="ft-bell font-medium-3 blue-grey darken-4 mr-2"></i>
                     
                     @if(Helper::notification() > 0 && Auth::user()->type == 1)
                        <span class="notification badge badge-pill badge-danger"><small id="notification_count">{!!Helper::notification()!!}</small></span>
                    @elseif(Auth::user()->type == 2)
                        <span id="myElement" class="notification badge badge-pill "><small class="notification_count"></small></span>
                    @endif
                     <p class="d-none">{{ trans('labels.notification') }}</p>
                  </a>
               </li>
               <li class="dropdown nav-item">
                  <a id="dropdownBasic3" href="#" data-toggle="dropdown" class="nav-link position-relative dropdown-toggle">
                     <i class="ft-user font-medium-3 blue-grey darken-4"></i><p class="d-none">{{ trans('labels.settings') }}</p>
                  </a>
                  <div ngbdropdownmenu="" aria-labelledby="dropdownBasic3" class="dropdown-menu text-left dropdown-menu-right">
                     <a class="dropdown-item py-1" data-toggle="modal" data-target="#bootstrap"><i class="ft-edit mr-2"></i><span>{{ trans('labels.edit_profile') }}</span></a>
                     <a class="dropdown-item py-1 change_password_modal" data-toggle="modal" data-target="#change_password_modal"><i class="fa fa-key mr-2"></i><span>{{ trans('labels.change_password') }}</span></a>
                     <div class="dropdown-divider"></div>
                     <a class="dropdown-item" href="{{ URL::to('/adminlogout') }}"><i class="ft-power mr-2"></i><span>{{ trans('labels.logout') }}</span></a>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</nav>
<!-- Navbar (Header) Ends -->