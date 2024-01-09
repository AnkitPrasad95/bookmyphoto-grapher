@extends('layout.main')
@section('page_title',trans('labels.add_banner'))
@section('content')
	<section id="basic-form-layouts">
		<div class="row">
			<div class="col-md-12">
	        	<div class="card">
	            <div class="card-header">
						<h4 class="card-title" id="horz-layout-colored-controls">{{ trans('labels.add_banner') }}</h4>
	            </div>
	            <div class="card-body">
	               <div class="px-3">
					    	<form class="form form-horizontal" id="add_banner_form" action="{{URL::to('banners/store')}}" method="POST" enctype="multipart/form-data">
								@csrf
	                    	<div class="form-body">
	                    		<div class="row">
	                    			<div class="col-md-12">
											<div class="form-group row">
												<label class="col-md-2 label-control" for="type">{{trans('labels.banner_type')}}</label>
												<div class="col-md-9">
													<select id="banner_type" name="type" class="form-control border" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="banner_type">
														<option value="" selected>{{trans('labels.select')}}</option>
                                          <option value="1" @if (old('type') == '1') selected @endif>{{trans('labels.category')}}</option>
                                          <option value="2" @if (old('type') == '2') selected @endif>{{trans('labels.service')}}</option>
													</select>
													@error('type')<span class="text-danger" id="type_error">{{ $message }}</span>@enderror
												</div>
											</div>
										</div>
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
											<div class="form-group row" id="category">
												<label class="col-md-2 label-control" for="category_id">{{trans('labels.category')}}</label>
												<div class="col-md-9">
													<select id="category_id" name="category_id" class="form-control border" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="category_id">
														<option value="" selected>{{trans('labels.select_category')}}</option>
                                          @foreach($categorydata as $cdata)
                                             <option value="{{$cdata->id}}">{{$cdata->name}}</option>
                                          @endforeach
													</select>
													@error('category_id')<span class="text-danger" id="type_error">{{ $message }}</span>@enderror
												</div>
											</div>
                                 <div class="form-group row" id="service">
												<label class="col-md-2 label-control" for="service_id">{{trans('labels.service')}}</label>
												<div class="col-md-9">
													<select id="service_id" name="service_id" class="form-control border" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="service_id">
														<option value="" selected>{{trans('labels.select_service')}}</option>
                                          
                                          @foreach($servicedata as $sdata)
                                             <option value="{{$sdata->id}}">{{$sdata->name}}</option>
                                          @endforeach
													</select>
													@error('service_id')<span class="text-danger" id="type_error">{{ $message }}</span>@enderror
												</div>
											</div>
										</div>
		                     </div>
								</div>
								<div class="form-actions left">
									<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('banners')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back')}} </a>
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
	<script src="{{ asset('resources/views/banner/banner.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		@if (old('type') == '1') 
         $('#category').show();
         $('#service').hide();
      @elseif (old('type') == '2') 
         $('#service').show();
         $('#category').hide();
      @else
         $('#category').hide();
         $('#service').hide();
      @endif
	</script>
@endsection