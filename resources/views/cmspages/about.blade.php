@extends('layout.main')
@section('page_title',trans('labels.about'))
@section('content')
   <div class="row match-height">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title" id="basic-layout-form-center">{{trans('labels.about')}}</h4>
            </div>
            <div class="card-body">
               <div class="px-3">
                  <form action="{{URL::to('/about/update')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                        <label class="col-md-3 label-control" for="image">{{trans('labels.image')}}</label>
                        <div class="col-md-12">
                           <input type="file" id="edit_image" class="form-control @error('image') is-invalid @enderror" name="image" >
                           @error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-12 pt-1">
                           <img src="{{Helper::image_path($aboutdata->about_image)}}" class="rounded edit-image" alt="{{trans('labels.image')}}">
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="col-md-12">
                           <textarea class="form-control @error('about_content') is-invalid @enderror" rows="10" name="about_content" >{{strip_tags($aboutdata->about_content)}}</textarea>
                           @error('about_content')<span class="text-danger">{{ $message }}</span>@enderror
                        </div>
                     </div>
                     @if (env('Environment') == 'sendbox')
                        <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                     @else
                        <button class="btn btn-raised btn-primary mt-2"><i class="ft-edit"></i> {{trans('labels.update')}}</button>
                     @endif
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection