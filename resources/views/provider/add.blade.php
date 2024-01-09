@extends('layout.main')
@section('page_title',trans('labels.add_provider'))
@section('content')
<section id="basic-form-layouts">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.add_provider') }}</h4>
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form form-horizontal" id="add_provider_form" action="{{URL::to('providers/store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-body">
								<div class="row">

									
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="name">{{ trans('labels.name') }}* </label>
											<div class="col-md-9">
												<input type="text" id="add_provider_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}" placeholder="{{trans('labels.enter_full_name')}}">
												@error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="image">{{ trans('labels.profile') }}*</label>
											<div class="col-md-9">
												<input type="file" id="add_provider_image" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image')}}">
												@error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="email">{{ trans('labels.email') }}* </label>
											<div class="col-md-9">
												<input type="email" id="add_provider_email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" placeholder="{{trans('labels.enter_email')}}">
												@error('email')<span class="text-danger" id="email_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="password">{{ trans('labels.password') }}* </label>
											<div class="col-md-9">
												<input type="password" id="add_provider_password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}" placeholder="{{trans('labels.enter_password')}}">
												@error('password')<span class="text-danger" id="password_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">

										<div class="form-group row">
											<label class="col-md-3 label-control" for="provider_type">{{ trans('labels.provider_type') }}*</label>
											<div class="col-md-9">
												<select id="add_provider_providertype" name="provider_type" class="form-control @error('provider_type') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="provider_type">
													<option value="" selected disabled>Select</option>
													@foreach ($providertypedata as $pt)
													<option {{ old('provider_type') == $pt->id ? 'selected' : ''}} value="{{$pt->id}}">{{$pt->name}}</option>
													@endforeach
												</select>
												@error('provider_type')<span class="text-danger" id="provider_type_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="mobile">{{ trans('labels.mobile') }}*</label>
											<div class="col-md-9">
												<input type="text" id="add_provider_mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile')}}" name="mobile" placeholder="{{ trans('labels.enter_mobile') }}">
												@error('mobile')<span class="text-danger" id="mobileError">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="about">{{ trans('labels.about') }}*</label>
											<div class="col-md-9">
												<textarea id="add_provider_about" rows="2" class="form-control col-md-12 @error('about') is-invalid @enderror editor_tinyMc" name="about" placeholder="{{ trans('labels.enter_about_provider') }}">{{ old('about')}}</textarea>
												@error('about')<span class="text-danger" id="about_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>

									<div class="col-md-6 add_provider_address_multiple_city">

									<div class="form-group row">
										<label class="col-md-3 label-control" for="address">{{ trans('labels.address') }}*</label>
										<div class="col-md-9">
											<textarea id="add_provider_address" autocomplete="off" rows="2" class="form-control col-md-12 @error('address') is-invalid @enderror" name="address" placeholder="{{ trans('labels.enter_address') }}">{{ old('address')}}</textarea>
											@error('address')<span class="text-danger" id="about_error">{{ $message }}</span>@enderror
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-3 label-control" for="city">{{ trans('labels.city') }}*</label>
										<div class="col-md-9">
											<select id="add_provider_city" multiple="multiple" name="city_id[]" class="form-control @error('city_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="City">
												<!--<option value="" disabled>{{trans('labels.select')}}</option>-->
												@foreach ($citydata as $cd)
												<option {{ in_array($cd->id, old('city_id', [])) ? 'selected' : '' }} value="{{$cd->id}}">{{$cd->name}}</option>
												@endforeach
											</select>
											@error('city_id')<span class="text-danger" id="cityError">{{ $message }}</span>@enderror
										</div>
									</div>
										
										<div class="form-group row">
											<label class="col-md-3 label-control" for="about">{{ trans('labels.radius') }} </label>
											<div class="col-md-9">
												<input type="number" id="" class="form-control" name="radius" value="{{ old('radius')}}" placeholder="{{ trans('Enter Radius') }}">
											</div>
										</div>
									

										<div class="form-group col-xl-6 d-none" id="latitudeArea">
											<label class="mr-sm-2">Latitude</label>
											<input type="text" id="latitude" name="latitude" class="form-control" value="{{old('latitude')}}">
										</div>

										<div class="form-group col-xl-6 d-none" id="longtitudeArea">
											<labe class="mr-sm-2" l>Longitude</label>
												<input type="text" name="longitude" id="longitude" class="form-control" value="{{old('longitude')}}">
										</div>=
										<div id="map"></div>


									</div>
								</div>
							</div>
							<div class="form-actions left">
								<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('providers')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }} </a>
								@if (env('Environment') == 'sendbox')
								<button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"><i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
								@else
								<button type="submit" id="btn_add_provider" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
								@endif
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('resources/views/provider/bootstrap-multiselect.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/provider/bootstrap-multiselect.css') }}">
<!-- Initialize the plugin: -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#add_provider_city').multiselect();
	});
</script>
<style>
	.dropdown-menu {
		min-width: 15rem;

	}

	.dropdown-menu li,
	dd {
		line-height: 1rem;
	}

	.dropdown-menu .active a:focus,
	.dropdown-menu .active a:hover {
		background-color: #fff;
	}

	.dropdown-menu .active a {
		background-color: #fff;
	}
</style>

<script>
	$(document).ready(function() {
		$("#latitudeArea").addClass("d-none");
		$("#longtitudeArea").addClass("d-none");
	});
</script>

<script>
	function initMap() {
		var map = new google.maps.Map(document.getElementById('map'), {
			center: {
				lat: 28.455473,
				lng: 77.021902
			},
			zoom: 13,
			disableDefaultUI: false,
			streetViewControl: false
		});
		var input = document.getElementById('add_provider_address');
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

		autocomplete.addListener('place_changed', function() {

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
<script src="https://cdn.tiny.cloud/1/0pvblvpkzkjl5tcff7t5ot1fqadvemydpud78ki7ltsgnyrj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '.editor_tinyMc', // Replace 'your-class-name' with the actual class name of your textarea or div
      // other configuration options
    });
</script>
@endsection