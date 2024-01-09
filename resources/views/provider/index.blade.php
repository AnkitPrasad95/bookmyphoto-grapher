
@extends('layout.main')
@section('page_title',trans('labels.providers'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{ trans('labels.providers') }}
                     @if(Auth::user()->type == 1)
                        <a href="{{ URL::to('/providers/add')}}" class="btn btn-primary btn-sm float-right">{{ trans('labels.add_new') }}</a>
                     @endif
                  </h4>
                  
               </div>
               <div class="card-body">
                  <div class="card-block">
                     <div class="input-group col-4 float-right">
                        <input type="text" name="search_provider" id="search_provider" class="form-control" placeholder="{{trans('labels.search_provider')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm"/>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                        </div>
                     </div>
                     <input type="hidden" name="url" id="provider_url" url="{{route('providers')}}">
                     <div class="provider_table">
                        
                        @include('provider.provider_table')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/provider/provider.js') }}" type="text/javascript"></script>
@endsection