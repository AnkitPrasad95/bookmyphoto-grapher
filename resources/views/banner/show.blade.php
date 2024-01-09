@extends('layout.main')
@section('page_title',trans('labels.edit_banner'))
@section('content')
<section id="basic-form-layouts">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.edit_banner') }}</h4>
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form form-horizontal" id="add_banner_form" action="{{URL::to('banners/edit/'.$bannerdata->id)}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-md-2 label-control" for="type">{{trans('labels.banner_type')}}</label>
											<div class="col-md-9">
												<select id="banner_type" name="type" class="form-control border" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="banner_type">

													<option value="1" @if ($bannerdata->type == '1') selected="selected" @endif>{{trans('labels.category')}}</option>
													<option value="2" @if ($bannerdata->type == '2')) selected="selected" @endif>{{trans('labels.service')}}</option>
												</select>
												@error('type')<span class="text-danger" id="type_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group row @if($bannerdata->type == '2') dn @endif " id="category" @if ($bannerdata->type == '1') style="visibility:visible;" @endif>
											<label class="col-md-2 label-control" for="category">{{trans('labels.category')}}</label>
											<div class="col-md-9">
												<select id="category_id" name="category_id" class="form-control border" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="category_id">
													@if ($bannerdata->type == '1')
													<option value="{{$bannerdata['categoryname']->id}}" selected>{{$bannerdata['categoryname']->name}}</option>
													@endif
													@foreach($categorydata as $cdata)
													<option value="{{$cdata->id}}">{{$cdata->name}}</option>
													@endforeach
												</select>
												@error('category_id')<span class="text-danger" id="type_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row @if($bannerdata->type == '1') dn @endif" id="service" @if ($bannerdata->type == '2') style="visibility:visible;" @endif>
											<label class="col-md-2 label-control" for="service">Service</label>
											<div class="col-md-9">
												<select id="service_id" name="service_id" class="form-control border" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="service_id">

													@if ($bannerdata->type == '2')
													<option value="{{$bannerdata['servicename']->id}}" selected>{{$bannerdata['servicename']->name}}</option>
													@endif
													@foreach($servicedata as $sdata)
													<option value="{{$sdata->id}}">{{$sdata->name}}</option>
													@endforeach
												</select>
												@error('service_id')<span class="text-danger" id="type_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-md-2 label-control" for="image">{{trans('labels.image')}}</label>
											<div class="col-md-9">
												<input type="file" class="form-control border" id="banner_image" name="image" accept=".jpg,.jpeg,.png" value="{{ old('image')}}">
												@error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group row">
											<label class="col-md-2 label-control" for="image">{{trans('labels.image')}}</label>
											<div class="col-md-9">
												<img src="{{Helper::image_path($bannerdata->image)}}" alt="{{trans('labels.image')}}" class="rounded edit-image">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions left">
								<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('banners')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back')}} </a>
								@if (env('Environment') == 'sendbox')
								<button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
								@else
								<button type="submit" id="btn_add_service" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
								@endif
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('resources/views/banner/banner.js') }}" type="text/javascript"></script>
@endsection