<div class="col-xl-3 col-md-4">
   <div class="bg-white rounded p-3 mb-3">
      <div class="mb-4">
         <div class="d-sm-flex flex-row flex-wrap text-center text-sm-left align-items-center">
            <img alt="profile image" src="{{Helper::image_path($providerdata->provider_image)}}" class="avatar-lg rounded">
            <div class="ml-sm-3 ml-md-0 ml-lg-3 mt-2 mt-sm-0 mt-md-2 mt-lg-0">
               <h6 class="mb-0">{{$providerdata->provider_name}}</h6>
            </div>
         </div>
      </div>
      <div class="widget settings-menu">
         <ul>
            <li class="nav-item"><a href="{{URL::to('/home/providers-services/'.$providerdata->slug)}}" class="{{ request()->is('home/providers-services*')   ? 'active' : '' }}"><i class="far fa-address-book"></i> <span>{{trans('labels.services')}}</span></a></li>
            <li class="nav-item"><a href="{{URL::to('/home/providers-rattings/'.$providerdata->slug)}}" class="{{ request()->is('home/providers-rattings*') ? 'active' : '' }}"><i class="far fa-star"></i> <span>{{trans('labels.reviews')}}</span></a></li>
            <li class="nav-item"><a href="{{URL::to('/home/providers-details/'.$providerdata->slug)}}" class="{{ request()->is('home/providers-details*') ? 'active' : '' }}"><i class="far fa-user"></i> <span>{{trans('labels.profile')}}</span></a></li>
         </ul>
      </div>
   </div>
</div>