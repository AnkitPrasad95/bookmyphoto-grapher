@extends('front.layout.main')
@section('page_title',trans('labels.categories'))
@section('content')
      <div class="breadcrumb-bar">
         <div class="container-fluid">
            <div class="row">       
               <div class="col">
                  <div class="breadcrumb-title">
                     <h2>{{trans('labels.categories')}}</h2>
                  </div>
               </div>
               <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                  <nav aria-label="breadcrumb" class="page-breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{trans('labels.categories')}}</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>
      <div class="content bg-sec-img">
         <!-- @include('front.category_section') -->
         <div class="catsec">
            <div class="container-fluid">
               @if(!empty($categorydata) && count($categorydata)>0)
                  <div class="row match-height">
                     @foreach($categorydata as $cdata)
                     <div class="col-lg-2 col-md-3 col-sm-6 col-xs-6 col-6">
                        <div class="catsec-single">
                           <a href="{{ URL::to('/home/services/'.$cdata->slug)}}">
                           <img class="img-fluid" src="{{ Helper::image_path($cdata->image) }}" alt="{{trans('labels.image')}}">
                           </a>
                           
                           <a href="{{ URL::to('/home/services/'.$cdata->slug)}}">
                           <h6>{{$cdata->name}}</h6>
                           </a>
                        </div>
                     </div>
                     @endforeach
                  </div>
               @else
                  <p class="text-center">{{trans('labels.no_data')}}</p>
               @endif
            </div>
         </div>
      </div>
@endsection