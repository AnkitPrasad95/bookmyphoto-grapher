@extends('front.layout.main')
@section('page_title',trans('labels.about_us'))
@section('content')
      <div class="breadcrumb-bar">
         <div class="container-fluid">
            <div class="row">
               <div class="col">
                  <div class="breadcrumb-title">
                     <h2>{{trans('labels.about_us')}}</h2>
                  </div>
               </div>
               <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                  <nav aria-label="breadcrumb" class="page-breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('labels.about_us')}}</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
      <section class="about-us">
         <div class="content">
            <div class="container-fluid">
               @if(!empty($aboutdata))
               <div class="row">
                  <div class="col-md-6">
                     <div class="about-blk-content">
                        <!-- <h4 class="text-left">{{trans('labels.about_us')}}</h4> -->
                        <p>{!! nl2br(e($aboutdata->about_content)) !!}</p>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="about-blk-image">
                        <img src="{{ Helper::image_path($aboutdata->about_image) }}" class="img-fluid" alt="{{trans('labels.aboutus_image')}}">
                     </div>
                  </div>
               </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>
         </div>
      </section>
      
      @include('front.how_work')
      
@endsection
