@extends('layout.main')
@section('page_title',trans('labels.all_methods'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{trans('labels.all_methods')}}</h4>
               </div>
               <div class="card-body">
                  <div class="card-block">
                     @include('payment_methods.pmethods_table')
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/payment_methods/pmethods.js') }}" type="text/javascript"></script>
@endsection