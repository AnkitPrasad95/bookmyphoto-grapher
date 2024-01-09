@extends('layout.main')
@section('page_title',trans('labels.subscribers'))
@section('content')
   <div class="row match-height">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title" id="basic-layout-form-center">{{trans('labels.subscribers')}}</h4>
            </div>
            <div class="card-body">
               <div class="card-block">
                  <table class="table table-responsive-sm">
                     <thead>
                        <tr>
                           <th>{{ trans('labels.srno') }}</th>
                           <th>{{ trans('labels.email') }}</th>
                           <th>{{ trans('labels.created_at') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($subscribers) && count($subscribers) > 0)
                           @foreach($subscribers as $cd)
                              <tr>
                                 <td>{{$cd->id}}</td>
                                 <td>{{$cd->email}}</td>
                                 <td>{{$cd->created_at}}</td>
                              </tr>
                           @endforeach
                           <tr>
                              <td colspan="3" align="right">
                                 <div class="float-right">
                                    {{ $subscribers->links() }}
                                 </div>
                              </td>
                           </tr>
                        @else
                           <tr>
                              <td colspan="3" align="center">
                                 {{ trans('labels.no_data') }}
                              </td>
                           </tr>
                        @endif
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection
