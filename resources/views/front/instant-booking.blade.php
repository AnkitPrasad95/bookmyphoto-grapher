@extends('front.layout.main')
<script>
    // This function will be called when the page loads.
    // window.onload = function () {
    //     requestLocationPermission();
    // };

    // function requestLocationPermission() {
    //     if (navigator.geolocation) {
    //         navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    //     } else {
    //         //alert("Geolocation is not supported by your browser.");
    //     }
    // }

    // function successCallback(position) {
    //     var latitude = position.coords.latitude;
    //     var longitude = position.coords.longitude;
    //     // getDatabyLatLong(latitude, longitude);
    //     alert(latitude longitude);

    //     // Do something with the latitude and longitude (e.g., display it or send it to the server).
    // }

    // function errorCallback(error) {
    //     switch (error.code) {
    //         case error.PERMISSION_DENIED:
    //             //alert("Location access denied by the user.");
    //             break;
    //         case error.POSITION_UNAVAILABLE:
    //             //alert("Location information is unavailable.");
    //             break;
    //         case error.TIMEOUT:
    //             //alert("The request to get user location has timed out.");
    //             break;
    //         case error.UNKNOWN_ERROR:
    //             //alert("An unknown error occurred.");
    //             break;
    //     }
    // }
    </script>
@section('page_title',trans('Photographers'))

@section('content')
<div class="breadcrumb-bar">
   <div class="container-fluid">
      <div class="row">
         <div class="col">
            <div class="breadcrumb-title">
               <!-- <h2>{{trans('labels.find_professional')}}</h2> -->
               <h2>Instant Booking</h2>
            </div>
         </div>
         <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
            <nav aria-label="breadcrumb" class="page-breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{trans('Photographers')}}</li>
                  <!--<button onclick="getLocation()">Try It</button>-->

                  <!--<p id="demo"></p>-->
                 
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<?php
//   echo "<pre>";
//   print_r($instantData);
//   echo "</pre>";
  //die;
?>
<div class="content bg-sec-img mb-0 pb-0">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="row align-items-center">
               <div class="col-md-12 col">
                  <h4>
                     <!-- @isset($providerdata)
                           {{trans('labels.provider')}}
                        @endisset
                        @isset($servicedata)
                           {{trans('labels.service')}}
                        @endisset -->
                     <!-- Instant Booking -->
                  </h4>
               </div>
               <!-- <div class="col-md-6 col-auto">
                     <div class="view-icons">
                        <a href="javascript:void(0);" class="grid-view active"><i class="fas fa-th-large"></i></a>
                     </div>
                  </div> -->
            </div>
            <div>
                <div class="row match-height" id="data_photographer">
           
                    @include('front.photographer_section')
               </div>
            </div>
         </div>
      </div>
   </div>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
   <!-- jquery -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  
   <!-- Price nouislider-filter cdn -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.css" integrity="sha512-MKxcSu/LDtbIYHBNAWUQwfB3iVoG9xeMCm32QV5hZ/9lFaQZJVaXfz9aFa0IZExWzCpm7OWvp9zq9gVip/nLMg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.5.1/nouislider.min.js" integrity="sha512-T5Bneq9hePRO8JR0S/0lQ7gdW+ceLThvC80UjwkMRz+8q+4DARVZ4dqKoyENC7FcYresjfJ6ubaOgIE35irf4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <style>
      .mall-slider-handles {
         margin-top: 50px;
      }

      .noUi-connect {
         background: #E11F26;
      }

      .noUi-pips-horizontal {
         display: none;
      }
   </style>
   
   
<script>
const x = document.getElementById("demo");

// function getLocation() {
//   if (navigator.geolocation) {
//     navigator.geolocation.getCurrentPosition(showPosition);
//   } else { 
//     x.innerHTML = "Geolocation is not supported by this browser.";
//   }
// }

// function showPosition(position) {
//   x.innerHTML = "Latitude: " + position.coords.latitude + 
//   "<br>Longitude: " + position.coords.longitude;
// }


window.onload = function() {
    
    // Check if geolocation is supported by the browser
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            // You can also send this data to the server for further processing if needed
            sendDataToServer(latitude, longitude);
        });
    } else {
        //x.innerHTML = "Geolocation is not supported by this browser.";
        alert("Geolocation is not supported by your browser.");
    }
};

function sendDataToServer(latitude, longitude) {
    console.log(latitude, longitude);
    $.ajax({
        method: 'POST',
        url: '{{URL::to('/home/instant-booking-new')}}',
        headers: { 
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { "latitude": latitude, "longitude": longitude },
        success: function (data) {
            
            //const data = JSON.parse(response);
            console.log(data);
            
            //$('#suggestion').html(dataSet);
            $('#data_photographer').html(data);

            
        },
        error: function (error) {
            console.error(error);
        }
    });
}
</script>
   
  


   <script>
      $(function() {
         //var $propertiesForm = $('.mall-category-filter');
         //var $body = $('body');
         $('.mall-slider-handles').each(function() {
            var el = this;
            noUiSlider.create(el, {
               start: [el.dataset.start, el.dataset.end],
               connect: true,
               tooltips: true,
               range: {
                  min: [parseFloat(el.dataset.min)],
                  max: [parseFloat(el.dataset.max)]
               },
               pips: {
                  mode: 'range',
                  density: 20
               }
            }).on('change', function(values) {
               $('[data-min="' + el.dataset.target + '"]').val(values[0])
               $('[data-max="' + el.dataset.target + '"]').val(values[1])
               // $propertiesForm.trigger('submit');
            });
         })
      })
      
      
      
   </script>
   



   @endsection