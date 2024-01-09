@extends('layout.main')
@section('page_title',trans('labels.edit_category'))
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title" id="basic-layout-icons" >{{ trans('labels.edit_category') }}</h4>  
               </div>
               <div class="card-body">
                  <div class="px-3">
                     <form class="form" id="edit_category_form" action="{{URL::to('/categories/edit/'.$categorydata->slug)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                           <div class="form-group">
                              <label for="name">{{ trans('labels.category_name') }}</label>
                              <input type="text" id="edit_category_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$categorydata->name}}" placeholder="{{ trans('labels.enter_category') }}">
                              @error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group">
                              <div class="row">
                                 <div class="col-md-2">
                                    <label>{{ trans('labels.category_image') }}</label><br>
                                    <img src="{{Helper::image_path($categorydata->image)}}" alt="{{trans('labels.image')}}" class="rounded edit-image">
                                 </div>
                                 <div class="col-md-10">
                                    <label>{{ trans('labels.select_new') }}</label>
                                    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="edit_category_image" name="image" accept=".jpg,.png,.jpeg">
                                    @error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="row">
                                 <div class="col-md-2">
                                    <label>{{ trans('labels.status') }}</label><br>
                                    <div class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="is_available" @if($categorydata->is_available == 1) checked="true" @endif>
                                       <label class="form-check-label" for="is_available">{{ trans('labels.active') }}</label>
                                    </div>
                                 </div>
                                 <div class="col-md-10">
                                    <label>{{ trans('labels.featured') }}</label><br>
                                    <div class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="is_featured" @if($categorydata->is_featured == 1) checked="true" @endif>
                                       <label class="form-check-label" for="is_featured">{{ trans('labels.is_featured') }}</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-actions left">
                              <a class="btn btn-raised btn-danger mr-1" href="{{ URL::to('/categories') }}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }}</a>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
                              @else
                                 <button type="submit" id="btnAddPrd" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
                              @endif
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection