<table class="table table-responsive-sm">
   <thead>
      <tr>
         <th>{{trans('labels.srno')}}</th>
         <th>{{trans('labels.booking_id')}}</th>
         <th>{{trans('labels.service_name')}}</th>
          <th>{{trans('labels.amount')}}</th>
         <th>{{trans('labels.date_time')}}</th>
         <th>{{trans('labels.status')}}</th>
         
      </tr>
   </thead>
   <tbody>
	@if(count($bookingdata) > 0)
		<?php $i = 1;?>
		 	<?php //print_r($bookingdata); ?>
	   	@foreach($bookingdata as $bdata)
	  
	      <tr>    
	         <td><?=$i++;?></td> 
	         <td>{{$bdata->booking_id}}</td>
	         <td>{{$bdata->service_name}}</td>
	         <td>{{$bdata->total_amt}}</td>
	         <td>{{Helper::date_format($bdata->date)}}<br>{{$bdata->time}}</td>
	         <td>
	            @if($bdata->status == 1)
	               <span class="badge badge-warning"><i class="ft-clock"></i> {{ trans('labels.pending') }} </span>
	            @elseif($bdata->status == 2)
	               <span class="badge badge-info">
	               @if($bdata->handyman_id != "")
	                  <i class="ft-user"></i> {{ trans('labels.handyman_assigned') }}
	               @else
	                  <i class="ft-check"></i> {{ trans('labels.accepted') }}
	               @endif
	               </span>
	            @elseif($bdata->status == 3)
	               <span class="badge badge-success"><i class="ft-check"></i> {{ trans('labels.completed') }} </span>
	            @elseif($bdata->status == 4)
	               
	               <span class="badge badge-danger" ><i class="ft-x"></i>
	               	@if($bdata->canceled_by == 1)
	               		@if(Auth::user()->type == 1)
	               			{{ trans('labels.cancel_by_provider') }} 
	               		@else
	               			{{ trans('labels.cancel_by_you') }} 
	               		@endif
	               	@else 
	               		{{ trans('labels.cancel_by_customer') }} 
	               	@endif
	               </span>
	               
	            @endif
	         </td>
	       
	      </tr>
	   @endforeach
	   
         <tr>
            <td colspan="7" align="right">
               <div class="float-right">
                  {{ $bookingdata->links() }}
               </div>
            </td>
         </tr>
   @else
         <tr>
            <td colspan="7" align="center">
              Revenue not found
            </td>
         </tr>
   @endif
   </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
