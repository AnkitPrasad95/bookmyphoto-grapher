@extends('front.layout.main')

@section('page_title',trans('labels.terms_conditions'))

@section('content')
      <div class="breadcrumb-bar">
         <div class="container-fluid">
            <div class="row">
               <div class="col">
                  <div class="breadcrumb-title">
                     <h2>{{trans('labels.terms_conditions')}}</h2>
                  </div>
               </div>
               <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                  <nav aria-label="breadcrumb" class="page-breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('labels.terms_conditions')}}</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
      <section class="about-us">
         <div class="content">
            <div class="container-fluid">
               @if(!empty($tcdata))
               <div class="row">
                  <div class="col-12">
                     <div class="about-blk-content" >
                        <h4 class="text-center">{{trans('labels.terms_conditions')}}</h4>
                        <p>{{$tcdata->tc_content}}</p>
                     </div>
                  </div>
               </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>
         </div>
      </section>
      
@endsection