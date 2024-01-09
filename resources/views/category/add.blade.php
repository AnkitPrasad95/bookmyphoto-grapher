@extends('layout.main')
@section('page_title',trans('labels.add_category'))
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h1 class="card-title">{{ trans('labels.add_category') }}</h1>
               </div>
               <div class="card-body">
                  <div class="px-3">
                     <form class="form" id="add_categpry_form" action="{{ URL::to('/categories/store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                           <div class="form-group">
                              <label for="name">{{ trans('labels.category_name') }}</label>
                              <input type="text" id="category_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" placeholder="{{ trans('labels.enter_category') }}">
                              @error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label>{{ trans('labels.category_image') }}</label>
                              <input type="file" class="form-control @error('image') is-invalid @enderror" id="category_image" name="image" accept=".jpg,.png,.jpeg">
                              @error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                           </div>   
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="is_featured">
                              <label class="form-check-label" for="is_featured">{{ trans('labels.is_featured') }}</label>
                           </div>
                           <div class="form-actions">
                              <a class="btn btn-danger" href="{{ URL::to('/categories')}}"> <i class="fa fa-arrow-left"></i>{{ trans('labels.back') }} </a>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"> <i class="fa fa-paper-plane"></i>{{ trans('labels.add') }}</button>
                              @else
                                  <button type="submit" id="btn_add_category" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i>{{ trans('labels.add') }}</button>
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