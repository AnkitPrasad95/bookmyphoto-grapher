@extends('front.layout.main')
@section('page_title',trans('labels.become_provider'))
@section('content')
<style>
   .contact-queries{
      background: #fff;
      border:1px solid #ccc;
      border-radius: 10px;
      padding: 20px !important;
   }
</style>
<div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <!-- <h2>{{ trans('labels.become_provider') }}</h2> -->
                        <h2>Create Your Studio</h2>
                    </div>
                </div>
                <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                           <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.register') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
      <section class="contact-us bg-sec-img">
         <div class="content">
            <div class="container-fluid">
               <div class="row justify-content-md-center">
                  <div class="col-lg-8 col-sm-12 col-md-10">
                     <div class="contact-queries">
                        <h4 class="mb-4">{{ trans('labels.register') }}</h4>
                           <form action="{{ URL::to('home/store-provider') }}" method="post" id="studio-create" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.firstname') }}*</label>
                                       <input class="form-control @error('name') is-invalid @enderror" type="text" name="firstname" value="{{old('firstname')}}" placeholder="{{trans('labels.enter_first_name')}}">
                                       @error('firstname')<span class="text-danger ">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.lastname') }}*</label>
                                       <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" value="{{old('lastname')}}" placeholder="{{trans('labels.enter_last_name')}}">
                                       @error('lastname')<span class="text-danger ">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{trans('labels.email')}}*</label>
                                       <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" placeholder="{{trans('labels.enter_email')}}">
                                       @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.mobile') }}*</label>
                                       <input class="form-control @error('mobile') is-invalid @enderror" type="number" name="mobile" value="{{old('mobile')}}" placeholder="{{trans('labels.enter_mobile')}}">
                                       @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.password') }}*</label>
                                       <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}" placeholder="{{trans('labels.enter_password')}}">
                                       @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{trans('labels.provider_type')}}*</label>
                                       <select class="form-control @error('provider_type') is-invalid @enderror" name="provider_type" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="provider_type">
                                          <option selected disabled>{{ trans('labels.select') }}</option>
                                          @foreach ($providertypedata as $ptdata)
                                             <option value="{{$ptdata->id}}">{{$ptdata->name}}</option>
                                          @endforeach
                                       </select>
                                       @error('provider_type')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    
                                   
                                   
                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{trans('labels.profile')}}</label>
                                       <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" value="{{old('image')}}"
                                       >@error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>

                                    <div class="form-group col-xl-6 add_provider_address_multiple_city">
                                       <label class="mr-sm-2">{{trans('labels.city')}}*</label>
                                       <span class="multiselect-native-select">
                                       <select id="add_front_city" multiple="multiple" class="form-control @error('city') is-invalid @enderror" name="city[]" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="city">
                                          <option selected disabled>{{ trans('labels.select') }}</option>
                                          @foreach ($citydata as $cdata)
                                             <option value="{{$cdata->id}}">{{$cdata->name}}</option>
                                          @endforeach
                                       </select>
                                       </span>
                                       @error('city')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>



                                   

                                    <div class="form-group col-xl-12">
                                       <label class="mr-sm-2">{{trans('labels.address')}}*</label>
                                       <input id="searchMapInput" autocomplete="off"  class="form-control @error('address') is-invalid @enderror" rows="3" name="address" placeholder="{{trans('labels.enter_address')}}" value="{{old('address')}}">
                                       @error('address')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    
                                     <div class="form-group col-xl-6 d-none" id="latitudeArea">
                                    <label class="mr-sm-2">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" class="form-control" value="{{old('latitude')}}">
                                    </div>
                              
                                    <div class="form-group col-xl-6 d-none" id="longtitudeArea">
                                        <labe class="mr-sm-2"l>Longitude</label>
                                        <input type="text" name="longitude" id="longitude" class="form-control" value="{{old('longitude')}}">
                                    </div>
                                    <div id="map"></div>
                                   
                                    <div class="col-xl-12 mt-4">
                                       <button class="btn btn-primary btn-lg pl-5 pr-5" type="submit"> <i class="fa fa-paper-plane"></i> {{ trans('labels.register') }} </button>
                                    </div>
                                </div>
                           </form>
                           <p class=" mt-2">{{trans('labels.already_account')}} <a href="{{URL::to('/admin')}}">{{trans('labels.login')}}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
@endsection
@section('scripts')
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<script type="text/javascript" src="{{ asset('resources/views/provider/bootstrap-multiselect.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/provider/bootstrap-multiselect.css') }}">
	<!-- Initialize the plugin: -->
  <script type="text/javascript">
    $(document).ready(function() {
        $('#add_front_city').multiselect();
    });
</script>
<style>
.dropdown-menu{
    min-width: 15rem;
    
}
.dropdown-menu li, dd {
    line-height: 1rem;
}
.dropdown-menu .active a:focus, .dropdown-menu .active a:hover {
     background-color: #fff; 
}
.dropdown-menu .active a {
     background-color: #fff;
}
</style>

<script>
        $(document).ready(function () {
            $("#latitudeArea").addClass("d-none");
            $("#longtitudeArea").addClass("d-none");
        });
</script>    
    
<script>
function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 28.455473, lng: 77.021902},
      zoom: 13,
      disableDefaultUI: false,
      streetViewControl: false
    });
    var input = document.getElementById('searchMapInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
   
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
  
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });
  
   /* autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
    
        
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
      
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
      
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        
       
        //document.getElementById('location-snap').innerHTML = place.formatted_address;
        //document.getElementById('lat-span').innerHTML = place.geometry.location.lat();
        //document.getElementById('lon-span').innerHTML = place.geometry.location.lng();
    });*/
    
    autocomplete.addListener('place_changed', function () {
        
         infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
    
        
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        marker.setIcon(({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
      
        var address = '';
        if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }
      
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
        
        
        
        var place = autocomplete.getPlace();
        $('#latitude').val(place.geometry['location'].lat());
        $('#longitude').val(place.geometry['location'].lng());

        //$("#latitudeArea").removeClass("d-none");
        //$("#longtitudeArea").removeClass("d-none");
    });
}
</script>

<script src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async defer></script>    
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function () {
        $("#studio-create").validate();
    });
</script>

    

@endsection

