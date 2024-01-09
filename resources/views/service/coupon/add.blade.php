@extends('layout.main')
@section('page_title',trans('labels.add_coupon'))
@section('content')
<section id="basic-form-layouts">
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title" id="horz-layout-colored-controls">{{trans('labels.add_coupon')}}</h4>
            </div>
            <div class="card-body">
               <div class="px-3">
                  <form class="form form-horizontal" id="add_coupon_form" action="{{URL::to('coupons/store')}}" method="POST">
                     @csrf
                     <div class="form-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="col-md-3 label-control" for="code">{{trans('labels.coupon_code')}}</label>
                                 <div class="col-md-9">
                                    <input type="text" id="add_coupon_code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code')}}" placeholder="{{trans('labels.enter_coupon')}}">
                                    @error('code')<span class="text-danger" id="code_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>


                           <div class="col-md-6">
                              <div class="form-group row">

                                 <label class="col-md-3 label-control" for="service_id"> {{trans('Coupon Type')}}</label>
                                 <div class="col-md-9 mb-3">
                                    <select id="coupon_type" name="coupon_type" class="form-control @error('coupon_type') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="coupon_type" required>
                                       <option value="" selected disabled>{{trans('labels.select')}}</option>
                                       <option value="all">All</option>
                                       <option value="service">Service</option>
                                       <option value="photographer">Photographer</option>

                                    </select>
                                    @error('coupon_type')<span class="text-danger" id="service_id_error_error">{{ $message }}</span>@enderror
                                 </div>

                                 <label class="col-md-3 label-control" for="service_id"> {{trans('labels.service')}}</label>
                                 <div class="col-md-9">
                                    <select id="add_coupon_service_id" name="service_id" class="form-control @error('service_id') is-invalid @enderror" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="service_id">
                                       <option value="" selected disabled>{{trans('labels.select')}}</option>
                                       <!--@foreach ($servicedata as $sd)-->
                                       <!--<option value="{{$sd->id}}">{{$sd->name}}</option>-->
                                       <!--@endforeach-->
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
                                    <input type="text" id="coupon_discount" class="form-control @error('discount') is-invalid @enderror" name="discount" value="{{ old('discount')}}" placeholder="{{trans('labels.enter_discount')}}">
                                    @error('discount')<span class="text-danger" id="discount_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="col-md-3 label-control" for="discount_type">{{trans('labels.discount_type')}}</label>
                                 <div class="col-md-9">
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="discount_type" id="fixed" value="1">
                                       <label class="form-check-label" for="fixed">{{trans('labels.fixed')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="discount_type" id="percentage" value="2">
                                       <label class="form-check-label" for="percentage">{{trans('labels.percentage')}}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                       @error('discount_type')<span class="text-danger text-sm" id="discount_type_error">{{ $message }}</span>@enderror
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="col-md-3 label-control" for="start_date">{{trans('labels.start_date')}}</label>
                                 <div class="col-md-9">
                                    <input type="date" id="coupon_start_date" class="form-control @error('start_date') is-invalid @enderror" min="<?= date('Y-m-d'); ?>" name="start_date" value="{{ old('start_date')}}">
                                    @error('start_date')<span class="text-danger" id="start_date_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="col-md-3 label-control" for="expire_date"> {{trans('labels.expire_date')}}</label>
                                 <div class="col-md-9">
                                    <input type="date" id="coupon_expire_date" class="form-control @error('expire_date') is-invalid @enderror" min="<?= date('Y-m-d'); ?>" name="expire_date" value="{{ old('expire_date')}}">
                                    @error('expire_date')<span class="text-danger" id="expire_date_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group row">
                                 <label class="col-md-3 label-control" for="description">{{trans('labels.description')}}</label>
                                 <div class="col-md-9">
                                    <textarea id="coupon_description" rows="3" class="form-control col-md-12 @error('description') is-invalid @enderror" name="description" placeholder="{{trans('labels.coupon_description')}}"></textarea>
                                    @error('description')<span class="text-danger" id="description_error">{{ $message }}</span>@enderror
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="form-actions left">
                        <a class="btn btn-raised btn-danger mr-1" href="{{URL::to('coupons')}}"> <i class="fa fa-arrow-left"></i> {{trans('labels.back')}} </a>
                        @if (env('Environment') == 'sendbox')
                        <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"><i class="fa fa-paper-plane"></i> {{trans('labels.add')}}</button>
                        @else
                        <button type="submit" id="btn_add_coupon" class="btn btn-raised btn-primary"> <i class="fa fa-paper-plane"></i> {{trans('labels.add')}} </button>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">


   $(document).ready(function () {
      // Function to handle checkbox changes
      $("#coupon_type").change(function () {
         var selectVal = $(this).val();
        //alert(selectVal);

         // Send AJAX request to update the checkbox state in the server
         if(selectVal !== 'all') {
             $.ajax({
                type: "POST",
                url: "{{URL::to('/coupons/getServicePhotographer')}}",
                headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { 'selectVal': selectVal },
                success: function (response) {
                   //console.log('response');
                   var option = '';
                   option += '<option value="" selected disabled>{{trans('labels.select')}}</option>';
                   if (response.data.length > 0) {
                       console.log(response.data.length);
                       option += '<option value="all">All</option>';
                        response.data.forEach(function(item) {
                            
                            option += '<option value="' + item.id + '">' + item.name + '</option>';
                        });
                    } else {
                        option += '';
                    }
                   console.log(option);
                   $('#add_coupon_service_id').html(option);
                   //location.reload();
                }
             });
         } else {
             $('#add_coupon_service_id').html('');
         }
         


      });
   });
</script>
@endsection