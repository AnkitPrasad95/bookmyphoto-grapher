<?php 
// echo "</pre>";
// print_r($couponsdata->toArray());
// echo "</pre>";
//die;
?>
<table class="table table-responsive-sm">
   <thead>
      <tr>
         <th>{{trans('labels.srno')}}</th>
         <th>{{trans('labels.coupon_code')}}</th>
         <th>{{trans('labels.service_name')}}</th>
         <th>{{trans('Coupon Type')}}</th>
         <th>{{trans('labels.discount')}}</th>
         <th>{{trans('labels.start')}}-{{trans('labels.expire')}}</th>
         <th>{{trans('labels.description')}}</th>
         <th>{{trans('labels.status')}}</th>
         <th>{{trans('labels.action')}}</th>
      </tr>
   </thead>
   <tbody>	
	@if(count($couponsdata) > 0)
		<?php $i = 1;?>
	   	@foreach($couponsdata as $cdata)
	      <tr>    
	         <td><?=$i++;?></td>
	         <td>{{$cdata->code}}</td>
	         <td>
	             @if($cdata->type == 'service' && $cdata->service_id > 0) {{ $cdata['servicename']->name}} @endif
	             
	             @if($cdata->type == 'service' && $cdata->service_id == 0) {{ 'All' }} @endif
	             
	             @if($cdata->type == 'photographer' && $cdata->photographer_id > 0) {{ $cdata->photographer_name}} @endif
	             
	             @if($cdata->type == 'photographer' && $cdata->photographer_id == 0) {{ 'All' }}@endif
	             
	             @if($cdata->type == 'all') {{ 'All' }} @endif
	             
	             
             </td>
	         <td>@if($cdata->type == 'service') {{ 'Service' }}  @elseif($cdata->type == 'photographer') {{ 'Photographer' }} @else {{ 'All' }} @endif </td>
	         <td>
	            @if($cdata->discount_type == 1)
	               {{Helper::currency_format($cdata->discount)}}
	            @else
	               {{$cdata->discount}}%
	            @endif
	         </td>
	         <td width="20%">
	            <span class='badge badge-info'>{{Helper::date_format($cdata->start_date)}}</span>
	            <span class='badge badge-warning'>{{Helper::date_format($cdata->expire_date)}}</span>
	         </td>
	         <td>{{Str::limit(strip_tags($cdata->description),50)}}</td>
	         <td>
	         	@if (env('Environment') == 'sendbox')
		            @if($cdata->is_available == 1)
		            	<a class="success p-0" onclick="myFunction()"><i class="ft-check font-medium-3 mr-2"></i></a>
		            @else
		            	<a class="danger p-0" onclick="myFunction()"><i class="ft-x font-medium-3 mr-2"></i></a>
		            @endif
		        	@else
		            @if($cdata->is_available == 1)
		               <a class="success p-0" onclick="updatecouponstatus('{{$cdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('coupons/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check font-medium-3 mr-2"></i></a>
		            @else
		               <a class="danger p-0" onclick="updatecouponstatus('{{$cdata->id}}','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('coupons/edit/status') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x font-medium-3 mr-2"></i></a>
		            @endif
		         @endif
	         </td>
	         <td>
	            
	            <a class="info p-0" data-original-title="" title="" href="{{ URL::to('/coupons/edit/'.$cdata->id) }}">
	               <i class="ft-edit font-medium-3 mr-2"></i>
	            </a>
	            
	            @if (env('Environment') == 'sendbox')
		            <a class="danger p-0" onclick="myFunction()"><i class="ft-trash font-medium-3 mr-2"></i></a>
		        	@else
	            	<a class="danger p-0" data-original-title="" title=""  onclick="deletecoupon('{{$cdata->id}}','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/coupons/del') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')" ><i class="ft-trash font-medium-3 mr-2"></i>
	            	</a>
	            @endif

	         </td>
	      </tr>
	   @endforeach

	   <tr>
         <td colspan="8" align="right">
            <div class="float-right">
               {{ $couponsdata->links() }}
            </div>
         </td>
      </tr>
   
   @else
   
      <tr>
         <td colspan="8" align="center">
             {{ trans('labels.coupon_not_found') }}
         </td>
      </tr>
   
   @endif
   
   </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />