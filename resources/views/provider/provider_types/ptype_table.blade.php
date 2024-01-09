
<table class="table table-responsive-sm">
   <thead>
      <tr>
         <th>{{ trans('labels.srno') }}</th>
         <th>{{ trans('labels.type_name') }}</th>
         <th>{{ trans('labels.commission') }}</th>
         <th>{{ trans('labels.status') }}</th>
         <th>{{ trans('labels.action') }}</th>
      </tr>
   </thead>
   <tbody>
@if(count($providertypedata) > 0)
	<?php $i = 1;?>
       @foreach($providertypedata as $ptd)
          <tr>    
             <td><?=$i++;?></td> 
             <td>{{$ptd->name}}</td>
             <td>{{$ptd->commission}}%</td>
             <td>
               @if (env('Environment') == 'sendbox')
                  @if($ptd->is_available == 1)
                     <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                  @endif
               @else
                  @if($ptd->is_available == 1)
                     <a class="success p-0" onclick="updateprovidertypestatus('{{$ptd->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('provider_types/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" onclick="updateprovidertypestatus('{{$ptd->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('provider_types/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                  @endif
               @endif

             </td>
             <td>
               <a class="info p-0" href="{{ URL::to('/provider_types/edit/'.$ptd->id) }}"><i class="ft-edit font-medium-3 mr-2"></i></a>
               @if (env('Environment') == 'sendbox')
                  <a class="danger p-0" onclick="myFunction()"><i class="ft-trash font-medium-3 mr-2"></i></a>
               @else
                  <a class="danger p-0" onclick="deleteprovidertype('{{$ptd->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/provider_types/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')">
                      <i class="ft-trash font-medium-3 mr-2"></i>
                   </a>
               @endif
             </td>
          </tr>
       @endforeach
       
       	<tr>
            <td colspan="5" align="right">
               <div class="float-right">
                  {{ $providertypedata->links() }}
               </div>
            </td>
         </tr>
   @else
         <tr>
            <td colspan="5" align="center">
                  {{ trans('labels.ptype_not_found') }}
            </td>
         </tr>
   @endif

   </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />