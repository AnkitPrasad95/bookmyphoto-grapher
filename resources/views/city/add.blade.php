@extends('layout.main')
@section('page_title',trans('labels.add_city'))
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h1 class="card-title">{{ trans('labels.add_city') }}</h1>
               </div>
               <div class="card-body">
                  <div class="px-3">
                     <form class="form" id="add_city_form" action="{{ URL::to('/city/store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                           <div class="form-group">
                              <label for="name">{{ trans('labels.city_name') }}</label>
                              <input type="text" id="add_city_name" class="form-control @error('name') is-invalid @enderror " name="name" placeholder="{{ trans('labels.enter_city')}}">
                              @error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label for="image">{{ trans('labels.city_image') }}</label>
                              <input type="file" id="add_city_image" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg,.png,.jpeg">
                              @error('image')<span class="text-danger" id="image_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-actions">
                              <a class="btn btn-danger" href="{{ URL::to('/cities') }}"><i class="fa fa-arrow-left"></i> {{ trans('labels.back') }} </a>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
                              @else
                                 <button type="submit" id="btn_add_city" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
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