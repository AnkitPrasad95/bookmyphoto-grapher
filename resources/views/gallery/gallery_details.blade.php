@extends('layout.main')
@section('page_title')
   {{trans('labels.gallery')}}
@endsection
@section('content')
   <section id="list">
     

      <!-- Service info -->
      <div class="row match-height">
          
         <div class="col-sm-12 col-md-6 col-lg-12">
            
            <div class="card">
               <div class="row service_list" id="popular-service-owl" >
                   @if(count($bookingdata) > 0)
                     @foreach($bookingdata as $bdata)
                     <div class="item shadow-none col-xl-3 col-lg-4 col-md-6 col-sm-6 mx-0 mb-4">
                         <div class="img">
                             <img src="{{Helper::image_path($bdata->image)}}" class="rounded zoom-in booking-detail-image" data-enlargeable/>
                            
                          </div>
                      </div>
                     @endforeach
                @else
                         <div class="media">
                               {{trans('labels.no_data')}}
                          </div>
                      @endif
               </div>
            </div>
         </div>
       
      </div>
    
     
   </section>
   <style>
   #popular-service-owl {
    padding: 15px 20px;
}
    #popular-service-owl .item {
    -webkit-box-shadow: 0 0 15px rgb(0 0 0 / 5%);
    box-shadow: 0 0 15px rgb(0 0 0 / 5%);
    margin-bottom: 20px;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
    margin-left: 10px;
    margin-right: 10px;
   
}
    
    .shadow-none {
        box-shadow: none !important;
    }
       #popular-service-owl .item .img {
    position: relative;
    overflow: hidden;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
}
#popular-service-owl .item .img img {
    height: 250px;
    object-fit: cover;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    position: relative;
    width: 100%;
    transform: scale(1);
    transition: all 0.3s ease;
}
   </style>
   
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/booking/booking.js') }}" type="text/javascript"></script>
   
@endsection