@extends('layout.main')
@section('page_title',trans('labels.privacy_policy'))
@section('content')
   <div class="row match-height">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title" id="basic-layout-form-center">{{trans('labels.privacy_policy')}}</h4>
            </div>
            <div class="card-body">
               <div class="px-3">
                  <form action="{{URL::to('/privacy-policy/update')}}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <div id="snow-container">
                        <textarea class="form-control @error('privacy_content') is-invalid @enderror" rows="10" name="privacy_content" >{{strip_tags($privacydata->privacy_content)}}</textarea>
                        @error('privacy_content')<span class="text-danger">{{ $message }}</span>@enderror
                     </div>
                     @if (env('Environment') == 'sendbox')
                        <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary mt-2"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
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