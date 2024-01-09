@if(count($paymentmethodsdata) > 0)
   <table class="table table-responsive-sm">
      <thead>
         <tr>
            <th>{{trans('labels.srno')}}</th>
            <th>{{trans('labels.name')}}</th>
            <th>{{trans('labels.status')}}</th>
            <th>{{trans('labels.action')}}</th>
         </tr>
      </thead>
      <tbody>
         <?php $i = 1;?>
         @foreach($paymentmethodsdata as $pmdata)
            <tr>    
               <td><?=$i++;?></td> 
               <td>{{$pmdata->payment_name}}</td>
               <td>
                  @if (env('Environment') == 'sendbox')
                     @if($pmdata->is_available == 1)
                        <a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
                     @else
                        <a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
                     @endif
                  @else
                     @if($pmdata->is_available == 1)
                        <a class="success p-0" onclick="updatepaymentmethodstatus('{{$pmdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('payment-methods/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
                     @else
                        <a class="danger p-0" onclick="updatepaymentmethodstatus('{{$pmdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('payment-methods/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
                     @endif
                  @endif
               </td>
               <td>
                  @if($pmdata->payment_name != "COD" && $pmdata->payment_name != "Wallet")
                     <a class="info" data-original-title="" title="" href="{{ URL::to('/payment-methods/'.$pmdata->id) }}">
                        <i class="ft-edit font-medium-3 mr-2"></i>
                     </a>
                  @endif
               </td>
            </tr>
         @endforeach
      </tbody>
   </table>
@else
<p class="text-center text-muted">{{trans('labels.payment_not_found')}}</p>
@endif