
<table class="table table-responsive-sm">
   <thead>
   <tr>
      <th>{{ trans('labels.srno') }}</th>
      <th>{{ trans('labels.image') }}</th>
      <th>{{ trans('labels.name') }}</th>
      <th>{{ trans('labels.status') }}</th>
      <th>{{ trans('labels.action') }}</th>
   </tr>
   </thead>
   <tbody>

@if(count($citydata) > 0)
	<?php $i = 1;?>
       @foreach($citydata as $cd)
          <tr>    
             <td><?=$i++;?></td>
             <td><img src="{{Helper::image_path($cd->image)}}" alt="{{trans('labels.image')}}" class="rounded table-image"></td>
             <td>{{$cd->name}}</td>
             <td>

               @if (env('Environment') == 'sendbox')
                  @if($cd->is_available == 1)
                      <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                   @else
                      <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                   @endif
               @else
                   @if($cd->is_available == 1)
                      <a class="success p-0" onclick="updatecitystatus('{{$cd->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('cities/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                   @else
                      <a class="danger p-0" onclick="updatecitystatus('{{$cd->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('cities/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                   @endif
                @endif
             </td>
             <td>
                  <a class="info p-0" data-original-title="" title=""  href="{{ URL::to('/cities/edit/'.$cd->id) }}">
                     <i class="ft-edit font-medium-3 mr-2"></i>
                  </a>
                  @if (env('Environment') == 'sendbox')
                      <a class="danger p-0" onclick="myFunction()"><i class="ft-trash font-medium-3 mr-2"></i></a>
                  @else
                     <a class="danger p-0" data-original-title="" title="" onclick="deletecity('{{$cd->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/cities/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')" ><i class="ft-trash font-medium-3 mr-2"></i>
                     </a>
                  @endif
             </td>
          </tr>
       @endforeach
       
       	<tr>
            <td colspan="5" align="right">
               <div class="float-right">
                  {{ $citydata->links() }}
               </div>
            </td>
         </tr>
   @else
         <tr>
            <td colspan="5" align="center">
                  {{ trans('labels.city_not_found') }}
            </td>
         </tr>
   @endif
   </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />