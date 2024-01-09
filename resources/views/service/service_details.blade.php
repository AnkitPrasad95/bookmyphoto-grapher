@extends('layout.main')
@section('page_title')
	{{trans('labels.service')}} | {{@$servicedata->service_name}}
@endsection
@section('content')
        <section id="about">
            <div class="row match-height">
                <!-- service info -->
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block mt-2">
                            	<div class="form-group row">
						            <div class="col-auto">
						                <img src='{{Helper::image_path($servicedata->service_image)}}' class='rounded detail-image'>
						            </div>
						            <div class="col">
						            	<div class="row">
										    <div class="col col-md-12 px-0">
                                                <h5 class="text-bold-500 primary mt-0">{{$servicedata->service_name}}
										    	    <div class="vendor_ratting">
				                                        <i class="fa fa-star yellow"></i>
				                                        <span>{{number_format($serviceaverageratting->avg_ratting,1)}}</span>
				                                    </div>
										        </h5>
                                            </div>
										</div>
						            </div>
						        </div>
                                <hr>
                                <div class="row">
                                	<div class="col-12 col-md-6 col-lg-4">
                                        <ul class="no-list-style">
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-smartphone font-small-3"></i> {{trans('labels.status')}}</span>
                                                <span class="display-block overflow-hidden">
                                                    @if($servicedata->is_available == 1)
                                                    	<span class="success"><i class="ft-check font-medium-3"></i> {{trans('labels.active')}}</span>
                                                    @elseif($servicedata->is_available == 2)
                                                    	<span class="danger"><i class="ft-x font-medium-3"></i> {{trans('labels.not_active')}}</span>
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-book font-small-3"></i> {{trans('labels.created_at')}}</span>
                                                <span class="display-block overflow-hidden">{{Helper::date_format($servicedata->date)}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <ul class="no-list-style">
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="fa fa-money font-small-3"></i> {{trans('labels.price')}}</span>
                                                <span class="display-block overflow-hidden">{{Helper::currency_format($servicedata->price)}}</span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-clock font-small-3"></i> {{trans('labels.duration')}}</span>
                                                <span class="display-block overflow-hidden">
                                                	@if($servicedata->price_type == "Fixed")
		                                                @if ($servicedata->duration_type == 1)
		                                                   {{$servicedata->duration.trans('labels.minutes')}}
		                                                @elseif ($servicedata->duration_type == 2)
		                                                   {{$servicedata->duration.trans('labels.hours')}}
		                                                @elseif ($servicedata->duration_type == 3)
		                                                   {{$servicedata->duration.trans('labels.days')}}
		                                                @else
		                                                   {{$servicedata->duration.trans('labels.minutes')}}
		                                                @endif <i class="fas fa-clock ml-1"></i>
		                                          @else
		                                             {{$servicedata->price_type}} <i class="fas fa-clock ml-1"></i>
		                                          @endif
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--<div class="col-12 col-md-6 col-lg-4">-->
                                    <!--    <ul class="no-list-style">-->
                                    <!--        <li class="mb-2">-->
                                    <!--            <span class="text-bold-500 primary"><i class="ft-percent font-small-3"></i> {{trans('labels.discount')}}</span>-->
                                    <!--            <span class="display-block overflow-hidden">{{number_format($servicedata->discount,2)}}%</span>-->
                                    <!--        </li>-->
                                    <!--        <li class="mb-2">-->
                                    <!--            <span class="text-bold-500 primary"><i class="fa fa-list-alt font-small-3"></i> {{trans('labels.category')}}</span>-->
                                    <!--            <span class="display-block overflow-hidden">{{$servicedata->category_name}}</span>-->
                                    <!--        </li>-->
                                    <!--    </ul>-->
                                    <!--</div>-->
                                    <div class="col-12 col-md-12 col-lg-12">
                                        <ul class="no-list-style">
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-list font-small-3"></i> {{trans('labels.description')}}</span>
                                                <span class="display-block overflow-hidden">{{Str::limit(strip_tags($servicedata->description),250)}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Provider info -->
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block mt-2">
                                <div class="form-group row">
                                    <div class="col-auto">
                                        <img src='{{Helper::image_path($servicedata->provider_image)}}' class='rounded detail-image'>
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col col-md-12 px-0">
                                                <h5 class="text-bold-500 primary mt-2">{{$servicedata->provider_name}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <ul class="no-list-style">
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-smartphone font-small-3"></i> {{trans('labels.status')}}</span>
                                                <span class="display-block overflow-hidden">
                                                    @if($servicedata->provider_status == 1)
                                                        <span class="success"><i class="ft-check font-medium-3"></i> {{trans('labels.active')}}</span>
                                                    @elseif($servicedata->provider_status == 2)
                                                        <span class="danger"><i class="ft-x font-medium-3"></i> {{trans('labels.not_active')}}</span>
                                                    @endif
                                                </span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-mail font-small-3"></i> {{trans('labels.email')}}</span>
                                                <span class="display-block overflow-hidden">{{$servicedata->provider_email}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <ul class="no-list-style">
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('labels.mobile')}}</span>
                                                <span class="display-block overflow-hidden">{{$servicedata->provider_mobile}}</span>
                                            </li>
                                            <li class="mb-2">
                                                <span class="text-bold-500 primary"><i class="fa fa-list-alt font-small-3"></i> {{trans('labels.provider_type')}}</span>
                                                <span class="display-block overflow-hidden">{{$servicedata->provider_type}}</span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="row">
            <!-- chart -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="panel-title">{{trans('labels.bookings')}}</h3>
                            </div>
                            <div class="col-md-4">
                               <select name="year" class="form-control" id="year"  data-show-subtext="true"data-live-search="true" url="{{URL::to('/services/'.$servicedata->slug)}}">
                                    <option value="" selected disabled>{{trans('labels.select')}}</option>
                                    @foreach($years as $year)
                                        <option value="{{$year->year}}" @if($year->year == $servicedata->year) selected @endif>{{$year->year}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="piechart_3d" class="card-body card-block height-400 width-600 lineAreaDashboard"></div>
                </div>
            </div>
            <!-- statastic cards -->
            <div class="col-md-6">
                <div class="row match-height">

                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="card gradient-green-tea">
                            <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                        <div class="media-body white text-left">
                                            <h3>{{$total_completed}}</h3>
                                            <span>{{trans('labels.total_completed')}}</span>
                                        </div>
                                        <div class="media-right align-self-center">
                                            <i class="icon-check white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="card gradient-blackberry">
                            <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                        <div class="media-body white text-left">
                                            <h3>{{$total_pending}}</h3>
                                            <span>{{trans('labels.total_pending')}}</span>
                                        </div>
                                        <div class="media-left align-self-center">
                                            <i class="icon-graph white font-large-2 float-left"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="card gradient-ibiza-sunset">
                            <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                        <div class="media-body white text-left">
                                            <h3>{{$total_canceled}}</h3>
                                            <span>{{trans('labels.total_cancelled')}}</span>
                                        </div>
                                        <div class="media-right align-self-center">
                                            <i class="icon-close white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="card gradient-green-tea">
                            <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                        <div class="media-body white text-left">
                                            <h3>{{$total_bookings}}</h3>
                                            <span>{{trans('labels.total_bookings')}}</span>
                                        </div>
                                        <div class="media-right align-self-center">
                                            <i class="icon-speedometer white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="card gradient-pomegranate">
                            <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                        <div class="media-body white text-left">
                                            <h3>{{Helper::currency_format($total_earning)}}</h3>
                                            <span>{{trans('labels.total_earnings')}}</span>
                                        </div>
                                        <div class="media-right align-self-center">
                                            <i class="icon-bar-chart white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-lg-6 col-12">
                        <div class="card gradient-ibiza-sunset">
                            <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                        <div class="media-body white text-left">
                                            <h3>{{Helper::currency_format($total_pending_earning)}}</h3>
                                            <span>{{trans('labels.pending_earnings')}}</span>
                                        </div>
                                        <div class="media-right align-self-center">
                                            <i class="icon-clock white font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- rattings and reviews -->
        <section id="striped-light">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><strong> {{trans('labels.rattings_reviews')}} </strong></h4>
                        </div>
                        <div class="card-body">
                            @if(!empty($rattingsdata) && count($rattingsdata)>0)
                            <div class="card-block">
                                @foreach ($rattingsdata as $rdata)
                                    <div class="form-group row border-bottom border-gray mb-2">
                                        <div class="col-md-1 mb-1">
                                            <img src="{{Helper::image_path($rdata->user_image)}}" class="rounded table-image" alt="{{trans('labels.image')}}">
                                        </div>
                                        <div class="col-md-11">
                                            <div class="row">
                                                <div class="col col-md-10"><strong>{{$rdata->user_name}}</strong></div>
                                                <div class="col col-md-2 text-right text-muted">{{Helper::date_format($rdata->date)}}</div>
                                                <div class="w-100"></div>
                                                <div class="col col-md-10">{{strip_tags($rdata->comment)}}</div>
                                                <div class="col col-md-2 text-right">
                                                    <i class="fa fa-star yellow"></i>
                                                    <span class="d-inline-block average-rating">{{number_format($rdata->ratting,1)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @else
                                <p class="text-center">{{trans('labels.no_data')}}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
@endsection
@section('scripts')
<script src="{{ asset('storage/app/public/admin-assets/js/google-chart.js') }}" type="text/javascript"></script>
<script src="{{ asset('resources/views/service/service.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    var booking = <?php echo $booking; ?>;
    drawMonthwiseChart(booking, 'Month wise bookings');
	$('#year').change(function(){
	    var year = $(this).val();
        load_monthwise_data(year, 'Month wise bookings For');
	});
    function load_monthwise_data(year, title){
        var myurl = $("#year").attr('url');
        var temp_title = title + ' '+year+'';
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:myurl,
            method:"GET",
            data:{year:year},
            dataType:"JSON",
            success:function(data){
                drawMonthwiseChart(data, temp_title);
            }
        });
    }
    function drawMonthwiseChart(chart_data, chart_main_title){
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(chart_data);
            var options = {title: chart_main_title,is3D: true,pieSliceText: 'value-and-percentage',};
            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    }
	</script>
@endsection