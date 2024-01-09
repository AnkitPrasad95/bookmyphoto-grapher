<?php 
echo "<pre>";
print_r($providerdata->toArray());
echo "</pre";
?>
@section('page_title',trans('labels.edit_provider'))
@section('content')
<section id="basic-form-layouts">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.edit_provider') }}</h4>
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form form-horizontal" id="edit_provider_form" action="{{URL::to('/providers/edit/'.$providerdata->slug)}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-body" style="overflow: visible;">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="is_available">{{ tranas('labels.is_assured') }}</label>
											<div class="col-md-9">
												<div class="form-check form-switch">
													<input class="form-check-input " type="checkbox" id="verified_flag" name="verified_flag" value="{{$providerdata->verified_flag}}" @if($providerdata->verified_flag == 1) checked="true" @endif>
												</div>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="name">{{ trans('labels.name') }} </label>
											<div class="col-md-9">
												<input type="text" id="edit_provider_name" class="form-control @error('name') is-invalid @enderror" name="edit_provider_name" value="{{$providerdata->name}}" placeholder="{{ trans('labels.enter_full_name') }}">
												@error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="email">{{ trans('labels.email') }} </label>
											<div class="col-md-9">
												<input type="email" id="edit_provider_email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$providerdata->email}}" placeholder="{{trans('labels.enter_email')}}">
												@error('email')<span class="text-danger" id="emailError">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="mobile">{{ trans('labels.mobile') }}</label>
											<div class="col-md-9">
												<input type="text" id="edit_provider_mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{$providerdata->mobile}}" placeholder="{{trans('labels.enter_mobile')}}">
												@error('mobile')<span class="text-danger" id="mobile_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="provider_type">{{ trans('labels.provider_type') }}</label>
											<div class="col-md-9">
												<select id="edit_provider_provider_type" name="provider_type" class="form-control @error('provider_type') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="{{trans('labels.provider_type')}}">
													<option value="{{$providerdata['providertype']->id}}" selected>{{$providerdata['providertype']->name}}</option>
													@foreach ($providertypedata as $pt)
													<option value="{{$pt->id}}">{{$pt->name}}</option>
													@endforeach
												</select>
												@error('provider_type')<span class="text-danger" id="provider_type_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="new_image">{{ trans('labels.select_new') }}</label>
											<div class="col-md-9">
												<input type="file" id="edit_provider_image" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
												@error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="image"> {{ trans('labels.profile') }}</label>
											<div class="col-md-9">
												<img src="{{Helper::image_path($providerdata->image)}}" alt="{{trans('labels.provider')}}" class="rounded edit-image">
											</div>
										</div> 
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="studio_status">{{ trans('labels.studio_status') }}</label>
											<div class="col-md-3">
												<div class="form-check form-switch">
													<input class="form-check-input" type="radio" name="available_status" value="Available" @if($providerdata->available_status == 1) checked="true" @endif>
													<label class="form-check-label " for="is_available">{{ trans('Available') }}</label>
												</div>
											</div> 
											<div class="col-md-2">
												<div class="form-check form-switch">
													<input class="form-check-input" type="radio" name="available_status" value="Busy" @if($providerdata->available_status == 2) checked="true" @endif>
													<label class="form-check-label " for="is_available">{{ trans('Busy') }}</label>
												</div>
											</div>
											<div class="col-md-4">
												<div class="form-check form-switch">
													<input class="form-check-input" type="radio" name="available_status" value="Unavailable" @if($providerdata->available_status == 0) checked="true" @endif>
													<label class="form-check-label " for="is_available">{{ trans('Unavailable') }}</label>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-md-3 label-control" for="about">{{ trans('labels.radius') }} </label>
											<div class="col-md-9">
											<input type="number" id="" class="form-control" name="name" value="{{$providerdata->radius}}" placeholder="{{ trans('Enter Radius') }}">
											
											</div>
										</div>

										<div class="form-group row">
											<label class="col-md-3 label-control" for="about">{{ trans('labels.about') }} </label>
											<div class="col-md-9">
												<textarea id="edit_provider_about" rows="3" class="form-control col-md-12 @error('about') is-invalid @enderror editor_tinyMc" name="about" placeholder="{{trans('labels.enter_about_provider')}}">{!! $providerdata->about !!}  </textarea>
												@error('about')<span class="text-danger" id="about_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="address">{{ trans('labels.address') }} </label>
											<div class="col-md-9">
												<textarea id="edit_provider_address" autocomplete="off" rows="3" class="form-control col-md-12 @error('address') is-invalid @enderror" name="address" placeholder="{{trans('labels.enter_address')}}">{{strip_tags($providerdata->address)}}</textarea>
												@error('address')<span class="text-danger" id="address_error">{{ $message }}</span>@enderror
											</div>

											<div class="form-group col-xl-6 d-none" id="latitudeArea">
												<label class="mr-sm-2">Latitude</label>
												<input type="text" id="latitude" name="latitude" class="form-control" value="{{old('latitude')}}">
											</div>

											<div class="form-group col-xl-6 d-none" id="longtitudeArea">
												<labe class="mr-sm-2" l>Longitude</label>
													<input type="text" name="longitude" id="longitude" class="form-control" value="{{old('longitude')}}">
											</div>
											<div id="map"></div>

										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="userinput4">{{ trans('labels.city') }} </label>
											<div class="col-md-9">
												<select id="edit_provider_city_id" multiple="multiple" name="city_id[]" class="form-control @error('city_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="City">
													{{--<option value="{{$providerdata['city']->id}}" selected>{{$providerdata['city']->name}}</option>--}}
													@foreach ($citydata as $cd)
													<option value="{{$cd->id}}" @foreach($cityId as $sublist){{$sublist == $cd->id ? 'selected': ''}} @endforeach>{{$cd->name}}</option>
													@endforeach
												</select>
												@error('city_id')<span class="text-danger" id="cityError">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="is_available">{{ trans('labels.status') }}</label>
											<div class="col-md-9">
												<div class="form-check form-switch">
													<input class="form-check-input " type="checkbox" id="is_available" name="is_available" value="is_available" @if($providerdata->is_available == 1) checked="true" @endif>
													<label class="form-check-label " for="is_available">{{ trans('labels.active') }}</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions left">
								<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('providers')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }} </a>
								@if (env('Environment') == 'sendbox')
								<button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"><i class="ft-edit"></i> {{ trans('labels.update') }} </button>
								@else
								<button type="submit" id="btnAddProvider" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
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
		$('#edit_provider_city_id').multiselect();
	});
</script>
<script src="https://cdn.tiny.cloud/1/0pvblvpkzkjl5tcff7t5ot1fqadvemydpud78ki7ltsgnyrj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '.editor_tinyMc', // Replace 'your-class-name' with the actual class name of your textarea or div
      // other configuration options
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
		var input = document.getElementById('edit_provider_address');
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
<script>
    $(document).ready(function() {
        // Function to handle checkbox changes
        var user_slug = "{{ $providerdata->slug }}";
        $("#verified_flag").change(function() {
            var checkboxVal = $(this).val(); 
           
            var user_slug = "{{ $providerdata->slug }}";
            //alert(checkboxVal + user_slug);

            // Send AJAX request to update the checkbox state in the server
            $.ajax({
                type: "POST",
                url: "{{URL::to('/providers/verified_flag')}}",
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { 'checkboxData': checkboxVal, 'user_slug': user_slug },
                success: function(data) {
                    console.log('data');
                    location.reload();
                } 
            }); 
            
            
        });
    });
    
    // Get all radio buttons by name
    var radioButtons = document.getElementsByName('available_status');
    var user_slug = "{{ $providerdata->slug }}";
    //alert(radioButtons);
    // Add a change event listener to each radio button
    for (var i = 0; i < radioButtons.length; i++) {
        radioButtons[i].addEventListener('change', function() {
            // Check if the radio button is checked
            if (this.checked) {
                // Get the value of the checked radio button
                var selectedValue = this.value;
                
                $.ajax({
                    type: "POST",
                    url: "{{URL::to('/providers/user_availablity')}}",
                    headers: { 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { 'available_status': selectedValue, 'user_slug': user_slug },
                    success: function(data) {
                        console.log('data');
                        location.reload();
                    } 
                });
                
                // Display the selected value in a div
                //document.getElementById('result').textContent = 'Selected value: ' + selectedValue;
            }
        });
    }
    
   

</script>

<script>
    tinymce.init({
      selector: '.editor_tinyMc', // Replace 'your-class-name' with the actual class name of your textarea or div
      // other configuration options
    });
</script>




@endsection