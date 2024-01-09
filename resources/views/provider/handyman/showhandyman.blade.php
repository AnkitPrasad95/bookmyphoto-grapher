@extends('layout.main')
@section('page_title')
   {{trans('labels.handyman')}} | {{@$handymandata->name}}
@endsection
@section('content')
    
    <section id="basic-form-layouts">
        <div class="row">
            <!-- Handyman Personal Info -->
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card pt-2">
                    <div class="card-body">
                        <div class="card-block">

                            <div class="row">
                                <div class="col-md-2">
                                    <img src="{{Helper::image_path($handymandata->image)}}" alt="{{trans('labels.image')}}" class="rounded booking-detail-profile zoom-in" data-enlargeable/>
                                </div>
                                <div class="col-lg-10">
                                    <div class="media-body ml-2">
                                        <div class="form-group row m-0">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col col-md-12">
                                                        <h3 class="text-bold-500 primary mt-2">{{$handymandata->name}}</h3>
                                                    </div>
                                                    <div class="w-100"><hr class="m-1"></div>
                                                    <div class="col col-md-12 ">
                                                        <div class="row">
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <ul class="no-list-style">
                                                                    <li class="">
                                                                        <span class="text-bold-500 primary"><i class="ft-smartphone font-small-3"></i> {{trans('labels.status')}}</span>
                                                                        <span class="display-block overflow-hidden">
                                                                            @if($handymandata->is_available == 1)
                                                                                <span class="success"><i class="ft-check font-medium-3"></i> {{trans('labels.active')}}</span>
                                                                            @elseif($handymandata->is_available == 2)
                                                                                <span class="danger"><i class="ft-x font-medium-3"></i> {{trans('labels.not_active')}}</span>
                                                                            @endif
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <ul class="no-list-style">
                                                                    <li class="">
                                                                        <span class="text-bold-500 primary"><i class="ft-mail font-small-3"></i> {{trans('labels.email')}}</span>
                                                                        <span class="display-block overflow-hidden">{{$handymandata->email}}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <ul class="no-list-style">
                                                                    <li class="">
                                                                        <span class="text-bold-500 primary"><i class="ft-phone font-small-3"></i> {{trans('labels.mobile')}}</span>
                                                                        <span class="display-block overflow-hidden">{{$handymandata->mobile}}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-12 col-md-6 col-lg-4">
                                                                <ul class="no-list-style">
                                                                    <li class="">
                                                                        <span class="text-bold-500 primary"><i class="fa fa-user font-small-3"></i> {{trans('labels.provider')}}</span>
                                                                        <span class="display-block overflow-hidden">{{$handymandata['providername']->name}}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <ul class="no-list-style">
                                                                    <li class="">
                                                                        <span class="text-bold-500 primary"><i class="ft-map font-small-3"></i> {{trans('labels.address')}}</span>
                                                                        <!--<span class="display-block overflow-hidden"><?php //echo strip_tags($handymandata->address).' ,'.$handymandata['city']->name ?></span>-->
                                                                        <span class="display-block overflow-hidden">{{strip_tags($handymandata->address)}}</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <!-- chart & statastic cards -->
            <div class="col-12 col-md-12 col-lg-12">
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
                                        <select name="year" class="form-control" id="year" data-show-subtext="true"data-live-search="true" url="{{URL::to('/handymans/'.$handymandata->slug)}}">
                                            <option value="" selected disabled>{{trans('labels.select')}}</option>
                                            @foreach($years as $year)
                                                <option value="{{$year->year}}">{{$year->year}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="piechart_3d" class="height-350 lineChart1"></div>
                        </div>
                    </div>

                    <!-- statastic cards -->
                    <div class="col-md-6">
                      <div class="row match-height">
                         <div class="col-xl-6 col-lg-6 col-12">
                               <div class="card gradient-ibiza-sunset">
                                   <div class="card-body">
                                       <div class="px-3 py-3">
                                           <div class="media">
                                               <div class="media-body white text-left">
                                                   <h3>{{@$total_bookings}}</h3>
                                                   <span>{{trans('labels.total_bookings')}}</span>
                                               </div>
                                               <div class="media-right align-self-center">
                                                   <i class="icon-heart white font-large-2 float-right"></i>
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
                                                   <h3>{{@$total_completed}}</h3>
                                                   <span>{{trans('labels.total_completed')}}</span>
                                               </div>
                                               <div class="media-left align-self-center">
                                                   <i class="icon-check white font-large-2 float-left"></i>
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
                                                   <h3>{{@$total_pending}}</h3>
                                                   <span>{{trans('labels.total_pending')}}</span>
                                               </div>
                                               <div class="media-right align-self-center">
                                                   <i class="icon-graph white font-large-2 float-right"></i>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>

                       </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection

@section('scripts')
<script src="{{ asset('storage/app/public/admin-assets/js/google-chart.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    
    var count = <?php echo $bookings_count; ?>;
    draw_chart(count, 'Month wise bookings');

    $('#year').change(function(){
        var year = $(this).val();
        load_monthwise_data(year, 'Yearly month wise bookings For');
    });
    function load_monthwise_data(year, title)
    {
        var myurl = $("#year").attr('url');
        var temp_title = title + ' '+year+'';
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:myurl,
            method:"GET",
            data:{year:year},
            dataType:"JSON",
            success:function(data){
                draw_chart(data, temp_title);
            }
        });
    }
    function draw_chart(chart_data, chart_main_title){
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            if(chart_data.length <= 1){
                chart_data.push(["No data", 0]);
            }
            var data = google.visualization.arrayToDataTable(chart_data);
            var options = {title: chart_main_title,is3D: true,pieSliceText: 'value-and-percentage',};
            var chart = new google.visualization.LineChart(document.getElementById('piechart_3d'));
            chart.draw(data, options);
        }
    }
</script>
@endsection