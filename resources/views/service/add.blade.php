@extends('layout.main')
@section('page_title',trans('labels.add_service'))
@section('content')
<?php
// echo "<pre>";
// print_r($masterServiceData->toArray());
// echo "</pre>";
?>
<section id="basic-form-layouts">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.add_service') }}</h4>
				</div>
				<div class="card-body">
					<div class="px-3">
						<form class="form form-horizontal" id="add_service_form" action="{{URL::to('services-store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-body">
                                <div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="category_id"> {{trans('labels.category')}} </label>
											<div class="col-md-9">
												<select id="add_service_category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="category_id">
													<option value="" selected disabled>{{trans('labels.select')}}</option>
													@foreach ($categorydata as $cd)
													<option {{ old('category_id') == $cd->id ? 'selected' : ''}} value="{{$cd->id}}">{{$cd->name}}</option>
													@endforeach
												</select>
												@error('category_id')<span class="text-danger" id="category_id_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="service_id"> {{trans('labels.service')}} </label>
											<div class="col-md-9">
												<select id="add_service_name" name="name" class="form-control @error('name') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="name">
													<option value="" selected disabled>{{trans('labels.select')}}</option>
													<!--@foreach ($masterServiceData as $sd)-->
													<!--<option {{ old('service_id') == $sd->id ? 'selected' : ''}} value="{{$sd->id}}">{{$sd->name}}</option>-->
													<!--@endforeach-->
												</select>
												@error('service_id')<span class="text-danger" id="service_id_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<!--<div class="row">-->

								<!--	<div class="col-md-6">-->
								<!--		<div class="form-group row">-->
								<!--			<label class="col-md-3 label-control" for="name">{{trans('labels.service')}}</label>-->
								<!--			<div class="col-md-9">-->
								<!--				<input type="text" id="add_service_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}" placeholder="{{trans('labels.enter_service')}}">-->
								<!--				@error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--	<div class="col-md-6">-->
								<!--		<div class="form-group row">-->
								<!--			<label class="col-md-3 label-control" for="category_id"> {{trans('labels.category')}} </label>-->
								<!--			<div class="col-md-9">-->
								<!--				<select id="add_service_category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="category_id">-->
								<!--					<option value="" selected disabled>{{trans('labels.select')}}</option>-->
								<!--					@foreach ($categorydata as $cd)-->
								<!--					<option {{ old('category_id') == $cd->id ? 'selected' : ''}} value="{{$cd->id}}">{{$cd->name}}</option>-->
								<!--					@endforeach-->
								<!--				</select>-->
								<!--				@error('category_id')<span class="text-danger" id="category_id_error">{{ $message }}</span>@enderror-->
								<!--			</div>-->
								<!--		</div>-->
								<!--	</div>-->
								<!--</div>-->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="image">{{trans('labels.image')}}</label>
											<div class="col-md-9">
												<input type="file" class="form-control @error('image') is-invalid @enderror" id="service_image" name="image" accept=".jpg,.jpeg,.png" value="{{ old('image')}}">
												@error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="gallery_image">{{trans('labels.gallery')}}</label>
											<div class="col-md-9">
												<input type="file" id="add_service_gallery_image" class="form-control @if($errors->has('gallery_image.*')) is-invalid @endif" name="gallery_image[]" accept="image/*" multiple>
												@error('gallery_image')<span class="text-danger" id="gallery_image_error">{{ $message }}</span>@enderror
												@if ($errors->has('gallery_image.*'))
												<span class="text-danger">{{ $errors->first('gallery_image.*') }}</span>
												@endif
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="price">{{trans('labels.price')}}</label>
											<div class="col-md-9 ">
												<input type="text" id="service_price" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price')}}" placeholder="{{trans('labels.enter_price')}}">
												@error('price')<span class="text-danger" id="priceError">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<!--<div class="col-md-6">-->
									<!--	<div class="form-group row">-->
									<!--		<label class="col-md-3 label-control" for="discount">{{trans('labels.discount')}}</label>-->
									<!--		<div class="col-md-9 ">-->
									<!--			<input type="text" id="service_discount" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount')}}" placeholder="{{trans('labels.enter_discount')}}">-->
									<!--			@error('discount')<span class="text-danger" id="discount_error">{{ $message }}</span>@enderror-->
									<!--		</div>-->
									<!--	</div>-->
									<!--</div>-->
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="featured">{{trans('labels.featured')}} </label>
											<div class="col-md-9">
												<div class="form-check form-switch">
													<input class="form-check-input " type="checkbox" id="is_featured" name="is_featured" value="is_featured">
													<label class="form-check-label " for="is_featured">{{trans('labels.set_as_featured')}}</label>
												</div>
												@error('is_featured')<span class="text-danger" id="is_featured_error">{{ $message }}</span>@enderror
											</div>
										</div>
										</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-md-3 label-control" for="price_type">{{trans('labels.price_type')}}</label>
											<div class="col-md-9">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="price_type" onChange="getduration(this)" id="fixed" value="Fixed" checked="checked">
													<label class="form-check-label" for="fixed">{{trans('labels.fixed')}}</label>
												</div>
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="price_type" onChange="getduration(this)" id="hourly" value="Hourly" @if(old('price_type')=='Hourly' ) checked @endif>
													<label class="form-check-label" for="hourly">{{trans('labels.hourly')}}</label>
												</div>
												@error('price_type')<span class="text-danger" id="price_type_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row @if(old('price_type') == 'Hourly') dn @endif" id="duration_type">
											<label class="col-md-3 label-control" for="duration_type">{{trans('labels.type')}}</label>
											<div class="col-md-9 ">
												<select class="form-control selectbox select" name="duration_type"> 
													<!--<option @if(old('duration_type')=="1" ) selected @endif value="1"> {{trans('labels.minutes')}} </option>-->
													<option @if(old('duration_type')=="2" ) selected @endif value="2"> {{trans('labels.hours')}} </option>
													<option @if(old('duration_type')=="3" ) selected @endif value="3"> {{trans('labels.days')}} </option>
												</select>
												@error('duration_type')<span class="text-danger" id="duration_type_error">{{ $message }}</span>@enderror
											</div>
										</div>
										<div class="form-group row @if(old('price_type') == 'Hourly') dn @endif" id="duration">
											<label class="col-md-3 label-control" for="duration">{{trans('labels.duration')}}</label>
											<div class="col-md-9 ">
												<input type="text" id="service_duration" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration')}}" placeholder="{{trans('labels.enter_duration')}}">
												@error('duration')<span class="text-danger" id="duration_error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
									<div class="col-md-6">
									
										<div class="form-group row">
											<label class="col-md-3 label-control" for="description">{{trans('labels.description')}} </label>
											<div class="col-md-9">
												<textarea id="add_service_description" rows="2" class="form-control col-md-12 @error('description') is-invalid @enderror editor_tinyMc" name="description" placeholder="{{trans('labels.service_description')}}">{{old('description')}}</textarea>
												@error('description')<span class="text-danger" id="descriptionError">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>

							</div>
							<div class="form-actions left">
								<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('services')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back')}} </a>
								@if (env('Environment') == 'sendbox')
								<button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{trans('labels.add')}} </button>
								@else
								<button type="submit" id="btn_add_service" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{trans('labels.add')}} </button>
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
<script src="{{ asset('resources/views/service/service.js') }}" type="text/javascript"></script>
<script src="https://cdn.tiny.cloud/1/0pvblvpkzkjl5tcff7t5ot1fqadvemydpud78ki7ltsgnyrj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
      selector: '.editor_tinyMc', // Replace 'your-class-name' with the actual class name of your textarea or div
      // other configuration options
    });
    
  
    $(document).ready(function () {
      // Function to handle checkbox changes
      $("#add_service_category_id").change(function () {
         var category_id = $(this).val(); 
         //alert(category_id);
        

         // Send AJAX request to update the checkbox state in the server
         $.ajax({
            type: "POST",
            url: "{{URL::to('/services/getServices')}}",
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { 'category_id': category_id },
            success: function (response) {
              //console.log('response');
              var option = '';
              option += '<option value="" selected disabled>{{trans('labels.select')}}</option>';
              if (response.data.length > 0) {
                  console.log(response.data.length);
                    response.data.forEach(function(item) {
                        
                        option += '<option value="' + item.name + '">' + item.name + '</option>';
                    });
                }
              console.log(option);
              $('#add_service_name').html(option);
               //location.reload();
            }
         });


      });
   });

</script>
@endsection