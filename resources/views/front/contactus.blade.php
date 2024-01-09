@extends('front.layout.main')
@section('page_title',trans('labels.contact_us'))
@section('content')
<style>
   .contact-queries{
      background: #fff;
      border:1px solid #ccc;
      border-radius: 10px;
      padding: 20px;
   }
</style>
   <div class="breadcrumb-bar">
      <div class="container-fluid">
         <div class="row">
            <div class="col">
               <div class="breadcrumb-title">
                  <h2>{{trans('labels.contact_us')}}</h2>
               </div>
            </div>
            <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
               <nav aria-label="breadcrumb" class="page-breadcrumb">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{URL::to('/')}}">{{trans('labels.home')}}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{trans('labels.contact_us')}}</li>
                  </ol>
               </nav>
            </div>
         </div>
      </div>
   </div>
   <section class="contact-us bg-sec-img">
      <div class="content">
         <div class="container-fluid">
               <div class="row match-height">
                  <div class="col-md-8">
                     <div class="contact-queries">
                        <h4 class="mb-4">{{trans('labels.drop_queries')}}</h4>
                        <form action="{{URL::to('home/add-inquiry')}}" method="post">
                           @csrf
                           <div class="row">
                              <div class="form-group col-xl-6">
                                 <label class="mr-sm-2">{{trans('labels.first_name')}}*</label>
                                 <input class="form-control @error('fname') is-invalid @enderror" type="text" name="fname" placeholder="{{trans('labels.enter_first_name')}}">
                                 @error('fname')<span class="text-danger ">{{ $message }}</span>@enderror
                              </div>
                              <div class="form-group col-xl-6">
                                 <label class="mr-sm-2">{{trans('labels.last_name')}}*</label>
                                 <input class="form-control @error('lname') is-invalid @enderror" type="text" name="lname" placeholder="{{trans('labels.enter_last_name')}}">
                                 @error('lname')<span class="text-danger">{{ $message }}</span>@enderror
                              </div>
                              <div class="form-group col-xl-6">
                                 <label class="mr-sm-2">{{trans('labels.email')}}*</label>
                                 <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="{{trans('labels.enter_email')}}">
                                 @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                              </div>
                              <div class="form-group col-xl-6">
                                 <label class="mr-sm-2">{{trans('labels.mobile')}}*</label>
                                 <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" placeholder="{{trans('labels.enter_mobile')}}">
                                 @error('mobile')<span class="text-danger">{{ $message }}</span>@enderror
                              </div>
                              <div class="form-group col-xl-12">
                                 <label class="mr-sm-2">{{trans('labels.message')}}*</label>
                                 <textarea class="form-control @error('message') is-invalid @enderror" rows="3" name="message" placeholder="{{trans('labels.drop_inquiry_here')}}"></textarea>
                                 @error('message')<span class="text-danger">{{ $message }}</span>@enderror
                              </div>
                              @isset($_COOKIE["city_name"])
                              <div class="col-xl-12 mt-4">
                                 <button class="btn btn-primary btn-lg pl-5 pr-5" type="submit"> <i class="fa fa-paper-plane"></i> {{trans('labels.send')}}</button>
                              </div>
                              @endisset
                           </div>
                        </form>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="contact-details">
                        <div class="contact-info">
                           <i class="fas fa-map-marker-alt"></i>
                           <div class="contact-data">
                              <p>{{strip_tags(Helper::appdata()->address)}}</p>
                           </div>
                        </div><hr>
                        <div class="contact-info">
                           <i class="fas fa-phone-alt"></i>
                           <div class="contact-data">
                              <p>{{Helper::appdata()->contact}}</p>
                           </div>
                        </div><hr>
                        <div class="contact-info">
                           <i class="far fa-envelope"></i>
                           <div class="contact-data">
                              <p>{{Helper::appdata()->email}}</p>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
         </div>
      </div>
   </section>
@endsection
