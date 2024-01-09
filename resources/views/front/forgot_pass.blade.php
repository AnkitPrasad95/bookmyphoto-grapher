@extends('front.layout.main')

@section('content')
<style>
   .contact-queries{
      background: #fff;
      border:1px solid #ccc;
      border-radius: 10px;
      padding: 20px !important;
   }
</style>
      <div class="breadcrumb-bar">
        <div class="container-fluid">
            <div class="row">
               <div class="col">
                  <div class="breadcrumb-title">
                     <h2>{{trans('labels.password')}}</h2>
                  </div>
               </div>
               <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                  <nav aria-label="breadcrumb" class="page-breadcrumb">
                     <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">{{trans('labels.home')}}</a></li>
                        <li class="breadcrumb-item">{{trans('labels.password')}}</li>
                     </ol>
                  </nav>
               </div>
            </div>
         </div>
      </div>

      <section class="contact-us">
         <div class="content bg-sec-img">
            <div class="container-fluid">
               <div class="row justify-content-md-center">
                  <div class="col-lg-6 col-md-12 col-sm-12">
                     <div class="contact-queries">
                        <div class="login-header">
                           <h4 class="mb-4">{{trans('labels.enter_email_to_get_password')}}</h4>
                        </div>
                        
                        @if ($message = Session::get('AuthError'))
                           <span class="text-center text-danger">{{ $message }}</span>
                        @endif

                        <form action="{{ URL::to('/home/send-pass') }}" method="POST">
                           @csrf
                           <div class="form-group form-focus">
                              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{trans('labels.enter_email')}}">
                              @error('email')<span class="text-danger">{{ $message }}</span>@enderror
                           </div>
                           <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ trans('labels.send') }}</button>
                        </form>

                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
@endsection
