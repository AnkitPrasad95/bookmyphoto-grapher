@extends('layout.main')
@section('page_title',trans('labels.edit_handyman'))
@section('content')
<section id="basic-form-layouts">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.edit_handyman') }}</h4>
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form form-horizontal" action="{{URL::to('/handymans/edit/'.$handymandata->slug)}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="fname">{{ trans('labels.name') }}</label>
											<div class="col-md-9">
												<input type="text" id="edit_handyman_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$handymandata->name}}" placeholder="{{trans('labels.enter_full_name')}}">
												@error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="email">{{ trans('labels.email') }}</label>
											<div class="col-md-9">
												<input type="email" id="edit_handyman_email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$handymandata->email}}" placeholder="example@yourmail.com">
												@error('email')<span class="text-danger" id="email_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="new_image">{{ trans('labels.profile') }}</label>
											<div class="col-md-9">
												<input type="file" id="edit_handyman_image" class="form-control @error('image') is-invalid @enderror" name="image" accept=".png,.jpg,.jpeg">
												@error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="mobile">{{ trans('labels.mobile') }} </label>
											<div class="col-md-9">
												<input type="text" id="edit_handyman_mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{$handymandata->mobile}}" placeholder="{{trans('labels.enter_mobile')}}">
												@error('mobile')<span class="text-danger" id="mobile_rror">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="image">{{ trans('labels.image') }} </label>
											<div class="col-md-9">
												<img src="{{Helper::image_path($handymandata->image)}}" alt="{{trans('labels.image')}}" class="rounded edit-image">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="address">{{ trans('labels.address') }}</label>
											<div class="col-md-9">
												<textarea id="edit_handyman_address" rows="3" class="form-control col-md-12 @error('addr') is-invalid @enderror" name="address" placeholder="{{trans('labels.enter_address')}}">{{strip_tags($handymandata->address)}}</textarea>
												@error('address')<span class="text-danger" id="address_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="userinput4">{{ trans('labels.city') }}</label>
											<div class="col-md-9">
												<select multiple id="EditHandymanCityId" name="city_id[]" class="form-control @error('image') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="City">
													@foreach ($citydata as $cd)
													<option value="{{$cd->id}}" @foreach($cityID as $sublist){{$sublist == $cd->id ? 'selected': ''}} @endforeach>{{$cd->name}}</option>
													@endforeach
												</select>
												@error('city_id')<span class="text-danger" id="cityError">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row">
											<label class="col-md-3 label-control" for="is_available">{{ trans('labels.status') }} </label>
											<div class="col-md-9">
												<div class="form-check form-switch">
													<input class="form-check-input " type="checkbox" id="is_available" name="is_available" value="is_available" @if($handymandata->is_available == 1) checked="true" @endif>
													<label class="form-check-label " for="is_available">{{ trans('labels.active') }}</label>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="address">{{ trans('Description') }} </label>
											<div class="col-md-9">
												<textarea id="add_handyman_description" rows="3" class="form-control col-md-12" name="description" placeholder="{{trans('Description ...')}}">{{$handymandata->description}}</textarea>

											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="userinput4">{{ trans('price Hourly') }} </label>
											<div class="col-md-9">
												<input type="text" id="add_handyman_booking_price" class="form-control" name="booking_price" value="{{$handymandata->booking_price}}" placeholder="Enter Instant Booking Price Hourly">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions left">
								<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('handymans')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }} </a>
								@if (env('Environment') == 'sendbox')
								<button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
								@else
								<button type="submit" id="btn_edit_handyman" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
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
<script src="{{ asset('resources/views/provider/handyman/handyman.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="https://gautamgupta.info/resources/views/provider/bootstrap-multiselect.js"></script>
<link rel="stylesheet" type="text/css" href="https://gautamgupta.info/resources/views/provider/bootstrap-multiselect.css">
<script type="text/javascript">
	$(document).ready(function() {
		$('#EditHandymanCityId').multiselect();
	});
</script>
<style>
	.dropdown-menu {
		min-width: 15rem;
	}

	.dropdown-menu li,
	dd {
		line-height: 1rem;
	}

	.dropdown-menu .active a:focus,
	.dropdown-menu .active a:hover {
		background-color: #fff;
	}

	.dropdown-menu .active a {
		background-color: #fff;
	}
</style>
@endsection