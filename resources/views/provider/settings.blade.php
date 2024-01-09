
@extends('layout.main')
@section('page_title',trans('labels.profile_settings'))
@section('content')
    <section id="configuration">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="px-3">
                            @if($bankdata != "")
                                @include('provider.setting_form')
                            @else
                                @include('provider.bank_form')
                            @endif            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
    <script src="https://cdn.tiny.cloud/1/0pvblvpkzkjl5tcff7t5ot1fqadvemydpud78ki7ltsgnyrj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript" src="https://gautamgupta.info/resources/views/provider/bootstrap-multiselect.js"></script>
<link rel="stylesheet" type="text/css" href="https://gautamgupta.info/resources/views/provider/bootstrap-multiselect.css">
<script>
    tinymce.init({
      selector: '.editor_tinyMc', // Replace 'your-class-name' with the actual class name of your textarea or div
      // other configuration options
    });
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#edit_provider_city_id').multiselect();
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

    
    // Get all radio buttons by name
    var radioButtons = document.getElementsByName('available_status');
    var user_slug = "{{ $providerdata->id }}";
    //alert(user_slug);
    // Add a change event listener to each radio button
    for (var i = 0; i < radioButtons.length; i++) {
        radioButtons[i].addEventListener('change', function() {
            // Check if the radio button is checked
            
            if (this.checked) {
                // Get the value of the checked radio button
                var selectedValue = this.value;
                //alert(selectedValue);
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

@endsection