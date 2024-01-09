@extends('layout.main')
@section('page_title',trans('labels.edit_coupon'))

@section('content')
	<section id="basic-form-layouts">
		<div class="row">
			<div class="col-md-12">
	        	<div class="card">
	            <div class="card-header">
						<h4 class="card-title" id="horz-layout-colored-controls">{{trans('labels.edit_coupon')}}</h4>
	            </div>
	            <?php 
                // echo "</pre>";
                // print_r($coupondata->toArray());
                // print_r($servicedata->toArray());
                // echo "</pre>";
                
                ?>
	            <div class="card-body">
	               <div class="px-3">
					    	<form class="form form-horizontal" id="edit_coupon_form" action="{{URL::to('coupons/edit/'.$coupondata->id)}}" method="POST">
								@csrf
	                    	<div class="form-body">
	                    		<div class="row">
                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <label class="col-md-3 label-control" for="code">{{trans('labels.coupon_code')}}</label>
                                    <div class="col-md-9">
                                       <input type="text" id="edit_coupon_code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{$coupondata->code}}" Placeholder="{{trans('labels.enter_coupon')}}" readonly>
                                       @error('code')<span class="text-danger" id="code_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group row">
                                     <label class="col-md-3 label-control" for="service_id"> {{trans('Coupon Type')}}</label>
                                     <div class="col-md-9">
                                        <select id="coupon_type" name="coupon_type" class="form-control @error('coupon_type') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="coupon_type" disabled>
                                           <option value="" selected disabled>{{trans('labels.select')}}</option>
                                           <option @if($coupondata->type == 'all') {{ 'selected' }} @endif value="all">All</option>    
                                           <option @if($coupondata->type == 'service') {{ 'selected' }} @endif value="service">Service</option>
                                           <option @if($coupondata->type == 'photographer') {{ 'selected' }} @endif value="photographer">Photographer</option>
    
                                        </select>
                                        @error('coupon_type')<span class="text-danger" id="service_id_error_error">{{ $message }}</span>@enderror
                                     </div>
                                    <label class="col-md-3 label-control" for="service_id"> {{trans('labels.service')}}</label>
                                       <div class="col-md-9">
                                       <select id="edit_coupon_service_id" name="service_id" class="form-control @error('service_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="service_id" data-show-subtext="true" data-live-search="true" disabled>
                                        
                                         
                                         @if($coupondata->type == 'service' && $coupondata->service_id > 0)
                                            <option value="all">All</option>
                                              @foreach ($servicedata as $sdata)
                                                 <option @if($coupondata->service_id == $sdata->id) selected @endif value="{{$sdata->id}}">{{$sdata->name}}</option>
                                              @endforeach
                                         @endif
                                         
                                         @if($coupondata->type == 'service' && $coupondata->service_id == 0)
                                             <option value="all" selected>All</option>
                                              @foreach ($servicedata as $sdata)
                                                 <option value="{{$sdata->id}}">{{$sdata->name}}</option>
                                              @endforeach
                                         @endif
                                         
                                         
                                         @if($coupondata->type == 'photographer' && $coupondata->photographer_id > 0)
                                            <option value="all">All</option>
                                            
                                              @foreach ($servicedata as $sdata)
                                                 <option @if($coupondata->photographer_id == $sdata->id) selected @endif value="{{$sdata->id}}">{{$sdata->name}}</option>
                                              @endforeach
                                         @endif
                                         
                                         @if($coupondata->type == 'photographer' && $coupondata->photographer_id == 0)
                                             <option value="all" selected>All</option>
                                              @foreach ($servicedata as $sdata)
                                                 <option value="{{$sdata->id}}">{{$sdata->name}}</option>
                                              @endforeach
                                         @endif
                                         
                                         
                                         
                                          
                                       </select>
                                       @error('service_id')<span class="text-danger" id="service_id_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                           </div>
									<div class="row">
                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <label class="col-md-3 label-control" for="discount">{{trans('labels.discount')}}</label>
                                    <div class="col-md-9 ">
                                       <input type="text" id="coupon_discount" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{$coupondata->discount}}" Placeholder="{{trans('labels.enter_discount')}}" readonly>
                                       @error('discount')<span class="text-danger" id="discount_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <label class="col-md-3 label-control" for="discount_type">{{trans('labels.discount_type')}}</label>
                                    <div class="col-md-9"> 
                                       <div class="form-check form-check-inline">
                                          <input disabled class="form-check-input" type="radio" name="discount_type" id="fixed" value="1" @if($coupondata->discount_type == 1) checked="checked" @endif>
                                          <label class="form-check-label" for="fixed">{{trans('labels.fixed')}}</label>
                                       </div>
                                       <div class="form-check form-check-inline">
                                          <input disabled class="form-check-input" type="radio" name="discount_type" id="percentage" value="2" @if($coupondata->discount_type == 2) checked="checked" @endif>
                                          <label class="form-check-label" for="percentage">{{trans('labels.percentage')}}</label>
                                       </div>                                       
                                       @error('discount_type')<span class="text-danger" id="discount_type_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <label class="col-md-3 label-control" for="start_date">{{trans('labels.start_date')}}</label>
                                    <div class="col-md-9">
                                       <input type="date" id="coupon_start_date" class="form-control @error('start_date') is-invalid @enderror" min="<?=date('Y-m-d');?>" name="start_date" value="{{$coupondata->start_date}}">
                                       @error('start_date')<span class="text-danger" id="start_date_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group row">
                                    <label class="col-md-3 label-control" for="expire_date"> {{trans('labels.expire_date')}}</label>
                                    <div class="col-md-9">
                                       <input type="date" id="coupon_expire_date" class="form-control @error('expire_date') is-invalid @enderror"  min="<?=date('Y-m-d');?>" name="expire_date" value="{{ $coupondata->expire_date}}">
                                       @error('expire_date')<span class="text-danger" id="expire_date_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                           </div>
									<div class="row">
                              <div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-3 label-control" for="description">{{trans('labels.description')}} </label>
												<div class="col-md-9">
													<textarea id="coupon_description" rows="3" class="form-control col-md-12 @error('description') is-invalid @enderror" name="description"  placeholder="{{trans('labels.coupon_description')}}">{{strip_tags($coupondata->description)}}</textarea>
													@error('description')<span class="text-danger" id="description_error">{{ $message }}</span>@enderror
												</div>
											</div>
										</div>
                              <div class="col-md-6">
											<div class="form-group row">
												<label class="col-md-3 label-control" for="description">{{trans('labels.status')}}</label>
                                       <div class="form-check form-switch">
                                          <input class="form-check-input " type="checkbox" id="is_available" name="is_available" value="is_available" @if($coupondata->is_available == 1) checked="checked" @endif>
                                          <label class="form-check-label " for="is_available">{{trans('labels.active')}}</label>
                                       </div>
													@error('is_available')<span class="text-danger" id="is_available-error">{{ $message }}</span>@enderror
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions left">
									<a class="btn btn-raised btn-danger mr-1" href="{{URL::to('coupons')}}"> <i class="fa fa-arrow-left"></i> {{trans('labels.back')}} </a>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"><i class="ft-edit"></i> {{trans('labels.update')}}</button>
                           @else
									   <button type="submit" id="btn_edit_coupon" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
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
  <script src="{{ asset('resources/views/service/coupon/coupon.js') }}" type="text/javascript"></script>
@endsection	