@extends('front.layout.main')

@section('page_title',trans('labels.email_verification'))

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
                        <h2>{{ trans('labels.email_verification') }}</h2>
                    </div>
                </div>
                <div class="col-auto float-right ml-auto breadcrumb-menu align-self-center">
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                           <li class="breadcrumb-item">{{ trans('labels.register') }}</li>
                           <li class="breadcrumb-item active" aria-current="page">{{ trans('labels.verify_email') }}</li>
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
                  <div class="col-6">
                     <div class="contact-queries">

                        <h4 class="mb-4">{{ trans('messages.verification_code_sent') }} <br>
                           <small><strong>
                              @if (Session::has('otpemail')) 
                                 {{ $email = Session::get('otpemail') }}
                              @endif
                           </strong></small>
                        </h4>

                        <form action="{{ URL::to('home/verify/otp') }}" method="post">
                           @csrf
                           <div class="row">
                              <div class="form-group col-xl-12">
                                 <input type="hidden" value="{{$email}}" name="email">
                              </div>
                              <div class="form-group col-xl-12">
                                 <label class="mr-sm-2">{{ trans('labels.otp') }} @error('otp')<span class="text-danger">> {{ $message }}</span>@enderror</label>
                                 <input type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{old('otp')}}" placeholder="{{trans('labels.enter_otp')}}">
                              </div>
                              <div class="col-xl-12 mt-4">
                                 <div class="text-right white" id="timer"></div>
                                 <button class="btn btn-primary btn-lg pl-5 pr-5" type="submit"> <i class="fa fa-paper-plane"></i> {{ trans('labels.verify_otp') }} </button>
                              </div>
                           </div>
                        </form>

                     </div>
                  </div>
                  <div class="card-footer dn" id="resend">
                     <a class="white" href="{{route('resend-otp')}}">{{trans('labels.resend_otp')}}</a> 
                  </div>
               </div>
            </div>
         </div>
      </section>
@endsection
@section('scripts')
<script type="text/javascript">
   let timerOn = true;
      timer(120);
      function timer(remaining) {
         var m = Math.floor(remaining / 60);
         var s = remaining % 60; 
         m = m < 10 ? '0' + m : m;
         s = s < 10 ? '0' + s : s;
         document.getElementById('timer').innerHTML = m + ':' + s;
         remaining -= 1;
         if(remaining >= 0 && timerOn) {
            setTimeout(function() {
               timer(remaining);
            }, 1000);
            return;
         }
         if(!timerOn) {
            alert(322);
            return;
         }
         $('#timer').hide();
         $('#resend').show();
      }
</script>
@endsection

