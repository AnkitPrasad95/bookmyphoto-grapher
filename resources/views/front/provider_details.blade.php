@extends('front.layout.main')
@section('page_title',$providerdata->provider_name)
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
            <div class="widget">
               <h5 class="mb-0">{{trans('labels.profile')}}</h5>
               <hr>

               @if(!empty($providerdata))
               <div class="row">
                  <div class="form-group col-xl-6">
                     <label class="mr-sm-2">{{trans('labels.name')}}</label>
                     <input class="form-control bg-white" type="text" value="{{$providerdata->provider_name}}" disabled>
                  </div>
                  <div class="form-group col-xl-6">
                     <label class="mr-sm-2">{{trans('labels.email')}}</label>
                     <input class="form-control bg-white" type="email" value="{{$providerdata->email}}" disabled>
                  </div>
                  <div class="form-group col-xl-6">
                     <label class="mr-sm-2">{{trans('labels.mobile')}}</label>
                     <input class="form-control no_only bg-white" type="text" value="{{$providerdata->mobile}}" disabled>
                  </div>
                  <div class="form-group col-xl-6">
                     <label class="mr-sm-2">{{trans('labels.address')}}</label>
                     <input class="form-control bg-white" type="text" value='{{strip_tags($providerdata->address)}}' disabled>
                  </div>
                  <div class="form-group col-xl-12">
                     <label class="mr-sm-2">{{trans('labels.about')}}</label>
                     <textarea class="form-control bg-white" rows="3" disabled>{{strip_tags($providerdata->about)}}</textarea>
                  </div>
               </div>
               @else
               <p class="text-center"> {{trans('labels.no_data')}}</p>
               @endif
            </div>
            <h5 class="mb-0">{{trans('labels.service_availability')}}</h5>
            <hr>
            <div class="card mb-0">
               <div class="card-body">
                  <div class="form-group">
                     @if (!empty($timingdata))
                     <div class="row">
                        <div class="col-md-12">
                           <div class="table-responsive">
                              <table class="table availability-table">
                                 <thead class="thead-dark">
                                    <tr>
                                       <th>{{trans('labels.days')}}</th>
                                       <th>{{trans('labels.from_time')}}</th>
                                       <th>{{trans('labels.to_time')}}</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    @foreach ($timingdata as $tdata)
                                    <tr>
                                       <td>{{$tdata->day}}</td>
                                       @if ($tdata->is_always_close == 1)
                                       <td colspan="2"> <i> {{trans('labels.not_available')}} </i></td>
                                       @else
                                       <td>{{$tdata->open_time}}</td>
                                       <td>{{$tdata->close_time}}</td>
                                       @endif
                                    </tr>
                                    @endforeach
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                     @else
                     <p class="text-center"> {{trans('labels.no_data')}}</p>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection