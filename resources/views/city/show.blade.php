@extends('layout.main')
@section('page_title',trans('labels.edit_city'))
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title" id="basic-layout-icons" > {{ trans('labels.edit_city') }} </h4>  
               </div>
               <div class="card-body">
                  <div class="px-3">
                     <form class="form" id="edit_city_form" action="{{URL::to('/cities/edit/'.$updatecitydata->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                           <div class="form-group col-md-12">
                              <label for="name">{{ trans('labels.city_name') }}</label>
                              <input type="text" id="edit_city_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$updatecitydata->name}}" placeholder="{{ trans('labels.enter_city') }}">
                              @error('name')<span class="text-danger" id="nameError">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group col-md-12">
                              <label for="image">{{ trans('labels.city_image') }}</label>
                              <input type="file" id="add_city_image" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg,.png,.jpeg">
                              @error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group col-md-12">
                              <img src="{{Helper::image_path($updatecitydata->image)}}" alt="{{trans('labels.image')}}" class="rounded edit-image">
                           </div>
                           <div class="form-group col-md-12">
                              <div class="row">
                                 <div class="col-md-2">
                                    <div class="form-check form-switch">
                                       <input class="form-check-input" type="checkbox" id="is_available" name="is_available" value="is_available" @if($updatecitydata->is_available == 1) checked="true" @endif>
                                       <label class="form-check-label" for="is_available">{{ trans('labels.active') }}</label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="form-actions left">
                              <a class="btn btn-raised btn-danger mr-1" href="{{ URL::to('/cities') }}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }} </a>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
                              @else
                                 <button type="submit" id="btn_edit_city" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
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