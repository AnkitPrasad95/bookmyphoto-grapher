@extends('front.layout.main')
@section('page_title')
{{@$providerdata->provider_name}} | {{trans('labels.services')}}
@endsection
@section('content')
<style>
    #detailsPageTopBar {
        margin-top: 119px;
    }

    .fontAwesome4 {
        font-family: fontAwesome !important;
    }

    #detailsPageTopBar .img img {
        border-radius: 50%;
        width: 180px;
        height: 180px;
        object-fit: cover;
    }

    #detailsPageTopBar .content {}

    #detailsPageTopBar .content .location p span {
        font-weight: 300;
    }

    #detailsPageTopBar .content h1 {
        font-size: 50px;
        font-weight: 600;
    }

    #detailsPageTopBar .content .tags {
        width: 80%;
    }

    #detailsPageTopBar .content .tags ul li {
        display: inline-block;
        margin-right: 10px;
        vertical-align: top;
        margin-bottom: 10px;
    }

    #detailsPageTopBar .content .tags ul li a {
        background: #e5e5e5;
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: 400;
        color: #323232;
    }

    #detailsPageContentSec {
        background: #F8F9FA;
    }

    #detailsPageContentSec .nav-tabs .nav-item.show .nav-link,
    #detailsPageContentSec .nav-tabs .nav-link.active {
        border: 0px !important;
    }

    #detailsPageContentSec .nav-tabs .nav-link:focus,
    #detailsPageContentSec .nav-tabs .nav-link:hover {
        background: transparent;
    }

    #detailsPageContentSec .nav-tabs .nav-link {
        position: relative;
        padding: 10px 0;
        margin-right: 30px;
        font-size: 17px;
        font-weight: 300;
    }

    #detailsPageContentSec .nav-tabs .nav-link.active {
        color: #e11f26;
        background: transparent;
    }

    #detailsPageContentSec .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #e11f26;
        left: 0;
        right: 0;
    }

    #detailsPageContentSec h2.title {
        font-size: 18px;
        font-weight: 600;
        color: #5a5a5a;
    }

    #detailsPageContentSec .sidebar .map {
        background: #fff;
        box-shadow: 0 0 3px 1px #ededed;
    }

    #detailsPageContentSec .sidebar .map iframe {
        width: 100%;
        height: 250px;
    }

    #customTags ul li {
        display: inline-block;
        margin-right: 10px;
        vertical-align: top;
        margin-bottom: 10px;
    }

    #customTags ul li a {
        background: #e5e5e5;
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: 400;
        color: #323232;
    }

    #detailsPageContentSec .gallery .card {
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.24);
        color: #333333;
        border-radius: 2px;
    }

    #detailsPageContentSec .gallery .card-image {
        background: #ffffff;
        display: block;
        padding-top: 70%;
        position: relative;
        width: 100%;
    }

    #detailsPageContentSec .gallery .card-image img {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 991.98px){
        #detailsPageTopBar .img img {
            width: 140px;
            height: 140px;
        }

        #detailsPageTopBar .content .tags {
            width: 100%;
        }

        #detailsPageTopBar .content h1 {
            font-size: 35px;
        }
    }

    @media (max-width: 767.98px){
        #detailsPageTopBar .content {
            text-align:center;
            min-height:unset !important;
        }

        #detailsPageTopBar {
            /* padding-bottom: 0px !important; */
        }

        #detailsPageContentSec .nav-tabs .nav-link {
            margin-right: 20px;
        }

    }

</style>

<section id="detailsPageTopBar" class="bg-dark py-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xl-2 col-lg-3 col-md-3 text-center">
                <div class="img">
                    <img src="{{URL::to('/storage/app/public/provider/'.$providerdata->provider_image)}}" class="img-fluid" alt="" />
                </div>
            </div>

            <div class="col-xl-10 col-lg-9 col-md-9">
                <div class="content">
                    <h1 class="text-white">{{ $providerdata->provider_name }}</h1>
                    <div class="location text-white">
                        <p class="text-white mb-3"><i class="fa fa-map-o fontAwesome4 mr-2" aria-hidden="true"></i><span>{{ $city->name }} - {{ Helper::distance($providerdata->latitude, $providerdata->longitude, 28.704060, 77.102493, "K") }} KM</span>
                        <span> | <i class="fas fa-star filled mr-1 position-relative" style="font-size:12px; top: -1px;"></i><span class="d-inline-block average-rating text-white">{{number_format($provideraverageratting->avg_ratting,1)}}</span></span>
                        </p>
                        <!--<p class="text-white"><i class="fa fa-phone fontAwesome4 mr-3" aria-hidden="true"></i><a href="tel:{{$providerdata->mobile}}" class="text-white">{{$providerdata->mobile}}</a></p>-->
                    </div>
                    <div class="tags">
                         @if(!empty($servicedata) && count($servicedata)>0)
                        <ul>
                             @foreach ($servicedata as $sdata)
                            <li><a href="{{URL::to('/home/providers-services/'.strtolower($sdata->user_slug))}}">{{$sdata->category_name}}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="detailsPageContentSec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <ul class="nav nav-tabs border-0 pt-4" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false"> Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="false"> Reviews</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <h2 class="title">Overview</h2>
                        <p> {!! $providerdata->about !!}  </p>
                        

                        <div class="mt-4">
                            <h2 class="title mb-3">Service Locations</h2>
                            <div id="customTags" class="mb-4">
                                <ul>
                                    @foreach($citiesData as $citieData)
                                    <li><a href="#">{{ $citieData }}</a></li>
                                    @endforeach
                                   
                                </ul>
                            </div>

                            <!--<h2 class="title mb-3">Languages Known</h2>-->
                            <!--<div id="customTags" class="mb-4">-->
                            <!--    <ul>-->
                            <!--        <li><a href="#">Tamil</a></li>-->
                            <!--        <li><a href="#">Hindi</a></li>-->
                            <!--        <li><a href="#">English</a></li>-->
                            <!--        <li><a href="#">Telugu</a></li>-->
                            <!--        <li><a href="#">Malayalam</a></li>-->
                            <!--    </ul>-->
                            <!--</div>-->

                            <h2 class="title mb-3">Service Categories</h2>
                            <div id="customTags" class="mb-4">
                                @if(!empty($servicedata) && count($servicedata)>0)
                                <ul>
                                    @foreach ($servicedata as $sdata)
                                    <li><a href="{{URL::to('/home/services/'.strtolower($sdata->category_name))}}">{{$sdata->category_name}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <h2 class="title">Services</h2>
                        <?php 
                        // echo "</pre>";
                        // print_r($servicedata->toArray());
                        // echo "</pre>";
                        ?>
                        @if(!empty($servicedata) && count($servicedata)>0)

                        <div id="popular-service-owl" class="row service_list px-0">
                            @foreach ($servicedata as $sdata)
                            <div class="item shadow-none col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mx-0 mb-4">

                                <div class="img">
                                    <img class="img-fluid serv-img popular-services-img" alt="{{trans('labels.service_image')}}" src="{{Helper::image_path($sdata->service_image)}}">
                                   
                                    
                                    @if($sdata->verified_flag == 1)
                                     <div class="tag-3">
                                        <span><i class="fas fa-light fa-certificate mr-1"></i>Verified</span>
                                    </div>
                                    @endif
                                   
                                    <span class="tag"><a href="{{URL::to('/home/services/'.strtolower($sdata->slug))}}">{{$sdata->category_name}}</a></span>
                                </div>
                                <div class="contents bg-white">
                                    <div class="d-flex">
                                        <div class="d-flex w-100">
                                            <img src="{{Helper::image_path($sdata->user_image) }}" class="user img-fluid" alt="" />
                                            <span class="user-name"><a href="{{URL::to('/home/providers-services/'.strtolower($sdata->user_slug))}}">{{$sdata->username}}</a></span>
                                        </div>

                                        <div class="rating w-25 mt-1">
                                            <i class="fas fa-star filled"></i>
                                            <span class="d-inline-block average-rating">{{number_format($sdata['rattings']->avg('ratting'),1)}}</span>
                                        </div>
                                    </div>


                                    <h3 class="service-name w-100">{{$sdata->service_name}}</h3>


                                    <p class="">{{Str::limit(strip_tags($sdata->description),100)}}</p>

                                    <div class="amount d-flex">
                                        <span class="span align-self-center">Starting at</span>
                                        <span class="price ">{{ Helper::currency_format($sdata->price) }} /

                                            @if($sdata->price_type == "Fixed")

                                            @if ($sdata->duration_type == 1)
                                            {{$sdata->duration.trans('labels.minutes')}}
                                            @elseif ($sdata->duration_type == 2)
                                            {{$sdata->duration.trans('labels.hours')}}
                                            @elseif ($sdata->duration_type == 3)
                                            {{$sdata->duration.trans('labels.days')}}
                                            @else
                                            {{$sdata->duration.trans('labels.minutes')}}
                                            @endif

                                            @else
                                            {{$sdata->price_type}}
                                            @endif
                                        </span>
                                    </div>
                                    <a href="{{URL::to('/home/service-details/'.$sdata->slug)}}" class="btn">Request Now</a>
                                </div>


                            </div>

                            @endforeach
                        </div>

                        @else
                        <p class="text-center">{{trans('labels.no_data')}}</p>
                        @endif

                    </div>

                    <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                        <h2 class="title">Gallery</h2>

                        <div class="row gallery">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-image">
                                        <a href="https://bit.ly/34MdBRc" data-fancybox="gallery" data-caption="Caption Images 1">
                                            <img src="https://bit.ly/34MdBRc" alt="Image Gallery">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-image">
                                        <a href="https://bit.ly/2Nv9zHh" data-fancybox="gallery" data-caption="Caption Images 1">
                                            <img src="https://bit.ly/2Nv9zHh" alt="Image Gallery">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-image">
                                        <a href="https://bit.ly/2q0iuay" data-fancybox="gallery" data-caption="Caption Images 1">
                                            <img src="https://bit.ly/2q0iuay" alt="Image Gallery">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-image">
                                        <a href="https://bit.ly/34MdBRc" data-fancybox="gallery" data-caption="Caption Images 1">
                                            <img src="https://bit.ly/34MdBRc" alt="Image Gallery">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-image">
                                        <a href="https://bit.ly/2Nv9zHh" data-fancybox="gallery" data-caption="Caption Images 1">
                                            <img src="https://bit.ly/2Nv9zHh" alt="Image Gallery">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                <div class="card">
                                    <div class="card-image">
                                        <a href="https://bit.ly/2q0iuay" data-fancybox="gallery" data-caption="Caption Images 1">
                                            <img src="https://bit.ly/2q0iuay" alt="Image Gallery">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                        <h2 class="title">Reviews</h2>
                        @foreach($providerrattingsdata as $providerrattingsdataRow)
                        <div class="card review-card mb-3">
                            <div class="card-body">
                                <div class="review-list d-flex flex-nowrap">
                                    <div class="review-img">
                                        <img class="rounded img-fluid" src="{{URL::to('/storage/app/public/profile/'.$providerrattingsdataRow->user_image)}}" alt="">
                                    </div>

                                    <div class="review-info">
                                        <div class="review-user mb-2"><b>{{ $providerrattingsdataRow->user_name }}</b></div>
                                        <p class="mb-2">{{ $providerrattingsdataRow->comment }}</p>
                                    </div>

                                    <div class="review-count">
                                        <div class="col">
                                            <div class="text-muted">{{ $providerrattingsdataRow->date }}</div>
                                            <div class="rating text-right">
                                                <i class="fas fa-star filled"></i>
                                                <span class="d-inline-block average-rating">{{ $providerrattingsdataRow->ratting.'.0' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                      

                    </div>

                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar mt-5">
                    <h2 class="title mb-3">Location</h2>
                    <div class="map mb-5">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448193.9510431331!2d76.76356386805334!3d28.64428735048874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1695452165925!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <div class="p-3">
                            <h4>{{ $providerdata->provider_name }}</h4>
                            <p class="mb-0">{{strip_tags($providerdata->address)}}</p>
                        </div>
                    </div>

                    <div class="card available-widget">
                        <div class="card-body">
                            <h5 class="card-title">Service Availability</h5>
                            <hr>
                             @if(!empty($timingdata))
                            <ul>
                                 @foreach ($timingdata as $tdata)
                                <li><span>{{$tdata->day}}</span>{{$tdata->open_time}} - {{$tdata->close_time}}</li>
                                @endforeach
                               
                            </ul>
                             @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
<script>
    $('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "slideShow",
            "thumbs",
            "zoom",
            "fullScreen",
            "share",
            "close"
        ],
        loop: false,
        protect: true
    });
</script>