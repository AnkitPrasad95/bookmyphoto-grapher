@extends('layout.main')

@section('page_title')
   {{trans('labels.home_settings')}} | {{trans('labels.home_page')}}
@endsection
   
@section('content')
   <section id="basic-form-layouts">
      <div class="row">
         <div class="col-sm-12">
            <div class="content-header">{{trans('labels.home_page')}}</div>
         </div>
      </div>
      <div class="row justify-content-md-center">
         <div class="col-md-12">
            <div class="card">
               <div class="card-body">
                  <div class="px-3">
                        <form class="form form-horizontal striped-rows form-bordered" id="edit_setting_form" action="{{URL::to('/home-settings/home/update')}}" method="POST" enctype="multipart/form-data">
                           @csrf
                           <div class="form-body">
                              <h4 class="form-section"><i class="ft-bars"></i> {{trans('labels.step_1')}}</h4>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="title1">{{trans('labels.title')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="title1" class="form-control" placeholder="{{trans('labels.enter_title')}}" value="{{$settingdata->title1}}">
                                    @error('title1')<span class="text-danger" id="title1_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="description1">{{trans('labels.description')}}</label>
                                 <div class="col-md-10">
                                    <textarea class="form-control mt-2" name="description1" placeholder="{{trans('labels.enter_description')}}">{{$settingdata->description1}}</textarea>
                                    @error('description1')<span class="text-danger" id="description1_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="icon1">{{trans('labels.icon')}}</label>
                                 <div class="col-md-10">
                                    <input type="file" id="edit_icon1" class="form-control mt-2" name="icon1" value="{{ old('icon1') }}">
                                    @error('icon1')<span class="text-danger" id="icon1_error">{{ $message }}</span><br>@enderror
                                    <img src="{{Helper::image_path($settingdata->icon1)}}" alt="{{trans('labels.icon')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <h4 class="form-section"><i class="ft-bars"></i> {{trans('labels.step_2')}}</h4>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.title')}}</label>
                                 <div class="col-md-10">
                                 <input type="text" name="title2" class="form-control" placeholder="{{trans('labels.enter_title')}}" value="{{$settingdata->title2}}">
                                    @error('title2')<span class="text-danger" id="title2_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.description')}}</label>
                                 <div class="col-md-10">
                                    <textarea class="form-control mt-2" name="description2" placeholder="{{trans('labels.enter_description')}}">{{$settingdata->description2}}</textarea>
                                    @error('description2')<span class="text-danger" id="description2_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.icon')}}</label>
                                 <div class="col-md-10">
                                    <input type="file" id="edit_icon2" class="form-control mt-2" name="icon2" value="{{ old('icon2') }}">
                                    @error('icon2')<span class="text-danger" id="icon2_error">{{ $message }}</span><br>@enderror
                                    <img src="{{Helper::image_path($settingdata->icon2)}}" alt="{{trans('labels.icon')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <h4 class="form-section"><i class="ft-bars"></i> {{trans('labels.step_3')}}</h4>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.title')}}</label>
                                 <div class="col-md-10">
                                    <input type="text" name="title3" class="form-control" placeholder="{{trans('labels.enter_title')}}" value="{{$settingdata->title3}}">
                                    @error('title3')<span class="text-danger" id="title3_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.description')}}</label>
                                 <div class="col-md-10">
                                 <textarea class="form-control mt-2" name="description3" placeholder="{{trans('labels.enter_description')}}">{{$settingdata->description3}}</textarea>
                                    @error('description3')<span class="text-danger" id="description3_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                              <div class="form-group row last">
                                 <label class="col-md-2 label-control" for="meta_title">{{trans('labels.icon')}}</label>
                                 <div class="col-md-10">
                                    <input type="file" id="edit_icon3" class="form-control mt-2" name="icon3" value="{{ old('icon3') }}">
                                    @error('icon3')<span class="text-danger" id="icon3_error">{{ $message }}</span><br>@enderror
                                    <img src="{{Helper::image_path($settingdata->icon3)}}" alt="{{trans('labels.icon')}}" class="rounded media-object round-media setting-profile mt-2">
                                 </div>
                              </div>
                              <div class="form-actions left">
                                 @if (env('Environment') == 'sendbox')
                                    <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                                 @else
                                    <button type="submit" id="btn_setting" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                                 @endif
                              </div>   
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection