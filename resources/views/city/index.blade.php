@extends('layout.main')
@section('page_title',trans('labels.cities'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{ trans('labels.cities') }}
                     @if(Auth::user()->type == 1)
                        <a href="{{ URL::to('/cities/add')}}" class="btn btn-primary btn-sm float-right">{{ trans('labels.add_new') }}</a>
                     @endif
                  </h4>
               </div>
               <div class="card-body">
                  <div class="card-block">
                     <div class="input-group col-4 float-right">
                        <input type="text" name="search_city_name" id="search_city_name" class="form-control" placeholder="{{trans('labels.search_city')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm"/>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                        </div>
                     </div>
                     <input type="hidden" name="url" id="city_url" url="{{route('cities')}}">
                     <div class="city_table">
                        @include('city.city_table')
                     </div>  
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
<script src="{{ asset('resources/views/city/city.js') }}" type="text/javascript"></script>
@endsection