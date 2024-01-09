@extends('layout.main')
@section('page_title',trans('labels.home'))
@section('content')
   
<div class="row match-height">
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
	    <div class="card gradient-virgin-america">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$today_bookings}}</h3>
                     <span>{{trans('labels.today_bookings')}}</span>
                  </div>
                  <a href="{{URL::to('/bookings?today=1')}}">
                     <div class="media-right white text-right">
                        <i class="fa fa-list-alt font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
    
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-cosmic-fusion">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$today_revenue}}</h3>
                     <span>{{trans('labels.today_revenue')}}</span>
                  </div>
                  <a href="{{URL::to('/revenue?today=1')}}">
                     <div class="media-right white text-right">
                        <i class="fa fa-list-alt font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	
	@if(Auth::user()->type == 1)
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-green-tea">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_providers}}</h3>
                     <span>{{trans('labels.total_providers')}}</span>
                  </div>
                  <a @if(Auth::user()->type == 1) href="{{URL::to('/providers')}}" @endif>
                     <div class="media-right white text-right">
                        <i class="ft-users font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-blackberry">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
                  <div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_categories}}</h3>
                     <span>{{trans('labels.total_categories')}}</span>
                  </div>
                  <a @if(Auth::user()->type == 1) href="{{URL::to('/categories')}}" @endif>
                     <div class="media-right white text-right">
                        <i class="fa fa-list-alt font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">					
				</div>
			</div>
		</div>
	</div>

   <div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-green-tea">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_coupons}}</h3>
                     <span>{{trans('labels.total_coupons')}}</span>
                  </div>
                  <a @if(Auth::user()->type == 1) href="{{URL::to('/coupons')}}" @endif> 
                     <div class="media-right white text-right">
                        <i class="fa fa-gift font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	

	
   <div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-blackberry">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_cities}}</h3>
                     <span>{{trans('labels.total_cities')}}</span>
                  </div>
                  <a @if(Auth::user()->type == 1) href="{{URL::to('/cities')}}" @endif>
                     <div class="media-right white text-right">
                        <i class="icon-map font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-ibiza-sunset">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_services}}</h3>
                     <span>{{trans('labels.total_services')}}</span>
                  </div>
                  <a href="{{URL::to('/services')}}">
                     <div class="media-right white text-right">
                        <i class="fa fa-heart font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart1" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">
				</div>
			</div>
		</div>
	</div>
	
   <div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-pomegranate">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_handymans}}</h3>
                     <span>{{trans('labels.total_handyman')}}</span>
                  </div>
                  <a href="{{URL::to('/handymans')}}">
                     <div class="media-right white text-right">
                        <i class="fa fa-users font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-purple-bliss">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_bookings}}</h3>
                     <span>{{trans('labels.total_bookings')}}</span>
                  </div>
                  <a href="{{URL::to('/bookings')}}">
                     <div class="media-right white text-right">
                        <i class="fa fa-list-alt font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	
	
	
		<div class="col-xl-3 col-lg-6 col-md-6 col-12">
		<div class="card gradient-back-to-earth">
			<div class="card-body">
				<div class="card-block pt-2 pb-0">
					<div class="media">
						<div class="media-body white text-left">
                     <h3 class="font-large-1 mb-0">{{$total_revenue}}</h3>
                     <span>{{trans('labels.total_revenue')}}</span>
                  </div>
                  <a href="{{URL::to('/revenue')}}">
                     <div class="media-right white text-right">
                        <i class="fa fa-list-alt font-large-2"></i>
                     </div>
                  </a>
					</div>
				</div>
				<div id="Widget-line-chart2" class="height-75 WidgetlineChart WidgetlineChartshadow mb-2">				
				</div>
			</div>
		</div>
	</div>
	
		

</div>

	<div class="row match-height">

      <!-- users-chart -->
    	<div class="col-xl-6 col-lg-12 @if(Auth::user()->type == 2) dn @endif">
       	<div class="card">
            <div class="card-header border-bottom">
               <div class="row">
                   <div class="col-md-8">
                       <h3 class="panel-title">{{trans('labels.users')}}</h3>
                   </div>
                   <div class="col-md-4">
                     <select name="year" class="form-control" id="year" data-show-subtext="true" data-live-search="true" url="{{URL::to('/dashboard')}}">
                        @foreach($user_years as $year)
                           <option value="{{$year->years}}">{{$year->years}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <div class="card-body"><div class="card-block"><div id="users-chart" class="height-350" ></div></div></div>
        	</div>
    	</div>

    	<!-- bookings-chart -->
      <div class="col-xl-6 col-lg-12">
         <div class="card">
            <div class="card-header border-bottom">
               <div class="container">
                  <div class="row">
                     <div class="col"><h3 class="panel-title">{{trans('labels.bookings')}}</h3></div>
                     <form class="input-group-append" id="get-bookings" url="{{URL::to('/dashboard')}}">
                     @if(Auth::user()->type == 1)
	                     <div class="col-lg-7">
	                        <select name="provider" class="form-control" id="provider" data-show-subtext="true" data-live-search="true">
	                           @foreach($providers as $pdata)
	                              <option value="{{$pdata->id}}">{{$pdata->name}}</option>
	                           @endforeach
	                        </select>
	                     </div>
                     @endif
                     <div class="@if(Auth::user()->type == 1) col-lg-5 @else col-md-auto @endif">
                        <select name="booking_year" class="form-control" id="booking_year" data-show-subtext="true" data-live-search="true" url="{{URL::to('/dashboard')}}">
                           @foreach($booking_years as $byear)
                              <option value="{{$byear->year}}">{{$byear->year}}</option>
                           @endforeach
                        </select>
                     </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="card-body"><div class="card-block"><div id="bookings-chart" class="height-350"></div></div></div>
         </div>
      </div>

      <!-- items-chart -->
      <div class="col-xl-6 col-lg-12 @if(Auth::user()->type == 1) dn @endif">
         <div class="card">
            <div class="card-header border-bottom">
               <div class="container">
                  <div class="row">
                     <div class="col"><h3 class="panel-title">{{trans('labels.service_bookings')}}</h3></div>
                     <form class="input-group-append" id="get-service-orders" url="{{URL::to('/dashboard')}}">
                        <div class="col-lg-8">
                           <select name="service" class="form-control" id="service" data-show-subtext="true" data-live-search="true">
                              @foreach($services as $sdata)
                                 <option value="{{$sdata->id}}">{{$sdata->name}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-lg-4">
                           <select name="service_year" class="form-control" id="service_year" data-show-subtext="true" data-live-search="true">
                              @foreach($service_years as $oyear)
                                 <option value="{{$oyear->years}}">{{$oyear->years}}</option>
                              @endforeach
                           </select>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
            <div class="card-body"><div class="card-block"><div id="service-orders-chart" class="height-350"></div></div></div>
         </div>
      </div>


   </div>

@endsection
@section('scripts')
<script src="{{ asset('storage/app/public/admin-assets/js/google-chart.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    
   // users-chart
   var user_count = <?php echo $user_chart_data; ?>;
   DrawUsersColumnChart(user_count, 'Month wise users');
   $('#year').change(function(){
	   var year = $(this).val();
      UsersChartData(year, 'Month wise users for');
	});
   function UsersChartData(year, title){
      var myurl = $("#year").attr('url');
      var temp_title = title + ' '+year+'';
      $.ajax({
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         url:myurl,
         method:"GET",
         data:{year:year},
         dataType:"JSON",
         success:function(data){
            var chart_data = data.users_count;
            DrawUsersColumnChart(chart_data, temp_title);
         }
      });
   }
   function DrawUsersColumnChart(chart_data, chart_main_title){
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawLineChart);
      function drawLineChart() {
         if(chart_data.length <= 1){
            chart_data.push(["No data", 0,0,0]);
         }
         var data = google.visualization.arrayToDataTable(chart_data);
    //     alert(JSON.stringify(data));
         var options = {title: chart_main_title,pieSliceText: 'value-and-percentage',
            vAxis: {title: 'Users',},
            bar: {groupWidth: "50%"},
         };
         var chart = new google.visualization.ColumnChart(document.getElementById('users-chart'));
         chart.draw(data, options);
      }
   }



   // booking chart
   var bookings_count = <?php echo $rest_chart_data; ?>;
   DrawPieChart(bookings_count, 'Month wise bookings');
   $('#get-bookings').change(function(){
      var provider = $("#provider").val();
      var booking_year = $("#booking_year").val();
      BookingsChartData(booking_year,provider,'Month wise bookings for');
   });
   function BookingsChartData(booking_year,provider,title){
      var myurl = $("#get-bookings").attr('url');
      var temp_title = title +' '+booking_year+'';
      $.ajax({
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         url:myurl,
         method:"GET",
         data:{booking_year:booking_year,provider:provider},
         dataType:"JSON",
         success:function(data){
            var chart_data = data.bookings_count;
            DrawPieChart(chart_data, temp_title);
         }
      });
   }
   function DrawPieChart(chart_data, chart_main_title){
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
         var data = google.visualization.arrayToDataTable(chart_data);
         var options = {title: chart_main_title,is3D: true,pieSliceText: 'value-and-percentage',};
         var chart = new google.visualization.PieChart(document.getElementById('bookings-chart'));
         chart.draw(data, options);
      }
   }

   // service-booking chart
   var service_orders_count = <?php echo $service_chart_data; ?>;
   DrawDonutChart(service_orders_count, 'Month wise orders');
   $('#get-service-orders').change(function(){
      var service = $("#service").val();
      var service_year = $("#service_year").val();
      ItemOrdersChartData(service_year,service,'Month wise orders for');
   });
   function ItemOrdersChartData(service_year,service,title){
      var myurl = $("#get-service-orders").attr('url');
      var temp_title = title +' '+service_year+'';
      $.ajax({
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
         url:myurl,
         method:"GET",
         data:{service_year:service_year,service:service},
         dataType:"JSON",
         success:function(data){
            var chart_data = data.service_orders_count;
            DrawDonutChart(chart_data, temp_title);
         }
      });
   }
   function DrawDonutChart(chart_data, chart_main_title){
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
         var data = google.visualization.arrayToDataTable(chart_data);
         var options = {title: chart_main_title,pieHole: 0.4,pieSliceTextStyle: {color: 'black'} };
         var chart = new google.visualization.PieChart(document.getElementById('service-orders-chart'));
         chart.draw(data, options);
      }
   }

	</script>
@endsection