<!DOCTYPE html>
<html lang="en" class="loading">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <title>{{trans('labels.login')}}</title>
      <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/css/app.css') }}">
      <link rel="shortcut icon" type="image/png" href="{{ asset('storage/app/public/images/'.Helper::appdata()->favicon)}}">
      <link rel="stylesheet" type="text/css" href="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.css')}}">
   </head>
   <body data-col="1-column" class=" 1-column  blank-page blank-page">
      <div class="wrapper">
         <div class="main-panel">
            <div class="main-content">
               <div class="content-wrapper">
                  <section id="login">
                     <div class="container-fluid">
                        <div class="row full-height-vh">
                           <div class="col-12 d-flex align-items-center justify-content-center">
                              <div class="card gradient-indigo-purple text-center width-400">
                                 <div class="card-body">
                                    <img alt="element 06" class="mb-3 mt-3" src="{{Helper::image_path(Helper::appdata()->logo)}}" width="300">
                                    <div class="card-block">
                                         @if ($message = Session::get('AuthError'))
                                           <span class="text-center text-danger">{{ $message }}</span>
                                        @endif
                                       <form action="{{ URL::to('/home/admin-send-pass') }}" method="POST">
                                          @csrf
                                          <h2 class="white">{{trans('labels.forgot_password')}}</h2>
                                          @if ($message = Session::get('AuthError'))
                                             <span class="text-danger text-center" id="AuthError">{{ $message }}</span>
                                          @endif
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <input type="email" class="form-control" name="email" value="{{ old('email', $email) }}" id="email" placeholder="{{trans('labels.enter_email')}}" required >
                                                @error('email')<span class="text-danger text-left" id="email_error">{{ $message }}</span>@enderror
                                             </div>
                                          </div>
                                         
                                          <div class="form-group">
                                             <div class="col-md-12">
                                                <input type="submit" value="{{trans('labels.submit')}}" class="btn btn-primary btn-block"> 
                                             </div>
                                             
                                          </div>
                                          <div class="form-group">
                                            
                                              <div class="col-12">
                                                  <a href="{{URL::to('/admin')}}" class="btn btn-light btn-block">{{trans('labels.login')}} ?</a>
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
                 
               </div>
            </div>
         </div>
      </div>
   </body>
   <script src="{{ asset('storage/app/public/admin-assets/js/jquery-3.6.0.js')}}"></script>
   <script src="{{ asset('storage/app/public/admin-assets/js/toaster/toastr.min.js')}}" type="text/javascript"></script>
   <script>
      @if(Session::has('success'))
         toastr.options = {
            "closeButton" : true,
            "progressBar" : true
         },
         toastr.success("{{ session('success') }}");
      @endif
      @if(Session::has('error'))
         toastr.options ={
            "closeButton" : true,
            "progressBar" : true,
            "timeOut" : 10000
         },
         toastr.error("{{ session('error') }}");
      @endif
   </script>
</html>