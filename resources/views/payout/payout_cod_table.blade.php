
<table class="table table-responsive-sm">
   <thead>
      <tr>
         <th>{{ trans('labels.request_id') }}</th>
         <th>{{ trans('labels.provider_name') }}</th>
         <th>{{ trans('labels.amount') }}</th>
          <th>{{ trans('labels.image') }}</th>
         <th>{{ trans('labels.request_date') }}</th>
         <th>{{ trans('labels.payout_date') }}</th>
         <th>{{ trans('labels.status') }}</th>
         @if(Auth::user()->type == 1)
         <th>{{ trans('labels.action') }}</th>
         @endif
      </tr>
   </thead>
   <tbody>
   @if(!empty($requests) && count($requests) > 0)
      @foreach($requests as $prdata)
         <tr>
            <td>{{$prdata->request_id}}</td>
            <td>{{$prdata->provider_name}}</td>
            <td>
               <small>
               {{trans('labels.requested_amt')}} : <b>{{Helper::currency_format($prdata->request_balance)}}</b> <br>
              </small>
            </td>
            <td><img src="{{Helper::image_path($prdata->images)}}"  class="rounded table-image">
            </td>
            <td>{{Helper::date_format($prdata->request_date)}}</td>
            <td>@if($prdata->payout_date != ""){{Helper::date_format($prdata->payout_date)}} @else - @endif</td>
            <td>
               @if($prdata->status == 1)
                  <span class="badge badge-success">Approved</span>
               @endif
               @if($prdata->status == 2)
                  <span class="badge badge-warning">{{trans('labels.pending')}}</span>
               @endif
               @if($prdata->status == 3)
                  <span class="badge badge-warning">Rejected</span>
               @endif
            </td>
            @if(Auth::user()->type == 1)
               <td>
                  @if($prdata->status == 2)
                  <a class="badge badge-info payout_cod_pay_now" data-booking-id="{{$prdata->booking_id}}" data-request-id="{{$prdata->request_id}}" data-request-amount="{{$prdata->request_balance}}"  data-payable-amt="{{$prdata->payable_amt}}" data-provider-name="{{$prdata->provider_name}}" data-provider-id="{{$prdata->provider_id}}">Approve</a>
                  @else
                     -
                  @endif
               </td>
            @endif
         </tr>
      @endforeach
         <tr>
            <td colspan="7" align="right">
               <div class="float-right">
                  {{ $requests->links() }}
               </div>
            </td>
         </tr>
   @else
         <tr>
            <td colspan="7" align="center">
                  {{ trans('labels.payout_not_found') }}
            </td>
         </tr>
   @endif
   </tbody>
</table>