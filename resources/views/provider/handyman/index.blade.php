@extends('layout.main')
@section('page_title',trans('labels.handymans'))
@section('content')
   <section id="ordering">
      <div class="row">
         <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{trans('labels.handyman')}}
                     @if(Auth::user()->type == 2)
                        <a href="{{ URL::to('/handymans-add')}}" class="btn btn-primary btn-sm float-right">{{ trans('labels.add_new') }}</a>
                     @endif
                  </h4>
               </div>
               <div class="card-body collapse show">
                  <div class="card-block card-dashboard">
                     @include('provider.handyman.handyman_table')                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
<script src="{{ asset('resources/views/provider/handyman/handyman.js') }}" type="text/javascript"></script>
@endsection