
@extends('layout.main')
@section('page_title',trans('labels.master_services'))
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@section('content')
   <section id="contenxtual">
      <div class="row">
         <div class="col-sm-12">
            <div class="card">
               <div class="card-header"> 
                  <h4 class="card-title">{{ trans('labels.master_services') }}
                     @if(Auth::user()->type == 1)
                        <a href="{{ URL::to('/master-services/add')}}" class="btn btn-primary btn-sm float-right">{{ trans("labels.add_new") }}</a>
                     @endif
                  </h4>
               </div>
               <div class="card-body">
                  <table id="masterServiceTable" class="display">
                   <!-- Table header and body -->
                   <thead>
                      <tr>
                         <th>{{trans("labels.srno")}}</th>
                         <th>{{ trans("labels.image") }}</th>
                         <th>{{ trans("labels.name") }}</th>
                         <th>{{ trans("labels.category_name") }}</th>
                
                         <th>{{ trans("labels.action") }}</th>
                      </tr>
                   </thead>
                   <tbody>
                      @if(!empty($masterservicedata) && count($masterservicedata) > 0)
                      <?php $i = 1; ?>
                      @foreach($masterservicedata as $cdata)
                      <tr>
                         <td><?= $i++; ?></td>
                         <td><img src="{{Helper::image_path($cdata->image)}}" alt="{{trans('labels.image')}}" class="rounded table-image"></td>
                         <td>{{$cdata->name}}</td>
                         <td>{{$cdata->category_name}}</td>
                
                         <td>
                            <a class="info p-0" data-original-title="" title="" href="{{ URL::to('/master-services/edit/'.$cdata->slug) }}">
                               <i class="ft-edit font-medium-3 mr-2"></i>
                            </a>
                            <!--@if (env('Environment') == 'sendbox')-->
                            <!--<a class="danger p-0" onclick="myFunction()"><i class="ft-trash font-medium-3 mr-2"></i></a>-->
                            <!--@else-->
                            <!--<a class="danger p-0" onclick="deletecategory('{{$cdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/master-services/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">-->
                            <!--   <i class="ft-trash font-medium-3 mr-2"></i>-->
                            <!--</a>-->
                            <!--@endif-->
                            <a class="info p-0" data-original-title="" title="" href="{{ URL::to('/master-services/del/'.$cdata->id) }}">
                               <i class="ft-trash font-medium-3 mr-2"></i>
                            </a>
                         </td>
                      </tr>
                      @endforeach
                      @endif
                
                
                   </tbody>
                </table>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection
@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>

<!-- JavaScript initialization -->
<script>
   $(document).ready(function() {
      $('#masterServiceTable').DataTable();
   });
</script>
@endsection