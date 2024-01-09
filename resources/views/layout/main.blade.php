<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>{{Helper::appdata()->website_title}} | @yield('page_title')</title>
   <link rel="shortcut icon" type="image/png" href="{{Helper::image_path(Helper::appdata()->favicon)}}">

   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/fonts/feather/style.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/fonts/font-awesome/css/font-awesome.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/fonts/simple-line-icons/style.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/vendors/css/tables/datatable/datatables.min.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/plugins/sweetalert/css/sweetalert.css') }}">
   <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
   <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,700,900|Montserrat:300,400,500,600,700,800,900" rel="stylesheet">

   <meta name="csrf-token" content="{{ csrf_token() }}" />
   @yield('styles')
</head>
<body data-col="2-columns" class=" 2-columns ">

      <div class="wrapper">

         @include('layout.main_menu')
         @include('layout.header_navbar')

         <div class="main-panel">
            <div class="main-content">
               <div class="content-wrapper">
                  
                  <div class="row">
                     <div class="col-md-12">
                        <div class="alert alert-danger @if(Helper::check_bank() > 0) dn @endif">
                           <div class="fi_bt">
                              <a href="{{URL::to('/profile-settings')}}">{{trans('labels.click_to_complete_profile')}}</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  
                  @yield('content')
               
               </div>
            </div>
         </div>

            <!-- Edit Profile Modal -->
            <div class="modal fade text-left" id="bootstrap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel35"> {{trans('labels.update_profile')}} </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                     </div>
                     <form class="form" id="myProfileEditForm" action="{{ URL::to('/profile/edit/'.Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                           <div class="form-group col-md-12">
                              <label for="name"> {{trans('labels.email')}} </label>
                              <input type="email" id="email" class="form-control" name="email" value="{{Auth::user()->email}}" @if(Auth::user()->type == 2) disabled="disabled" @endif>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="name"> {{trans('labels.name')}} </label>
                              <input type="text" id="name" class="form-control" name="name" value="{{Auth::user()->name}}" >
                           </div>
                           <div class="form-group col-md-12">
                              <div class="row">
                                 <div class="col-md-3">
                                    <label>{{trans('labels.profile')}}</label><br>
                                    <img src="{{Helper::image_path(Auth::user()->image)}}" alt="{{trans('labels.image')}}" class="rounded edit-image">
                                 </div>
                                 <div class="col-md-9">
                                    <label for="profileimage">{{trans('labels.image')}}</label><br>
                                    <input type="file" class="form-control" id="profileimage" name="image" accept="image/*">
                                 </div>
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                              @else
                                 <button type="submit" id="btn_update_profile" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                              @endif
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <!-- Change Password Modal -->
            <div class="modal fade text-left change_password_modal" id="change_password_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel35" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h3 class="modal-title" id="myModalLabel35"> {{trans('labels.change_password')}} </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form class="form" id="change_password_form" action="{{ URL::to('/profile/edit/password/'.Auth::user()->id)}}" method="POST">
                        @csrf
                        <div class="form-body">
                           <div class="form-group col-md-12">
                              <label for="old_password"> {{trans('labels.old_password')}} </label>
                              <div class="controls">
                                 <input type="password" name="old_password" id="old_password" class="form-control" placeholder="{{trans('labels.enter_old_pass')}}">
                                 @error('old_password') <span class="text-danger">{{$message}}</span> @enderror
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="new_password"> {{trans('labels.new_password')}} </label>
                              <div class="controls">
                                 <input type="password" name="new_password" id="new_password" class="form-control" placeholder="{{trans('labels.enter_new_pass')}}">
                                 @error('new_password') <span class="text-danger">{{$message}}</span> @enderror
                              </div>
                           </div>
                           <div class="form-group col-md-12">
                              <label for="c_new_password"> {{trans('labels.confirm_password')}} </label>
                              <div class="controls">
                                 <input type="password" name="c_new_password" id="c_new_password" class="form-control" placeholder="{{trans('labels.enter_confirm_pass')}}">
                                 @error('c_new_password') <span class="text-danger">{{$message}}</span> @enderror
                              </div>
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                              @if (env('Environment') == 'sendbox')
                                 <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.change')}} </button>
                              @else
                                 <input type="submit" id="btn_update_password" class="btn btn-raised btn-primary" value="{{trans('labels.change')}}">
                              @endif
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>

            <!-- Edit Service Gallery Image -->
            <div class="modal fade" id="edit_service_gallery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <form method="post" name="edit_gallery_form" class="form" id="edit_gallery_form" enctype="multipart/form-data">
                     @csrf
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.images') }}</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <span id="emsg"></span>
                        <span class="text-danger" id="gallery_error"></span>
                        <div class="modal-body">
                           <input type="hidden" id="gimage_id" name="gimage_id">
                           <input type="hidden" id="gallery_edit_url" name="gimage_id" url="{{ URL::to('gallery/edit') }}">
                           <div class="form-group">
                              <label>{{ trans('labels.image') }}</label>
                              <!--<input type="file" class="form-control" name="image" id="image" accept=".png,.jpg,.jpeg">-->
                              <input type="file" class="form-control" multiple name="image[]" id="image" accept=".png,.jpg,.jpeg">
                              <span class="text-danger" id="gallery_image_error"></span>
                           </div>
                           <div class="form-group">
                              <label>{{ trans('labels.image') }}</label>
                              <img id="oldGalleryImg" alt="{{trans('labels.image')}}" class="rounded edit-image">
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btna-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> <i class="ft-edit"></i> {{trans('labels.update')}} </button>
                           @else
                              <button type="submit" class="btn btn-primary"><i class="ft-edit"></i> {{ trans('labels.update') }}</button>
                           @endif
                        </div>
                     </div>
                  </form>
               </div>
            </div>

            <!-- Add Gallery Image -->
            <div class="modal fade" id="add_gallery_image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <form method="post" name="add_gallery" class="form" id="add_gallery" enctype="multipart/form-data">
                     @csrf
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.image') }}</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <span class="text-danger text-center" id="other_error"></span>
                        <div class="modal-body">
                           <input type="hidden" name="service_id" id="gallery_service_id">
                           <input type="hidden" name="add_gallery_url" id="add_gallery_url" url="{{ URL::to('gallery/add') }}">
                           <div class="form-group">
                              <label>{{ trans('labels.image') }}</label>
                              <input type="file" class="form-control" multiple name="image[]" accept=".png,.jpg,.jpeg">
                              <span class="text-danger" id="add_gallery_image_error"></span>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btna-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary">{{trans('labels.add')}} </button>
                           @else
                              <button type="submit" class="btn btn-primary">{{ trans('labels.add') }}</button>
                           @endif
                        </div>
                     </div>
                  </form>
               </div>
            </div>

            <!-- Select handyman -->
            <div class="modal fade" id="select_handyman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <form action="{{URl::to('/bookings/assign_handyman')}}" method="post" name="select_handyman" class="form" id="select_handyman_form" enctype="multipart/form-data">
                     @csrf
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabeledit">{{ trans('labels.handyman') }}</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                              <div class="col-md-12">
                                 <input type="hidden" id="booking_id" name="id">
                                 <label>{{ trans('labels.select_handyman') }}</label>
                                 <select id="select_hanyman_option" name="handyman_id" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="handyman_id">
                                    <option value="" selected disabled>{{ trans('labels.select') }}</option>
                                    @if(Auth::user()->type == 2)
                                    @isset($ahandymandata)
                                       @foreach ($ahandymandata as $hdata)
                                          <option value="{{$hdata->id}}">{{$hdata->name}}</option>
                                       @endforeach
                                    @endisset
                                    @endif
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btna-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary">{{trans('labels.assign')}} </button>
                           @else
                              <button type="submit" class="btn btn-raised btn-primary">{{ trans('labels.assign') }}</button>
                           @endif
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            
            <!--  cancel_reason -->
            <div class="modal fade" id="cancel_reason" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
               <div class="modal-dialog" role="document">
                 
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabeledit">Cancel Reason</h5>
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                              <div class="col-md-12">
                                 <input type="hidden" id="booking_id" name="id">
                                 <label>{{trans('labels.message')}}</label>
                                    <div class="form-group" >
                                       <textarea cols="5" rows="5" class="form-control" id="message"></textarea>
                                    </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btna-secondary" data-dismiss="modal">{{ trans('labels.close') }}</button>
                           <button type="button" onclick="cancelbookingmain('4','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/cancel') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')" class="btn btn-raised btn-primary">{{ trans('labels.submit') }}</button>
                        </div>
                     </div>
                 
               </div>
            </div>


            <!-- payout modal -->
            <div class="modal fade text-left" id="payout_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalScrollableTitle">{{trans('labels.payout_request')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form action="{{URL::to('/payout/update')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                           <h4 class="form-section"><i class="fa fa-university"></i> {{trans('labels.bank_info')}}</h4>
                           <div class="col-12">
                              <div class="row">
                                 <div class="col-md-6 col-lg-4">
                                    <label>{{trans('labels.bank_name')}}</label>
                                    <div class="form-group" >
                                       <input type="text" class="form-control" id="bank_name" disabled>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-lg-4">
                                    <label>{{trans('labels.account_holder')}}</label>
                                    <div class="form-group">
                                       <input type="text" class="form-control" id="account_holder" disabled>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-lg-4">
                                    <label>{{trans('labels.account_type')}}</label>
                                    <div class="form-group">
                                       <input type="text" class="form-control" id="account_type" disabled>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-lg-4">
                                    <label>{{trans('labels.account_number')}}</label>
                                    <div class="form-group">
                                       <input type="text" class="form-control" id="account_number" disabled>
                                    </div>
                                 </div>
                                 <div class="col-md-6 col-lg-4">
                                    <label>{{trans('labels.routing_number')}}</label>
                                    <div class="form-group">
                                       <input type="text" class="form-control" id="routing_number" disabled>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <h4 class="form-section"><i class="fa fa-user"></i> {{trans('labels.basic_info')}}</h4>
                           <label>{{trans('labels.request_id')}}</label>
                           <div class="form-group">
                              <input type="text" class="form-control" name="request_id" id="request_id" readonly>
                              @error('request_id')<span class="text-danger">{{$message}}</span>@enderror
                           </div>
                           <label>{{trans('labels.provider_name')}}</label>
                           <div class="form-group">
                              <input type="text" class="form-control" name="provider_name" id="provider_name" disabled>
                              <input type="hidden" class="form-control" name="provider_id" id="provider_id" disabled>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-6 col-lg-4">
                                 <label>{{trans('labels.commission')}} </label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="commission" id="commission" disabled>
                                 </div>
                              </div>
                              <div class="col-md-6 col-lg-4">
                                 <label>{{trans('labels.commission_amt')}}</label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="commission_amt" id="commission_amt" disabled>
                                 </div>
                              </div>
                              <div class="col-md-6 col-lg-4">
                                 <label>{{trans('labels.payable_amt')}}</label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="payable_amt" id="payable_amt" disabled>
                                 </div>
                              </div>
                           </div>
                           
                           <label>{{trans('labels.payment_methods')}}</label>
                           <div class="form-group">
                              <select class="form-control" name="payment_method">
                                 <option value="" selected disabled>{{trans('labels.select')}}</option>
                                 <option value="cash">{{trans('labels.cash')}}</option>
                                 <option value="bank">{{trans('labels.bank')}}</option>
                              </select>
                              @error('payment_method')<span class="text-danger">{{$message}}</span>@enderror
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> {{trans('labels.pay')}} </button>
                           @else
                              <input type="submit" class="btn btn-raised btn-primary" value="{{trans('labels.pay')}}">
                           @endif
                        </div>
                     </form>
                     
                  </div>
               </div>
            </div>
            
             <!-- payout booking modal -->
            <div class="modal fade text-left" id="booking_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalScrollableTitle">Pay To Admin</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form action="{{URL::to('/payout/update_cod')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" class="form-control" name="request_balance" id="request_balance">
                           <h4 class="form-section"><i class="fa fa-user"></i> {{trans('labels.basic_info')}}</h4>
                           <label>{{trans('labels.request_id')}}</label>
                           <div class="form-group">
                              <input type="text" class="form-control" name="request1_id" id="request1_id" readonly>
                              @error('request_id')<span class="text-danger">{{$message}}</span>@enderror
                           </div>
                           <label>{{trans('labels.provider_name')}}</label>
                           <div class="form-group">
                              <input type="text" class="form-control" name="provider1_name" id="provider1_name" disabled>
                              <input type="hidden" class="form-control" name="provider1_id" id="provider1_id" disabled>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-6 col-lg-4">
                                 <label>{{trans('labels.payable_amt')}}</label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="request1_balance" id="request1_balance" disabled>
                                 </div>
                              </div>
                           </div>
                           
                           <label>{{trans('labels.payment_methods')}}</label>
                           <div class="form-group">
                              <select class="form-control" name="payment1_method">
                                 <option value="" selected disabled>{{trans('labels.select')}}</option>
                                 <option value="cash">{{trans('labels.cash')}}</option>
                                 <option value="bank">{{trans('labels.bank')}}</option>
                              </select>
                              @error('payment_method')<span class="text-danger">{{$message}}</span>@enderror
                           </div>
                           <div class="form-group">
                              <label>{{ trans('labels.image') }}</label>
                              <input type="file" class="form-control" name="image" id="image" accept=".png,.jpg,.jpeg">
                              <span class="text-danger" id="gallery_image_error"></span>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> {{trans('labels.pay')}} </button>
                           @else
                              <input type="submit" class="btn btn-raised btn-primary" value="{{trans('labels.pay')}}">
                           @endif
                        </div>
                     </form>
                     
                  </div>
               </div>
            </div>
 
            <!-- admin cod payout modal -->
            <div class="modal fade text-left" id="admin_cod_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalScrollableTitle">COD Request</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                     </div>
                     <form action="{{URL::to('/payout/update_admin_cod')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                           
                           <h4 class="form-section"><i class="fa fa-user"></i> {{trans('labels.basic_info')}}</h4>
                           <label>{{trans('labels.request_id')}}</label>
                           <div class="form-group">
                              <input type="text" class="form-control" name="request_cod_id" id="request_cod_id" readonly>
                              @error('request_cod_id')<span class="text-danger">{{$message}}</span>@enderror
                           </div>
                           <label>{{trans('labels.provider_name')}}</label>
                           <div class="form-group">
                              <input type="text" class="form-control" name="provider_cod_name" id="provider_cod_name" disabled>
                              <input type="hidden" class="form-control" name="provider_cod_id" id="provider_cod_id" disabled>
                           </div>
                           
                           <div class="row">
                              <div class="col-md-6 col-lg-4">
                                 <label>{{trans('labels.payable_amt')}}</label>
                                 <div class="form-group">
                                    <input type="text" class="form-control" name="request_cod_balance" id="request_cod_balance" disabled>
                                 </div>
                              </div>
                           </div>
                           
                           <label>Payment Action</label>
                           <div class="form-group">
                              <select class="form-control" name="payment_cod_method">
                                 <option value="" selected disabled>{{trans('labels.select')}}</option>
                                 <option value="1">Approved</option>
                                 <option value="0">Reject</option>
                              </select>
                              @error('payment_method')<span class="text-danger">{{$message}}</span>@enderror
                           </div>
                          
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{trans('labels.close')}}</button>
                           @if (env('Environment') == 'sendbox')
                              <button type="button" onclick="myFunction()" class="btn btn-raised btn-primary"> Submit </button>
                           @else
                              <input type="submit" class="btn btn-raised btn-primary" value="{{trans('labels.pay')}}">
                           @endif
                        </div>
                     </form>
                     
                  </div>
               </div>
            </div>


      </div>

<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('storage/app/public/admin-assets/vendors/js/jquery.matchHeight-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/screenfull.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/pace/pace.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('storage/app/public/admin-assets/js/notification-sidebar.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/customizer.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/plugins/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/js/jquery.validate.js')}}" type="text/javascript"></script>
<script src="{{ asset('storage/app/public/admin-assets/vendors/js/datatable/dataTables.min.js')}}" type="text/javascript"></script>

<script src="{{ asset('storage/app/public/admin-assets/js/data-tables/datatable-basic.js') }}" type="text/javascript"></script>

<script src="{{asset('storage/app/public/admin-assets/js/app-sidebar.js')}}" type="text/javascript"></script>

<script>
   @if(Session::has('success'))
      toastr.options = {
         "closeButton" : true,
         "progressBar" : true
      }
      toastr.success("{{ session('success') }}");
   @endif
   @if(Session::has('error'))
      toastr.options ={
         "closeButton" : true,
         "progressBar" : true
      }
      toastr.error("{{ session('error') }}");
   @endif

   function clearnotification(user_id)
   {
      "use strict";
      var CSRF_TOKEN = $('input[name="_token"]').val();
      $.ajax({
         headers: {'X-CSRF-Token': CSRF_TOKEN },
         url:"{{URL::to('/clearnotification') }}",
         data:{user_id:user_id},
         dataType:"json",
         success:function(response){
            window.location.href = "{{URL::to('/notifications')}}";
         }
      });
   }
   function clearhelp()
   {
      "use strict";
      var CSRF_TOKEN = $('input[name="_token"]').val();
      $.ajax({
         headers: {'X-CSRF-Token': CSRF_TOKEN },
         url:"{{URL::to('/clearhelp') }}",
         dataType:"json",
         success:function(response){
            window.location.href = "{{ URL::to('/help')}}";
         },
         error:function(data){
            console.log(data);
         }
      });
   }
   
   $('img[data-enlargeable]').addClass('img-enlargeable').click(function() {
      var src = $(this).attr('src');
      var modal;
      function removeModal() {
         modal.remove();
         $('body').off('keyup.modal-close');
      }
      modal = $('<div>').css({
         background: 'RGBA(0,0,0,.6) url(' + src + ') no-repeat center',
         backgroundSize: 'contain',
         width: '100%',height: '100%',
         position: 'fixed',zIndex: '10000',
         top: '0',left: '0',
         cursor: 'zoom-out'
      }).click(function() {
            removeModal();
         }).appendTo('body');
      $('body').on('keyup.modal-close', function(e) {
         if (e.key === 'Escape') {
            removeModal();
         }
      });
   });

   function myFunction() {
      toastr.options ={
         "closeButton" : true,
         "progressBar" : true,
      }
      toastr.error("Error!","Permission disabled for demo mode");
   }
</script>

<script>
$(document).ready(function() {
    var SITEURL = window.location.origin;
    var audio = new Audio(SITEURL + '/storage/app/public/audio/notify_sound.mp3');
    var audio2 = new Audio(SITEURL + '/storage/app/public/audio/police_siren.mp3');
   
    function playAudio(audioElement) {
        audioElement.play()
            .then(function() {
                // Audio has started playing
            })
            .catch(function(error) {
                console.error('Audio play error:', error);
            });
    }
   
    function loadNotification() {
        var CSRF_TOKEN = $('input[name="_token"]').val();
        $.ajax({
            headers: { 'X-CSRF-Token': CSRF_TOKEN },
            url: "{{ URL::to('/notifications_bell') }}",
            dataType: "json",
            success: function(response) {
                console.log(response.notifyval);
                $('.notification_count').html('');
                if (response.notifyval > 0) {
                    $('.notification_count').append(response.notifyval);
                    playAudio(audio);
                    
                    // Get the element by its ID
                    var element = document.getElementById("myElement");
                    
                    // Add a class to the element
                    element.classList.add("badge-danger");

                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    // Attach a click event to a button or element to initiate audio playback
    $('#playAudioButton').click(function() {
        playAudio(audio);
    });

    loadNotification(); // This will run on page load
    setInterval(loadNotification, 30000); // This will run every 30 seconds
});


</script> 

@yield('scripts')


   </body>
</html>