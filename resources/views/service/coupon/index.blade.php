@extends('layout.main')
@section('page_title',trans('labels.coupons'))
@section('content')
<section id="contenxtual">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title">{{trans('labels.coupons')}}
                  @if(Auth::user()->type == 1 || Auth::user()->type == 2)
                  <a href="{{ URL::to('/coupons/add')}}" class="btn btn-primary btn-sm float-right">{{trans('labels.add_new')}}</a>
                  @endif
               </h4>
            </div>
            <div class="card-body">
               <div class="card-block">
                  <div class="input-group col-4 float-right">
                     <input type="text" name="search_coupon" id="search_coupon" class="form-control" placeholder="{{trans('labels.search_coupon')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm" />
                     <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                     </div>
                  </div>
                  <input type="hidden" name="url" id="coupon_url" url="{{route('coupons')}}">
                  <div class="coupon_table">

                     @include('service.coupon.coupon_table')
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!--Responsive tables Ends-->
@endsection
@section('scripts')
<script src="{{ asset('resources/views/service/coupon/coupon.js') }}" type="text/javascript"></script>
@endsection