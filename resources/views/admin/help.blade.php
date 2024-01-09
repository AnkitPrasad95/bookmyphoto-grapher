@extends('layout.main')
@section('page_title',trans('labels.help'))
@section('content')
   <div class="row match-height">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="card-title" id="basic-layout-form-center">{{trans('labels.help')}}</h4>
            </div>
            <div class="card-body">
               <div class="card-block">
                  <table class="table table-responsive-sm">
                     <thead>
                        <tr>
                           <th>{{ trans('labels.srno') }}</th>
                           <th>{{ trans('labels.first_name') }}</th>
                           <th>{{ trans('labels.last_name') }}</th>
                           <th>{{ trans('labels.email') }}</th>
                           <th>{{ trans('labels.mobile') }}</th>
                           <th>{{ trans('labels.subject') }}</th>
                           <th>{{ trans('labels.message') }}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($helpdata) && count($helpdata) > 0)
                           @foreach($helpdata as $hdata)
                              <tr>
                                 <td>{{$hdata->id}}</td>
                                 <td>{{$hdata->fname}}</td>
                                 <td>{{$hdata->lname}}</td>
                                 <td>{{$hdata->email}}</td>
                                 <td>{{$hdata->mobile}}</td>
                                 <td>{{$hdata->subject}}</td>
                                 <td>{!! $hdata->message !!}</td>
                              </tr>
                           @endforeach
                           <tr>
                              <td colspan="7" align="right">
                                 <div class="float-right">
                                    {{ $helpdata->links() }}
                                 </div>
                              </td>
                           </tr>
                        @else
                           <tr>
                              <td colspan="7" align="center">
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