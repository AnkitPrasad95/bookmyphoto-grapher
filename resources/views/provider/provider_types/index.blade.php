@extends('layout.main')
@section('page_title',trans('labels.provider_types'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{ trans('labels.provider_types') }}
                     @if(Auth::user()->type == 1)
                        <a href="{{ URL::to('/provider_types/add')}}" class="btn btn-primary btn-sm float-right">{{ trans('labels.add_new') }}</a>
                     @endif
                  </h4>
               </div>
               <div class="card-body">
                  <div class="card-block">
                     <div class="input-group col-4 float-right">
                        <input type="text" name="search_provider_type" id="search_provider_type" class="form-control" placeholder="{{trans('labels.search_provider_type')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm"/>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                        </div>
                     </div>
                     <input type="hidden" name="url" id="ptype_url" url="{{route('provider_types')}}">
                     <div class="ptype_table">
                        @include('provider.provider_types.ptype_table')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
<script src="{{ asset('resources/views/provider/provider_types/ptype.js') }}" type="text/javascript"></script>
@endsection