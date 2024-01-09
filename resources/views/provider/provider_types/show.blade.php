@extends('layout.main')
@section('page_title',trans('labels.edit_rovider_type'))
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title" id="basic-layout-icons" > {{ trans('labels.edit_rovider_type') }} </h4>  
               </div>
               <div class="card-body">
                  <div class="px-3">
                     <form class="form" id="edit_provider_type_form" action="{{URL::to('/provider_types/edit/'.$updateprovidertypedata->id)}}" method="POST">
                        @csrf
                        <div class="form-body">
                           <div class="form-group">
                              <label for="name"> {{ trans('labels.name') }}</label>
                              <input type="text" id="edit_provider_type_name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$updateprovidertypedata->name}}" placeholder="{{trans('labels.enter_ptype_name')}}">
                              @error('name')<span class="text-danger" id="name_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label for="commission">{{ trans('labels.commission') }}</label>
                              <input type="text" id="edit_provider_type_commission" class="form-control @error('commission') is-invalid @enderror" name="commission" value="{{$updateprovidertypedata->commission}}" placeholder="{{trans('labels.enter_commission')}}">
                              @error('commission')<span class="text-danger" id="commission_error">{{ $message }}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label for="is_available">{{ trans('labels.status') }} </label>
                              <div class="form-group">
                                 <label class="radio-inline mr-3">
                                 <input type="radio" name="is_available" value="1" @if($updateprovidertypedata->is_available == 1) checked="true" @endif> {{ trans('labels.available') }}</label>
                              </div>
                           </div>
                           <div class="form-actions left">
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" class="btn btn-raised btn-primary" onclick="myFunction()"><i class="ft-edit"></i> {{ trans('labels.update') }} </button>
                              @else
                                 <button type="submit" id="btn_edit_provider_type" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{ trans('labels.update') }} </button>
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