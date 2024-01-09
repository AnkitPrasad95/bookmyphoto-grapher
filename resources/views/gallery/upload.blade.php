@extends('layout.main')
@section('page_title')
   {{trans('labels.gallery')}} | {{$bookingdata->booking_id}}
@endsection
@section('content')
  	<section id="basic-form-layouts">
		<div class="row">
			<div class="col-md-12">
  			<div class="card">
      		<div class="card-header">
						<h4 class="card-title" id="horz-layout-colored-controls">Add Gallery</h4>
      		</div>
      		<div class="card-body">
         		<div class="px-3">
         		 <span class="text-danger" id="add_gallery_image_error"></span>  
         		 <span class="text-success" id="add_gallery_image_success"></span>  
				<form method="post" name="add_image_gallery" class="form" id="add_image_gallery" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="gallery_booking_id" id="gallery_booking_id" value={{$bookingdata->booking_id}}>
                <input type="hidden" name="add_gallery_url" id="add_gallery_url" url="{{ URL::to('gallery/image/add') }}">
                          
              	<div class="form-body">
                	<div class="row">
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
	            </div>
				<div class="form-actions left">
						<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('gallery')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back')}} </a>
						@if (env('Environment') == 'sendbox')
                    	<button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{trans('labels.add')}} </button>
                    	@else
							<button type="submit" id="btn_add_gallery" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{trans('labels.add')}} </button>
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
   <script src="{{ asset('resources/views/gallery/gallery.js') }}" type="text/javascript"></script>
@endsection