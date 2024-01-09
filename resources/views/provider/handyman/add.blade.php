@extends('layout.main')
@section('page_title',trans('labels.add_handyman'))
@section('content')
<section id="basic-form-layouts">

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.add_handyman') }}</h4>
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form form-horizontal" id="add_handyman_form" action="{{URL::to('handymans-store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="name"> {{ trans('labels.name') }}</label>
											<div class="col-md-9">
												<input type="text" id="add_handyman_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}" placeholder="{{trans('labels.enter_full_name')}}">
												@error('name')<span class="text-danger" id="nam_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="image">{{ trans('labels.profile') }}</label>
											<div class="col-md-9">
												<input type="file" id="add_handyman_image" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image')}}" accept=".png,.jpg,.jpeg">
												@error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="email">{{ trans('labels.email') }} </label>
											<div class="col-md-9">
												<input type="email" id="add_handyman_email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email')}}" placeholder="example1@yourmail.com">
												@error('email')<span class="text-danger" id="email_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="password">{{ trans('labels.password') }}</label>
											<div class="col-md-9">
												<input type="password" id="add_handyman_password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password')}}" placeholder="{{trans('labels.enter_password')}}">
												@error('password')<span class="text-danger" id="password_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="mobile">{{ trans('labels.mobile') }} </label>
											<div class="col-md-9">
												<input type="text" id="add_handyman_mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile')}}" placeholder="Enter Mobile Number">
												@error('mobile')<span class="text-danger" id="mobile_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="address">{{ trans('labels.address') }} </label>
											<div class="col-md-9">
												<textarea id="add_handyman_address" rows="3" class="form-control col-md-12 @error('address') is-invalid @enderror" name="address" placeholder="{{trans('labels.enter_address')}}">{{ old('address')}}</textarea>
												@error('address')<span class="text-danger" id="address_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="userinput4">{{ trans('labels.city') }} </label>
											<div class="col-md-9">
												<select id="add_handyman_city" name="city_id[]" class="form-control @error('city_id') is-invalid @enderror" multiple data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="City">
													<option value="">{{trans('labels.select')}}</option>
													@foreach ($citydata as $cd)
													<option {{ in_array($cd->id, old('city_id', [])) ? 'selected' : '' }} value="{{$cd->id}}">{{$cd->name}}</option>
													@endforeach
												</select>
										
												@error('city_id')<span class="text-danger" id="city_id_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="address">{{ trans('Description') }} </label>
											<div class="col-md-9">
												<textarea id="add_handyman_description" rows="3" class="form-control col-md-12" name="description" placeholder="{{trans('Description ...')}}">{{ old('description')}}</textarea>
												
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="userinput4">{{ trans('price Hourly') }} </label>
											<div class="col-md-9">
											<input type="text" id="add_handyman_booking_price" class="form-control" value="{{ old('booking_price')}}"  name="booking_price" placeholder="Enter price">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions left">
								<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('handymans')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }} </a>
								@if (env('Environment') == 'sendbox')
								<button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{trans('labels.add')}} </button>
								@else
								<button type="submit" id="btn_add_handyman" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
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
<script type="text/javascript" src="{{ asset('resources/views/provider/bootstrap-multiselect.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/views/provider/bootstrap-multiselect.css') }}">
<!-- Initialize the plugin: -->
<script type="text/javascript">
	$(document).ready(function() {
		$('#add_handyman_city').multiselect();
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