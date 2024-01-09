@extends('front.layout.main')

@section('page_title',trans('labels.become_user'))

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>

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
                     <h2>{{ trans('labels.become_user') }}</h2>
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

      <section class="contact-us">
         <div class="content bg-sec-img">
            <div class="container-fluid">
               <div class="row justify-content-md-center">
                  <div class="col--lg-8 col-md-10 col-sm-12">
                     <div class="contact-queries">
                        <h4 class="mb-4">{{ trans('labels.register') }}</h4>
                           <form action="{{ URL::to('home/store-user') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.firstname') }}*</label>
                                       <input class="form-control @error('firstname') is-invalid @enderror" type="text" name="firstname" placeholder="{{trans('labels.enter_first_name')}}" @if(Session::get('default_firstname')) value="{{Session::get('default_firstname')}}" @else value="{{old('firstname')}}" @endif>
                                       @error('firstname')<span class="text-danger ">{{ $message }}</span>@enderror
                                    </div>
                                     <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.lastname') }}*</label>
                                       <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" placeholder="{{trans('labels.enter_last_name')}}" @if(Session::get('default_lastname')) value="{{Session::get('default_lastname')}}" @else value="{{old('lastname')}}" @endif>
                                       @error('lastname')<span class="text-danger ">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.mobile') }}*</label>
                                       <input class="form-control @error('mobile') is-invalid @enderror" type="number" name="mobile" value="{{old('mobile')}}" placeholder="{{trans('labels.enter_mobile')}}">
                                       @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{trans('labels.email')}}*</label>
                                       <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="{{trans('labels.enter_email')}}" @if(Session::get('default_email')) value="{{Session::get('default_email')}}" readonly @else value="{{old('email')}}" @endif>
                                       @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-xl-6 @if(Session::get('google_id') || Session::get('facebook_id')) dn @endif ">
                                       <label class="mr-sm-2">{{ trans('labels.password') }}</label>
                                       <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" value="{{old('password')}}" placeholder="{{trans('labels.enter_password')}}">
                                       @error('password')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{trans('labels.profile')}}</label>
                                       <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" value="{{old('image')}}">
                                       @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                                    </div>
                                    
                                       <div class="form-group col-xl-6">
                                       <label class="mr-sm-2">{{ trans('labels.referral_code') }} </label>
                                       <input class="form-control" type="text" name="referral_code" value="{{old('referral_code')}}" placeholder="{{trans('labels.enter_referral_code')}}">
                                    </div>
                                    
                                    </div>
                                    <div class="row">
                                  
                                    <div class="form-group col-xl-6 addRess">
                                       <label class="mr-sm-2">{{trans('labels.address')}}*</label>
                                       <input id="searchMapInput" autocomplete="off" class="form-control @error('address') is-invalid @enderror" type="text" name="address" placeholder="{{trans('labels.enter_address')}}" value="{{old('address')}}">
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
                           <p class=" mt-2">{{trans('labels.already_account')}} <a href="{{URL::to('/home/login')}}">{{trans('labels.login')}}</a></p>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
 <style type="text/css">
        #map {
            width: 100%;
            height: 400px;
        }
        .mapControls {
            margin-top: 10px;
            border: 1px solid transparent;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            height: 32px;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }
        #searchMapInput {
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
        }
        #searchMapInput:focus {
            border-color: #4d90fe;
        }
    </style>
 <script>
        $(document).ready(function () {
            $('#searchMapInput').attr('autocomplete','off');
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
    
