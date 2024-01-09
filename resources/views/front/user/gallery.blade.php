@extends('front.layout.vendor_theme')
@section('page_title')
   {{trans('labels.user')}} | {{trans('labels.my_bookings')}}
@endsection
@section('front_content')
      <div class="col-xl-9 col-md-8">
         <div class="row align-items-center mb-4">
            <div class="col-md-3 mb-3">
               <h4 class="widget-title mb-0">{{trans('labels.gallery')}}</h4>
            </div>
          
         </div>
         <div class="row service_list" id="popular-service-owl">
            @if(!empty($bookingdata1) && count($bookingdata1)>0)
               @foreach ($bookingdata1 as $bdata)
                  <div class="item shadow-none col-xl-3 col-lg-4 col-md-6 col-sm-6 mx-0 mb-4">
                     <div class="img">
                        <img src="{{Helper::image_path($bdata->image)}}" alt="{{trans('labels.image')}}" class="rounded zoom-in booking-detail-image" data-enlargeable />
                       </div>
                       <a class="btn btn-sm" href="{{ URL::to('/gallery/download/'.$bdata->image) }}">Download</a>
                   </div>
               @endforeach
              
            @else
            <p class="no-center">{{trans('labels.no_data')}}</p>
            @endif
         </div>
      </div>
     
@endsection
 @section('scripts')
      <script>
         $('img[data-enlargeable]').addClass('img-enlargeable').click(function() {
          var src = $(this).attr('src');
          var modal;
          function removeModal() {
             modal.remove();
             $('body').off('keyup.modal-close');
          }
          modal = $('<div>').css({
             background: 'RGBA(0,0,0,.6) url(' + src + ') no-repeat center',
             backgroundSize: 'contain',
             width: '100%',height: '100%',
             position: 'fixed',zIndex: '10000',
             top: '0',left: '0',
             cursor: 'zoom-out'
          }).click(function() {
                removeModal();
             }).appendTo('body');
          $('body').on('keyup.modal-close', function(e) {
             if (e.key === 'Escape') {
                removeModal();
             }
          });
       });

  
    </script>
@endsection