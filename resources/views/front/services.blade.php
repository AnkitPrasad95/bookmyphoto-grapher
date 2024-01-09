@extends('front.layout.main')

@section('page_title',trans('labels.services'))

@section('content')

   <div class="breadcrumb-bar">
      <div class="container-fluid">
         <div class="row">       
            <div class="col">
               <div class="breadcrumb-title">
                  <h2>{{trans('labels.services')}}</h2>
               </div>
            </div>
            <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
               <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                     <li class="breadcrumb-item" aria-current="page">{{trans('labels.services')}}</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>

   <section class="popular-services bg-sec-img pt-0">
      <div class="content">
         <div class="container-fluid">
            <div class="catsec clearfix">
               @if (!empty($servicedata) && count($servicedata)>0)
                  <div class="row">
                    @include('front.service_section_list')
                  </div>
                  <div class="d-flex justify-content-center">
                     {{ $servicedata->links() }}
                  </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>
         </div>
      </div>
   </section>
@endsection