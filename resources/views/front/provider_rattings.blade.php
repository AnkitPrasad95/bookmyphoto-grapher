@extends('front.layout.main')
@section('page_title')
   {{$providerdata->provider_name}} | {{trans('labels.reviews')}}
@endsection

@section('content')

    <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="breadcrumb-title">
                        <h2>{{trans('labels.reviews')}}</h2>
                    </div>
                </div>
                <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('labels.home')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ URL::to('/home/providers') }}">{{trans('labels.providers')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $providerdata->provider_name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

      <div class="content bg-sec-img">
         <div class="container-fluid">
            <div class="row">
               @include('front.layout.provider_menu')
               <div class="col-xl-9 col-md-8">
                  <h4 class="widget-title">{{trans('labels.reviews')}}</h4>
                  @if (!empty($providerrattingsdata) && count($providerrattingsdata)>0)
                     <div class="card review-card mb-0">
                        <div class="card-body">
                           @foreach ($providerrattingsdata as $prdata)
                              <div class="review-list d-flex flex-nowrap">
                                 <div class="review-img">
                                    <img class="rounded img-fluid" src="{{Helper::image_path($prdata->user_image)}}" alt="">
                                 </div>
                                 <div class="review-info">
                                    <div class="review-user mt-2"><b>{{$prdata->user_name}}</b></div>
                                    <p class="mb-2">{{$prdata->comment}}</p>
                                 </div>
                                 <div class="review-count">
                                    <div class="col">
                                       <div class="text-muted">{{$prdata->date}}</div>
                                       <div class="rating text-right">
                                          <i class="fas fa-star filled"></i>
                                          <span class="d-inline-block average-rating">{{number_format($prdata->ratting,1)}}</span>
                                       </div>
                                    </div>
                                 </div>
                                 
                              </div>

                           @endforeach
                              
                        </div>
                     </div>
                     <div class="d-flex justify-content-center">
                        {!! $providerrattingsdata->links() !!}
                     </div>
                  @else
                     <p class="text-center">{{trans('labels.no_data')}}</p>
                  @endif
               </div>
            </div>
         </div>
      </div>

@endsection
