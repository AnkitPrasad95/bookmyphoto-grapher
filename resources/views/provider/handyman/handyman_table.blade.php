
<table class="table table-striped table-bordered default-ordering">
   <thead>
      <tr>
         <th>{{ trans('labels.srno') }}</th>
         <th>{{ trans('labels.profile') }}</th>
         <th>{{ trans('labels.provider') }}</th>
         <th>{{ trans('labels.name') }}</th>
         <th>{{ trans('labels.email') }}</th>
         <th>{{ trans('labels.mobile') }}</th>
         <th>{{ trans('labels.status') }}</th>
         <th>{{ trans('labels.action') }}</th>
      </tr>
   </thead>
   <tbody>
      <?php $i=1;?>
      @foreach($handymandata as $hdata)
      <tr>
         <td><?=$i++;?></td>
         <td>
            <img src="{{Helper::image_path($hdata->image)}}" alt="{{ trans('labels.image') }}" class="rounded table-image">
         </td>
         <td>{{ $hdata['providername']->name}}</td>
         <td>{{$hdata->name}}</td>
         <td>{{$hdata->email}}</td>
         <td>{{$hdata->mobile}}</td>
         <td>
            @if(Auth::user()->type == 2)

               @if (env('Environment') == 'sendbox')
                  @if($hdata->is_available == 1)
                     <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                  @endif
               @else
               
                  @if($hdata->is_available == 1)
                     <a class="success p-0" onclick="updatehandymanstatus('{{$hdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('handymans-status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" onclick="updatehandymanstatus('{{$hdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('handymans-status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                  @endif

               @endif
            @else
               <i class="@if($hdata->is_available == 1) success ft-check @else danger ft-x @endif font-medium-3 mr-2"></i>
            @endif
         </td>
         <td>
            <a class="dark p-0" href="{{ URL::to('/handymans/'.$hdata->id) }}" ><i class="ft-user font-medium-3 mr-2"></i></a>
            @if(Auth::user()->type == 2)
               <a class="info p-0" href="{{ URL::to('/handymans/edit/'.$hdata->id) }}"><i class="ft-edit font-medium-3 mr-2"></i></a>
            @endif
         </td>
      </tr>
      @endforeach
   </tbody>
</table>