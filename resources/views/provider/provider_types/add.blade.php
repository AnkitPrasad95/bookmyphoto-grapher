@extends('layout.main')
@section('page_title',trans('labels.add_provider_type'))
@section('content')
<section id="basic-form-layouts">
   <div class="row">
      <div class="col-sm-12">
         <div class="content-header">{{ trans('labels.provider_type') }}</div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title" id="basic-layout-icons" > {{ trans('labels.add_new') }} </h4>
            </div>
            <div class="card-body">
               <div class="px-3">
                  <form class="form" id="add_provider_type_form" action="{{ URL::to('/provider_types/store')}}" method="POST">
                     @csrf
                     <div class="form-body">
                        <div class="form-group">
                           <label for="name"> {{ trans('labels.name') }}</label>
                           <input type="text" id="add_provider_type_name" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="{{trans('labels.enter_ptype_name')}}">
                            @error('name')<span class="text-danger" id="nameError">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                           <label for="name"> {{ trans('labels.commission') }}</label>
                           <input type="text" id="add_provider_type_commission" class="form-control @error('commission') is-invalid @enderror" name="commission" placeholder="{{ trans('labels.enter_commission') }}">
                           @error('commission')<span class="text-danger" id="commissionError">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-actions">
                           <a class="btn btn-danger" href="{{ URL::to('/provider_types')}}"> <i class="fa fa-arrow-left"></i> {{ trans('labels.back') }}</a>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"><i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
                           @else
                              <button type="submit" id="btn_add_provider_type" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{ trans('labels.add') }} </button>
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
@section('scripts')
   <script src="{{ asset('resources/views/provider/provider_types/ptype.js') }}" type="text/javascript"></script>
@endsection