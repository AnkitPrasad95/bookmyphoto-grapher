@extends('front.layout.main')
@section('page_title',trans('labels.providers'))
@section('content')
      <div class="breadcrumb-bar">
         <div class="container-fluid">
            <div class="row">       
               <div class="col">
                  <div class="breadcrumb-title">
                     <h2>{{trans('labels.providers')}}</h2>
                  </div>
               </div>
               <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                  <nav aria-label="breadcrumb" class="page-breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('labels.providers')}}</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
      <div class="content bg-sec-img">
         <div class="container-fluid">
            <div class="catsec clearfix">
               @if (!empty($providerdata) && count($providerdata)>0)
                  <div class="row">
                     @include('front.provider_section_list')
                  </div>
                  <div class="d-flex justify-content-center">
                     {{ $providerdata->links() }}
                  </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>
         </div>
      </div>
@endsection