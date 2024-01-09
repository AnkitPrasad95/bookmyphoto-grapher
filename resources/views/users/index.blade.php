@extends('layout.main')
@section('page_title',trans('labels.users'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">{{ trans('labels.users') }}
                  </h4>
                  
               </div>
               <div class="card-body">
                  <div class="card-block">
                     <div class="input-group col-4 float-right">
                        <input type="text" name="search_users" id="search_users" class="form-control" placeholder="{{trans('labels.search_users')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm"/>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                        </div>
                     </div>
                     <input type="hidden" name="url" id="users_url" url="{{route('users')}}">
                     <div class="users_table">
                        @include('users.users_table')
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
   <script src="{{ asset('resources/views/users/users.js') }}" type="text/javascript"></script>
@endsection