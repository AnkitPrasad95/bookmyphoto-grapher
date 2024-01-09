
@extends('layout.main')
@section('page_title',trans('labels.categories'))
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header"> 
                  <h4 class="card-title">{{ trans('labels.categories') }}
                     @if(Auth::user()->type == 1)
                        <a href="{{ URL::to('/categories/add')}}" class="btn btn-primary btn-sm float-right">{{ trans("labels.add_new") }}</a>
                     @endif
                  </h4>
               </div>
               <div class="card-body">
                  <div class="card-block">
                     <div class="input-group col-4 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="{{trans('labels.search_category')}}" aria-label="Small" aria-describedby="inputGroup-sizing-sm"/>
                        <div class="input-group-prepend">
                           <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-search"></i></span>
                        </div>
                     </div>
                     <input type="hidden" name="url" id="categories_url" url="{{route('categories')}}">
                     <div class="category_table">
                        @include('category.category_table')
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
<script src="{{ asset('resources/views/category/category.js') }}" type="text/javascript"></script>
@endsection