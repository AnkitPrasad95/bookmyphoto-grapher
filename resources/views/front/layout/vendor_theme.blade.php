
@extends('front.layout.main')

@section('content')
<style>
   #UserSidebar{
    position: -webkit-sticky;
    position: sticky;
    top: 160px;
}

#change-password-2 .tab-content {
   padding: 20px !important;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
}

#profile-2 .tab-content {
   padding: 20px !important;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 10px;
}
</style>

      <div class="content bg-sec-img">
         <div class="container-fluid">
            <div class="row">

               @include('front.layout.vendor_menu')

               @yield('front_content')

            </div>
         </div>
      </div>
         
@endsection