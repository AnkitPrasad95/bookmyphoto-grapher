@extends('front.layout.main')

@section('page_title',trans('labels.success'))

<script type="text/javascript">
  function preventBack() { "use strict"; window.history.forward(); }  
  setTimeout("preventBack()", 0);
  window.onunload = function () { null };
</script>

@section('content')

  <div class="breadcrumb-bar">
    <div class="container-fluid">
        <div class="row">
          <div class="col">
              <div class="breadcrumb-title">
                  <h2>{{ trans('labels.success') }}</h2>
              </div>
          </div>
          <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
            <nav aria-label="breadcrumb" class="page-breadcrumb">
              <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
               <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.booking_success') }}</li>
              </ol>
            </nav>
          </div>
        </div>
    </div>
  </div>
  <div class="content bg-sec-img">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12">
        
          <div class="card py-3 mt-sm-3 border-success">
            <div class="card-body text-center">
            <h2 class="pb-2">{{trans('labels.thanks_for_booking')}}</h2>
            <p class="mb-2">{{trans('labels.booking_placed_processed')}}</p>
              <a class="btn btn-secondary mt-3 mr-3" href="{{URL::to('/')}}"> <i class="fa fa-home"></i> {{trans('labels.home')}} </a>
              <a class="btn btn-red mt-3" href="{{URL::to('/home/user/bookings')}}"><i class="fa fa-chart-line"></i> {{trans('labels.track_booking')}} </a>
            </div>
          </div>
        
        </div>
      </div>
    </div>
  </div>

@endsection