
@extends('layout.main')
@section('page_title',trans('labels.reviews'))
@section('content')
	<div class="col-sm-12 col-md-6 col-lg-12">
      <div class="card">
			<div class="card-header">
				<h4 class="card-title">
					{{trans('labels.average_ratting')}} <span class="badge badge-light text-right"><i class="fa fa-star yellow"></i> {{number_format($averageratting->avg_ratting,1)}}</span>
				</h4>
			</div>
         <div class="card-body">
         	@if(!empty($rattingsdata) && count($rattingsdata)>0)
            <div class="card-block">
					@foreach ($rattingsdata as $rdata)
						<div class="form-group row border-bottom border-dark mb-2">
							<div class="col-md-1 mb-1">
								<img class="rounded img-fluid" src="{{Helper::image_path($rdata->user_image)}}" alt="{{trans('labels.image')}}" class="rounded table-image">
							</div>
							<div class="col-md-11 ">
								<div class="row">
									<div class="col col-md-10"><strong>{{$rdata->user_name}}</strong></div>
									<div class="col col-md-2 text-right text-muted">{{Helper::date_format($rdata->date)}}</div>
									<div class="w-100"></div>
									<div class="col col-md-10">{{strip_tags($rdata->comment)}}</div>
									<div class="col col-md-2 text-right">
										<i class="fa fa-star yellow"></i>
										<span class="d-inline-block average-rating">{{number_format($rdata->ratting,1)}}</span>
									</div>
								</div>
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