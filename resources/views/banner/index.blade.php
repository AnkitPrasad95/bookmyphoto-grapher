@extends('layout.main')
@section('page_title',trans('labels.banners'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{trans('labels.banners')}}
                     <a href="{{ URL::to('/banners/add')}}" class="btn btn-primary btn-sm float-right">{{trans('labels.add_new')}}</a>
                  </h4>
               </div>
               <div class="card-body">
                  <div class="card-block">
                     @include('banner.banner_table')
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/banner/banner.js') }}" type="text/javascript"></script>
@endsection