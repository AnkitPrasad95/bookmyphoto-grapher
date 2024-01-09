
<table class="table table-responsive-sm">
   <thead>
      <tr>
         <th>{{ trans('labels.srno') }}</th>
         <th>{{ trans('labels.profile') }}</th>
         <th>{{ trans('labels.provider_type') }}</th>
         <th>{{ trans('labels.name') }}</th>
         <th>{{ trans('labels.email') }}</th>
         <th>{{ trans('labels.mobile') }}</th>
         <th>{{ trans('labels.status') }}</th>
         <th>{{ trans('labels.action') }}</th>
      </tr>
   </thead>
   <tbody>
   @if(count($providerdata) > 0)
      <?php $i = 1;?>
      @foreach($providerdata as $pdata)
         <tr>    
            <td><?=$i++;?></td>
            <td> <img src="{{Helper::image_path($pdata->image)}}" alt="{{trans('labels.provider')}}" class="rounded table-image"> </td>
            <td>{{$pdata['providertype']->name}}</td>
            <td>{{$pdata->name}}</td>
            <td>{{$pdata->email}}</td>
            <td>{{$pdata->mobile}}</td>
            <td>
               @if (env('Environment') == 'sendbox')
                  @if($pdata->is_available == 1)
                     <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                  @endif
               @else
                  @if($pdata->is_available == 1)
                     <a class="success p-0" onclick="updateproviderstatus('{{$pdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('providers/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" onclick="updateproviderstatus('{{$pdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('providers/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                  @endif
               @endif
            </td>
            <td class="px-0">
               <a class="dark p-0" href="{{ URL::to('/providers/'.$pdata->id) }}"><i class="ft-user font-medium-3 mr-2"></i></a>
               <a class="info p-0" href="{{ URL::to('/providers/edit/'.$pdata->id) }}"><i class="ft-edit font-medium-3 mr-2"></i></a>
               <a class="primary p-0" href="{{ URL::to('/log-in-provider/'.$pdata->id) }}"><i class="ft-log-in font-medium-3 mr-2"></i></a>
            </td>
         </tr>
      @endforeach
         <tr>
            <td colspan="8" align="right">
               <div class="float-right">
                  {{ $providerdata->links() }}
               </div>
            </td>
         </tr>
   @else
         <tr>
            <td colspan="8" align="center">
                  {{ trans('labels.providers_not_found') }}
            </td>
         </tr>
   @endif
   </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />