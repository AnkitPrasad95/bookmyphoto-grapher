   <table class="table table-responsive-sm">
      <thead>
      <tr>
         <th>{{trans('labels.srno')}}</th>
         <th>{{trans('labels.image')}}</th>
         <th>{{trans('labels.type')}}</th>
         <th>{{trans('labels.category_name')}}</th>
         <th>{{trans('labels.service_name')}}</th>
         <th>{{trans('labels.action')}}</th>
      </tr>
      </thead>
      <tbody>
      @if(count($bannerdata) > 0)
         <?php $i = 1;?>
         @foreach($bannerdata as $bdata)
            <tr>    
               <td><?=$i++;?></td> 
               <td>
                  <img src="{{Helper::image_path($bdata->image)}}" alt="{{trans('labels.banner')}}" class="rounded table-image">
               </td>
               @if($bdata->type == 1)
                  <td>{{trans('labels.category')}}</td>
               @elseif($bdata->type == 2)
                  <td>{{trans('labels.service')}}</td>
               @endif
               @if($bdata->type == 1)
                  <td>{{$bdata->category_name}}</td>
                  <td></td>
               @elseif($bdata->type == 2)
                  <td></td>
                  <td>{{$bdata['servicename']->name}}</td>
               @endif
               <td>
                  <a class="info p-0" href="{{ URL::to('/banners/edit/'.$bdata->id) }}">
                     <i class="ft-edit font-medium-3 mr-2"></i>
                  </a>
                  @if (env('Environment') == 'sendbox')
                     <a class="danger p-0" onclick="myFunction()" ><i class="ft-trash font-medium-3 mr-2"></i>
                  @else
                     <a class="danger p-0" onclick="deletebanner('{{$bdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/banners/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')" ><i class="ft-trash font-medium-3 mr-2"></i>
                     </a>
                  @endif
               </td>
            </tr>
         @endforeach
         <tr>
            <td colspan="6" align="right">
               <div class="float-right">
                  {{ $bannerdata->links() }}
               </div>
            </td>
         </tr>
      @else
         <tr>
            <td colspan="6" align="center">
               {{trans('labels.no_data')}}
            </td>
         </tr>
      @endif
      </tbody>
   </table>
