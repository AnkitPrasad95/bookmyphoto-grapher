@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.profile_settings')}}
@endsection
@section('front_content')
      <div class="col-xl-9 col-md-8">
      <h4 class="widget-title">{{trans('labels.profile_settings')}}</h4>
         <div class="tab-content pt-0">
            <div class="tab-pane show active" id="user_profile_settings">
               <div class="widget">
                  <!-- <h4 class="widget-title">{{trans('labels.profile_settings')}}</h4> -->
                  @if(!empty($citydata))
                  <form action="{{URL::to('/home/user/profile/edit')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                        <div class="form-group col-xl-6">
                           <div class="media align-items-center mb-3">
                              <img class="user-image rounded" src="{{Helper::image_path(Auth::user()->image)}}" alt="{{trans('labels.user_image')}}">
                              <div class="media-body">
                                 <h5 class="mb-50">{{Auth::user()->name}}</h5>
                                 <div class="jstinput"> 
                                    <label for="profile_image" class="btn btn-primary">{{trans('labels.browse')}}</label>
                                    <input type="file" class="form-control" name="image" id="profile_image">
                                 </div>
                                 @error('image')<span class="text-danger"> {{ $message }}</span>@enderror
                              </div>
                           </div>
                        </div>
                        <div class="form-group col-xl-6">
                           <label class="mr-sm-2">{{trans('labels.email')}}</label>
                           <input class="form-control" type="email" value="{{Auth::user()->email}}" disabled>
                        </div>
                     </div>
                     <div class="row">
                        <div class="form-group col-xl-6">
                           <label class="mr-sm-2">{{trans('labels.name')}}*</label>
                           <input class="form-control" type="text" name="name" value="{{Auth::user()->name}}">
                           @error('name')<span class="text-danger"> {{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-xl-6">
                           <label class="mr-sm-2">{{trans('labels.mobile')}}</label>
                           <input class="form-control" type="text" name="mobile" value="{{Auth::user()->mobile}}" disabled>
                           @error('mobile')<span class="text-danger"> {{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-xl-6">
                           <label class="mr-sm-2">{{trans('labels.address')}}*</label>
                           <input type="text" id="searchMapInput" autocomplete="off" class="form-control" name="address" value="{{strip_tags(Auth::user()->address)}}">
                           @error('address')<span class="text-danger"> {{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-xl-6">
                           <label class="mr-sm-2">{{trans('labels.city')}}</label>
                           <select name="city" id="city" class="form-control">
                              @foreach ($citydata as $cdata)
                                 <option value="{{$cdata->id}}" @if (Auth::user()->city_id == $cdata->id) selected @endif>{{$cdata->name}}</option>
                              @endforeach
                           </select>
                           @error('city')<span class="text-danger"> {{ $message }}</span>@enderror
                        </div>
                        <div class="form-group col-xl-12">
                           <label class="mr-sm-2">{{trans('labels.about')}}*</label>
                           <textarea class="form-control" name="about" id="" cols="30" rows="3">{{strip_tags(Auth::user()->about)}}</textarea>
                           @error('about')<span class="text-danger"> {{ $message }}</span>@enderror
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
                        <div class="form-group col-xl-12">
                           <input type="submit" class="btn btn-primary pl-5 pr-5" value="{{trans('labels.update')}}">
                        </div>
                     </div>
                  </form>
                  @else
                     <p class="text-center">{{trans('labels.no_data')}}</p>
                  @endif
               </div>
            </div>
         </div>
      </div>
@endsection

@section('scripts')

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

@endsection
