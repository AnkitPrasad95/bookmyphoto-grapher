@extends('layout.main')
@section('page_title',trans('labels.gallery'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{trans('labels.gallery')}}
                     <div class="input-group col-4 float-right">
                        <input type="text" name="search_booking" id="search_booking" class="form-control" placeholder="{{trans('labels.search_booking')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm"/>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                        </div>
                     </div>
                     <input type="hidden" name="url" id="fetch_bookings_url" url="{{route('galleryList')}}">
                  </h4>
               </div>
               <div class="card-body">
                  <div class="card-block booking_table">
                     
                     @include('gallery.gallery_table')
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/gallery/gallery.js') }}" type="text/javascript"></script>
@endsection