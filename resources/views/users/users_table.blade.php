   <table class="table table-responsive-sm">
      <thead>
         <tr>
            <th>{{ trans('labels.srno') }}</th>
            <th>{{ trans('labels.profile') }}</th>
            <th>{{ trans('labels.name') }}</th>
            <th>{{ trans('labels.email') }}</th>
            <th>{{ trans('labels.mobile') }}</th>
            <th>{{ trans('labels.status') }}</th>
         </tr>
      </thead>
      <tbody>
      @if(count($usersdata) > 0)
         <?php $i = 1;?>
         @foreach($usersdata as $udata)
            <tr>    
               <td><?=$i++;?></td> 
               <td> <img src="{{Helper::image_path($udata->image)}}" alt="{{trans('labels.users')}}" class="rounded table-image"> </td>
               <td>{{$udata->name}}</td>
               <td>{{$udata->email}}</td>
               <td>{{$udata->mobile}}</td>
               <td>
                  @if (env('Environment') == 'sendbox')

                     @if($udata->is_available == 1)
                        <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                     @else
                        <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                     @endif
                  @else
                     @if($udata->is_available == 1)
                        <a class="success p-0" onclick="updateuserstatus('{{$udata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('users/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                     @else
                        <a class="danger p-0" onclick="updateuserstatus('{{$udata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('users/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                     @endif
                  @endif
               </td>
            </tr>
         @endforeach
            <tr>
               <td colspan="8" align="right">
                  <div class="float-right">
                     {{ $usersdata->links() }}
                  </div>
               </td>
            </tr>
      @else
            <tr>
               <td colspan="8" align="center">
                     {{ trans('labels.no_result') }}
               </td>
            </tr>
      @endif
      </tbody>
   </table>
   <input type="hidden" name="hidden_page" id="hidden_page" value="1" />