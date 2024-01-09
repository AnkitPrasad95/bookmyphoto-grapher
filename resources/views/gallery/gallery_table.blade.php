<table class="table table-responsive-sm">
   <thead>
      <tr>
         <th>{{trans('labels.srno')}}</th>
         <th>{{trans('labels.image')}}</th>
         <th>{{trans('labels.service_name')}}</th>
         <th>{{trans('labels.booking_id')}}</th>
         <th>{{trans('labels.date_time')}}</th>
         <th>{{trans('labels.status')}}</th>
         <th>{{trans('labels.action')}}</th>
      </tr>
   </thead>
   <tbody>
	@if(count($bookingdata) > 0)
		<?php $i = 1;?>
		
		 	<?php 
		 	// echo "<pre>";
		 	// print_r($bookingdata->toArray()); 
		 	// echo "</pre>";
		 	?>
	   	@foreach($bookingdata as $bdata)
	  
	      <tr>    
	         <td><?=$i++;?></td> 
	         <td><img src="{{Helper::image_path($bdata->service_image)}}" alt="{{trans('labels.image')}}" class="rounded table-image"></td>
	         <td>{{$bdata->service_name}}</td>
	         <td>{{$bdata->booking_id}}</td>
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
	         <td>
		         @if(Auth::user()->type == 2)
		            @if($bdata->status == 1)
		               <a class="btn btn-info btn-sm mb-0" onclick="acceptbooking('{{$bdata->id}}','2','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/accept') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check"></i> {{ trans('labels.accept') }}</a>
		               {{--<a class="btn btn-danger btn-sm mb-0" onclick="cancelbooking('{{$bdata->id}}','4','1','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/cancel') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-x"></i> {{ trans('labels.cancel') }} </a>--}}
		               <a class="btn btn-danger btn-sm float-right cancel_reason" data-bookingid="{{$bdata->id}}" data-toggle="modal" data-target="#cancel_reason"><i class="ft-x"></i> {{ trans('labels.cancel') }} </a>
                           
		            @endif
		            @if(!empty($ahandymandata))
                     @if($bdata->status == 2 && ($bdata->handyman_accept == 2 || $bdata->handyman_id == "") )
                        <a class="btn btn-warning btn-sm select_handyman mb-0" data-bookingid="{{$bdata->id}}" data-toggle="modal" data-target="#select_handyman"><i class="ft-user"></i> {{ trans('labels.assign_handyman') }} </a>
                     @endif
                  @endif
                  @if($bdata->status == 2)
                     <a class="btn btn-success btn-sm mb-0" onclick="completebooking('{{$bdata->id}}','3','{{ trans('messages.are_you_sure') }}','{{ trans('messages.yes') }}','{{ trans('messages.no') }}','{{ URL::to('/bookings/complete') }}','{{ trans('messages.wrong') }}','{{ trans('messages.record_safe') }}')"><i class="ft-check"></i> {{ trans('labels.complete') }}</a>
                  @endif
		         @endif
	         
	            	<a class="btn btn-primary btn-sm mb-0" data-original-title="View" title="View Image Gallery" href="{{ URL::to('/gallery/'.$bdata->booking_id) }}">
	            	<i class="ft-eye"></i> {{ trans('labels.view') }}
	            </a>
	            <a class="btn btn-primary btn-sm mb-0" data-original-title="Upload Image" title="Upload Image" href="{{ URL::to('/gallery/upload/'.$bdata->booking_id) }}">
	            	<i class="ft-eye"></i> Upload Image
	            </a>
	                 
           
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
               {{ trans('labels.booking_not_found') }}
            </td>
         </tr>
   @endif
   </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
