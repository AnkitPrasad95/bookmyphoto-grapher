@extends('front.layout.main')
@section('page_title',trans('labels.services'))
@section('content')
<style>
    #detailsPageTopBars {
        margin-top: 119px;
    }

    .fontAwesome4 {
        font-family: fontAwesome !important;
    }

    #detailsPageTopBars .img img {
        border-radius: 50%;
        width: 180px;
        height: 180px;
        object-fit: cover;
    }

    #detailsPageTopBars .content {}

    #detailsPageTopBars .content .location p span {
        font-weight: 300;
    }

    #detailsPageTopBars .content h1 {
        font-size: 50px;
        font-weight: 600;
    }

    #detailsPageTopBars .content .tags {
        width: 80%;
    }

    #detailsPageTopBars .content .tags ul li {
        display: inline-block;
        margin-right: 10px;
        vertical-align: top;
        margin-bottom: 10px;
    }

    #detailsPageTopBars .content .tags ul li a {
        background: #e5e5e5;
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: 400;
        color: #323232;
    }

    #detailsPageContentSection {
        background: #F8F9FA;
    }

    #detailsPageContentSection .nav-tabs .nav-item.show .nav-link,
    #detailsPageContentSection .nav-tabs .nav-link.active {
        border: 0px !important;
    }

    #detailsPageContentSection .nav-tabs .nav-link:focus,
    #detailsPageContentSection .nav-tabs .nav-link:hover {
        background: transparent;
    }

    #detailsPageContentSection .nav-tabs .nav-link {
        position: relative;
        padding: 10px 0;
        margin-right: 30px;
        font-size: 17px;
        font-weight: 300;
    }

    #detailsPageContentSection .nav-tabs .nav-link.active {
        color: #e11f26;
        background: transparent;
    }

    #detailsPageContentSection .nav-tabs .nav-link.active:after {
        content: '';
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 2px;
        background: #e11f26;
        left: 0;
        right: 0;
    }

    #ServiceDetailsPage h2.title {
        font-size: 18px;
        font-weight: 600;
        color: #5a5a5a;
    }

    #ServiceDetailsPage .sidebar .map {
        background: #fff;
        box-shadow: 0 0 3px 1px #ededed;
    }

    #ServiceDetailsPage .sidebar .map iframe {
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

    #detailsPageContentSection .gallery .card {
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(0, 0, 0, 0.24);
        color: #333333;
        border-radius: 2px;
    }

    #detailsPageContentSection .gallery .card-image {
        background: #ffffff;
        display: block;
        padding-top: 70%;
        position: relative;
        width: 100%;
    }

    #detailsPageContentSection .gallery .card-image img {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #ServiceDetailsPage {
        background: #f8f9fa;
    }

    @media (max-width: 991.98px){
        #detailsPageTopBars .img img {
            width: 140px;
            height: 140px;
        }

        #detailsPageTopBars .content .tags {
            width: 100%;
        }

        #detailsPageTopBars .content h1 {
            font-size: 35px;
        }
    }

    @media (max-width: 767.98px){
        #detailsPageTopBars .content {
            text-align:center;
            min-height:unset !important;
        }

        #detailsPageTopBars {
            /* padding-bottom: 0px !important; */
        }

        #detailsPageContentSection .nav-tabs .nav-link {
            margin-right: 14px;
        }

        #ServiceDetailsPage .viewall{
            display:none;
        }
    }
</style>
<?php
// echo "<pre>";

// print_r($providerdata->toArray());


// echo "</pre>";
?>
<section id="detailsPageTopBars" class="bg-dark py-4">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-xl-2 col-lg-3 col-md-3 text-center">
                <div class="img">
                    <img src="{{Helper::image_path($servicedata->service_image)}}" class="img-fluid" alt="" />
                </div>
            </div>

            <div class="col-xl-10 col-lg-9 col-md-9">
                <div class="content">
                    <h1 class="text-white">{{ $servicedata->service_name }}</h1>
                    <div class="location text-white">
                        <p class="text-white mb-3"><i class="fa fa-map-o fontAwesome4 mr-2" aria-hidden="true"></i><span> {{ $city->name }} - {{ Helper::distance($servicedata->latitude, $servicedata->longitude, 28.704060, 77.102493, "K") }} KM</span>
                            <span> | <i class="fas fa-star filled mr-1 position-relative" style="font-size:12px; top: -1px;"></i><span class="d-inline-block average-rating text-white">{{number_format($serviceaverageratting->avg_ratting,1)}}</span></span>
                        </p>
                        <!--<p class="text-white"><i class="fa fa-phone fontAwesome4 mr-3" aria-hidden="true"></i><a href="tel:1234567898" class="text-white">1234567898</a></p>-->
                    </div>
                    <div class="tags">
                        @if(!empty($serviceCategories))
                        <ul>
                            @foreach($serviceCategories as $serviceCategoriesRow)
                            <li><a href="{{URL::to('/home/services/'.$serviceCategoriesRow->slug)}}">{{$serviceCategoriesRow->name}}</a></li>
                           @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="content" id="ServiceDetailsPage">
    <div class="container-fluid">
        @if(!empty($servicedata))
        <div class="row">
            <div class="col-lg-8">
                <section id="detailsPageContentSection">
                    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                        <!--<li class="nav-item">-->
                        <!--    <a class="nav-link active" id="event-tab" data-toggle="tab" href="#event" role="tab" aria-controls="event" aria-selected="true">Event photography & videography</a>-->
                        <!--</li>-->
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="aboutstudio-tab" data-toggle="tab" href="#aboutstudio" role="tab" aria-controls="aboutstudio" aria-selected="false">Studio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gallery-tab" data-toggle="tab" href="#gallery" role="tab" aria-controls="gallery" aria-selected="false">Gallery</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="false">Reviews</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <!--<div class="tab-pane fade show active" id="event" role="tabpanel" aria-labelledby="event-tab">-->
                        <!--    <h2 class="title mb-3">Event photography & videography</h2>-->

                        <!--    <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">-->
                        <!--        <div class="carousel-inner">-->
                        <!--            <div class="carousel-item active">-->
                        <!--                <img class="d-block w-100 h-100 servic-carousel-img" src="{{Helper::image_path($servicedata->service_image)}}" alt="{{trans('labels.slide')}}">-->
                        <!--            </div>-->
                        <!--            @foreach($galleryimages as $gallery)-->
                        <!--            <div class="carousel-item">-->
                        <!--                <img class="d-block w-100 h-100 servic-carousel-img" src="{{Helper::image_path($gallery->gallery_image)}}" alt="{{trans('labels.slide')}}">-->
                        <!--            </div>-->
                        <!--            @endforeach-->
                        <!--        </div>-->
                        <!--        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">-->
                        <!--            <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                        <!--            <span class="sr-only">{{trans('labels.previous')}}</span>-->
                        <!--        </a>-->
                        <!--        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">-->
                        <!--            <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                        <!--            <span class="sr-only">{{trans('labels.next')}}</span>-->
                        <!--        </a>-->
                        <!--    </div>-->

                        <!--</div>-->

                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <h2 class="title">Description</h2>

                            <p>{!! $servicedata->description !!}</p>

                        </div>
                        
                         <div class="tab-pane fade" id="aboutstudio" role="tabpanel" aria-labelledby="description-tab">
                            <h2 class="title">Overview</h2>

                            <p>{!! $providerdata->about !!}</p>
                            
                            <div class="mt-4">
                            <h2 class="title mb-3">Service Locations</h2>
                            <div id="customTags" class="mb-4">
                                <ul>
                                    @foreach($citiesData as $citieData)
                                    <li><a href="#">{{ $citieData->name }}</a></li>
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
                                @if(!empty($serviceCategories) && count($serviceCategories)>0)
                                <ul>
                                    @foreach ($serviceCategories as $sdata)
                                    <li><a href="{{URL::to('/home/services/'.strtolower($sdata->slug))}}">{{$sdata->name}}</a></li>
                                    @endforeach
                                </ul>
                                @endif
                            </div>
                        </div>

                        </div>

                        <div class="tab-pane fade" id="gallery" role="tabpanel" aria-labelledby="gallery-tab">
                            <h2 class="title">Gallery</h2>
                           
                           
                            <div class="row gallery">
                                @foreach($galleryimages as $gallery)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-6">
                                    <div class="card">
                                        <div class="card-image">
                                            <a href="{{Helper::image_path($gallery->gallery_image)}}" data-fancybox="gallery" data-caption="Caption Images 1" alt="{{trans('labels.slide')}}">
                                                <img src="{{Helper::image_path($gallery->gallery_image)}}" alt="{{trans('labels.slide')}}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                           
                            

                        </div>

                        <div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                            <h2 class="title">Reviews</h2>
                            
                            @if(!empty($servicerattingsdata) && count($servicerattingsdata)>0)
                            @foreach($servicerattingsdata as $srdata)
                            <div class="card review-card mb-3">
                                <div class="card-body">
                                    <div class="review-list d-flex flex-nowrap">
                                        <div class="review-img">
                                            <img class="rounded img-fluid" src="{{Helper::image_path($srdata->user_image)}}" alt="">
                                        </div>

                                        <div class="review-info">
                                            <div class="review-user mb-2"><b>{{$srdata->user_name}}</b></div>
                                            <p class="mb-2">{{$srdata->comment}}</p>
                                        </div>

                                        <div class="review-count">
                                            <div class="col"> 
                                                <div class="text-muted">{{Helper::date_format($srdata->date)}}</div>
                                                <div class="rating text-right">
                                                    <i class="fas fa-star filled"></i>
                                                    <span class="d-inline-block average-rating">{{number_format($srdata->ratting,1)}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                          

                        </div>

                    </div>
                </section>

                <!--<div class="service-view">-->
                <!--    <div class="service-header">-->
                <!--        <h1>{{$servicedata->service_name}}</h1>-->
                <!--        <address class="service-location mb-0"><i class="fas fa-location-arrow"></i> {{$providerdata->city_name}} {{ Helper::distance($providerdata->latitude, $providerdata->longitude, 28.704060, 77.102493, "K") }} KM</address>-->

                <!--        <div class="rating text-left">-->
                <!--            <i class="fas fa-star filled"></i><span class="d-inline-block average-rating">{{number_format($serviceaverageratting->avg_ratting,1)}}</span>-->
                <!--        </div>-->
                <!--        <div class="service-cate"><a href="{{URL::to('/home/services/'.$servicedata->category_slug)}}">{{$servicedata->category_name}}</a></div>-->
                <!--    </div>-->
                <!--    <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">-->
                <!--        <div class="carousel-inner">-->
                <!--            <div class="carousel-item active">-->
                <!--                <img class="d-block w-100 h-100 servic-carousel-img" src="{{Helper::image_path($servicedata->service_image)}}" alt="{{trans('labels.slide')}}">-->
                <!--            </div>-->
                <!--            @foreach($galleryimages as $gallery)-->
                <!--            <div class="carousel-item">-->
                <!--                <img class="d-block w-100 h-100 servic-carousel-img" src="{{Helper::image_path($gallery->gallery_image)}}" alt="{{trans('labels.slide')}}">-->
                <!--            </div>-->
                <!--            @endforeach-->
                <!--        </div>-->
                <!--        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">-->
                <!--            <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                <!--            <span class="sr-only">{{trans('labels.previous')}}</span>-->
                <!--        </a>-->
                <!--        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">-->
                <!--            <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                <!--            <span class="sr-only">{{trans('labels.next')}}</span>-->
                <!--        </a>-->
                <!--    </div>-->
                <!--    <div class="service-details mt-2">-->
                <!--        <ul class="nav nav-pills service-tabs" id="pills-tab" role="tablist">-->
                <!--            <li class="nav-item">-->
                <!--                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">{{trans('labels.description')}}</a>-->
                <!--            </li>-->
                <!--            <li class="nav-item">-->
                <!--                <a class="nav-link" id="pills-book-tab" data-toggle="pill" href="#pills-book" role="tab" aria-controls="pills-book" aria-selected="false">{{trans('labels.reviews')}}</a>-->
                <!--            </li>-->
                <!--        </ul>-->
                <!--        <div class="tab-content">-->
                <!--            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">-->
                <!--                <div class="card service-description">-->
                <!--                    <div class="card-body">-->
                <!--                        <p class="mb-0">{{strip_tags($servicedata->description)}}</p>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--            </div>-->
                <!--            <div class="tab-pane fade" id="pills-book" role="tabpanel" aria-labelledby="pills-book-tab">-->
                <!--                @if(!empty($servicerattingsdata) && count($servicerattingsdata)>0)-->
                <!--                <div class="card review-box ratting_scroll">-->
                <!--                    <div class="card-body">-->
                <!--                        @foreach($servicerattingsdata as $srdata)-->
                <!--                        <div class="review-list d-flex flex-nowrap pt-1">-->
                <!--                            <div class="review-img">-->
                <!--                                <img class="rounded-circle" src="{{Helper::image_path($srdata->user_image)}}" alt="{{trans('labels.user_image')}}" />-->
                <!--                                <div class="review-count">-->
                <!--                                    <div class="rating mt-2 text-center">-->
                <!--                                        <i class="fas fa-star filled"></i>-->
                <!--                                        <span class="d-inline-block average-rating">{{number_format($srdata->ratting,1)}}</span>-->
                <!--                                    </div>-->
                <!--                                </div>-->
                <!--                            </div>-->
                <!--                            <div class="review-info">-->
                <!--                                <h5>{{$srdata->user_name}}-->
                <!--                                    <div class="review-date text-muted"> <small>{{Helper::date_format($srdata->date)}}</small></div>-->
                <!--                                </h5>-->
                <!--                                <p class="mb-0">{{$srdata->comment}}</p>-->
                <!--                            </div>-->
                <!--                        </div>-->

                <!--                        @endforeach-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                @else-->
                <!--                <p class="text-center">{{trans('labels.no_data')}}</p>-->
                <!--                @endif-->
                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <div class="row">
                    <div class="col-lg-12">
                    <div class="sidebar-widget widget d-block d-lg-none d-md-none">
                        <div class="service-amount">
                            <span>{{Helper::currency_format($servicedata->price)}} /
                                @if($servicedata->price_type == "Fixed")

                                @if ($servicedata->duration_type == 1)
                                {{$servicedata->duration.trans('labels.minutes')}}
                                @elseif ($servicedata->duration_type == 2)
                                {{$servicedata->duration.trans('labels.hours')}}
                                @elseif ($servicedata->duration_type == 3)
                                {{$servicedata->duration.trans('labels.days')}}
                                @else
                                {{$servicedata->duration.trans('labels.minutes')}}
                                @endif

                                @else
                                {{$servicedata->price_type}}
                                @endif
                            </span>
                        </div>

                        <div class="service-book">
                            <?php 
                            // echo "<pre>";
                            // print_r($providerdata);
                            // print_r($servicedata);
                            // echo "</pre>";
                            ?>
                            @if($providerdata->available_status == 1)
                            <a class="btn btn-primary" href="@if(Auth::user()) {{URL::to('/home/service/continue/'.$servicedata->slug)}} @else {{URL::to('/home/login')}} @endif">{{trans('labels.book_service')}}</a>
                            @elseif($providerdata->available_status == 2)
                            <a class="btn btn-primary">Busy</a>
                            @elseif($providerdata->available_status == 0)
                            <a class="btn btn-primary">Unavailable</a>
                            @endif
                        
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row">
                    @if(!empty($reletedservices) && count($reletedservices)>0)
                    <div class="col-md-6">
                        <div class="heading">
                            <h2>{{trans('labels.related_services')}}</h2>
                            <span>{{trans('labels.explore_services')}}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="viewall">
                            <h4><a href="{{URL::to('/home/services/'.$servicedata->category_slug)}}">{{trans('labels.view_all')}}<i class="fas fa-angle-right"></i></a></h4>
                             <span>{{trans('labels.most_related')}}</span> 
                        </div>
                    </div>
                    @endif
                </div>
                <div class="service-carousel">
                    @if(!empty($reletedservices) && count($reletedservices)>0)
                    <div class="row">
                        <div class="col-12">
                            <div id="popular-service-owl" class="row service_list">
                                @foreach ($reletedservices as $sdata)
                                <div class="item shadow-none col-lg-6 col-md-6 col-sm-12 mx-0 mb-4">

                                    <div class="img">
                                        <img class="img-fluid serv-img popular-services-img" alt="{{trans('labels.service_image')}}" src="{{Helper::image_path($sdata->service_image)}}">
                                        @if($sdata->verified_flag == 1)
                                        <div class="tag-3">
                                            <span><i class="fas fa-light fa-certificate mr-1"></i>Verified</span>
                                        </div>
                                        @endif
                                        <span class="tag"><a href="{{URL::to('/home/services/'.strtolower($sdata->category_name))}}">{{$sdata->category_name}}</a></span>
                                    </div>
                                    <div class="contents bg-white  position-relative">
                                        <div class="d-flex">
                                            <div class="d-flex w-100">
                                                <img src="{{Helper::image_path($sdata->provider_image) }}" class="user img-fluid" alt="" />
                                                <span class="user-name w-100"><a href="{{URL::to('/home/providers-services/'.strtolower($sdata->user_slug))}}">{{$sdata->username}}</a></span>
                                            </div>

                                            <div class="w-25">
                                                <div class="rating mt-1">
                                                    <i class="fas fa-star filled"></i>
                                                    <span class="d-inline-block average-rating">{{number_format($sdata['rattings']->avg('ratting'),1)}}</span>
                                                </div>
                                                <div class="kilomiter-tag"><span><i class="fa fa-map-marker mr-1" aria-hidden="true"></i>{{ Helper::distance($sdata['latitude'], $sdata['longitude'], 28.704060, 77.102493, "K") }} KM</span></div>
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
                        </div>
                    </div>
                    {{--<div class="popular-slider owl-carousel owl-theme owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage">
                                    @foreach($reletedservices as $key => $rsdata)
                                    <div class="owl-item @if($key == 0 || $key == 1) active @endif">
                                        <div class="service-widget">
                                            <div class="service-img">
                                                <a href="{{URL::to('/home/service-details/'.$rsdata->slug)}}">
                    <img class="img-fluid serv-img popular-services-img" alt="Service Image" src="{{Helper::image_path($rsdata->service_image)}}">
                    </a>
                    <div class="item-info">
                        <div class="service-user">
                            <a><img src="{{Helper::image_path($rsdata->provider_image)}}" alt=""></a>
                            <span class="service-price">{{Helper::currency_format($rsdata->price)}}</span>
                        </div>
                        <div class="cate-list">
                            <a class="bg-yellow" href="">{{$rsdata->category_name}}</a>
                        </div>
                    </div>
                </div>
                <div class="service-content">
                    <h3 class="title"><a href="{{URL::to('/home/service-details/'.$rsdata->slug)}}">{{$rsdata->service_name}}</a></h3>

                    <div class="rating">
                        <i class="fas fa-star filled"></i>
                        <span class="d-inline-block average-rating">{{number_format($rsdata['rattings']->avg('ratting'),1)}}</span>
                    </div>

                    <div class="user-info">
                        <div class="row">
                            <span class="col-auto ser-contact"> <strong> {{Helper::currency_format($rsdata->price)}} </strong></span>
                            <span class="col ser-location">
                                @if($rsdata->price_type == "Fixed")
                                <span>
                                    @if ($rsdata->duration_type == 1)
                                    {{$rsdata->duration.trans('labels.minutes')}}
                                    @elseif ($rsdata->duration_type == 2)
                                    {{$rsdata->duration.trans('labels.hours')}}
                                    @elseif ($rsdata->duration_type == 3)
                                    {{$rsdata->duration.trans('labels.days')}}
                                    @else
                                    {{$rsdata->duration.trans('labels.minutes')}}
                                    @endif
                                </span><i class="fas fa-clock ml-1"></i>
                                @else
                                <span>{{$rsdata->price_type}}</span><i class="fas fa-clock ml-1"></i>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
</div>--}}
@else
<p class="text-center" style="display:none">{{trans('labels.no_data')}}</p>
@endif
</div>
</div>
<div class="col-lg-4">
    <div class="sidebar-widget widget d-none d-lg-block d-md-block">
        <div class="service-amount">
            <span>{{Helper::currency_format($servicedata->price)}} /
                @if($servicedata->price_type == "Fixed")

                @if ($servicedata->duration_type == 1)
                {{$servicedata->duration.trans('labels.minutes')}}
                @elseif ($servicedata->duration_type == 2)
                {{$servicedata->duration.trans('labels.hours')}}
                @elseif ($servicedata->duration_type == 3)
                {{$servicedata->duration.trans('labels.days')}}
                @else
                {{$servicedata->duration.trans('labels.minutes')}}
                @endif

                @else
                {{$servicedata->price_type}}
                @endif
            </span>
        </div>

        <div class="service-book">
            
            @if($providerdata->available_status == 1)
             <a class="btn btn-primary" href="@if(Auth::user()) {{URL::to('/home/service/continue/'.$servicedata->slug)}} @else {{URL::to('/home/login')}} @endif">{{trans('labels.book_service')}}</a>
            @elseif($providerdata->available_status == 2)
             <a class="btn btn-primary">Busy</a>
            @elseif($providerdata->available_status == 0)
             <a class="btn btn-primary">Unavailable</a>
            @endif
           
        </div>
    </div>
    

    <div class="card provider-widget clearfix">
        <div class="card-body">
            <a href="{{URL::to('/home/providers-services/'.$providerdata->slug)}}">
            <h5 class="card-title">{{$providerdata->provider_name}}</h5>
             </a>
            <div class="about-author">
                <div class="about-provider-img">
                    <div class="provider-img-wrap">
                        <a href="{{URL::to('/home/providers-services/'.$providerdata->slug)}}">
                            <img class="img-fluid rounded" alt="" src="{{Helper::image_path($providerdata->provider_image)}}">
                        </a>
                    </div>
                </div>
                <div class="provider-details">
                    <p class="last-seen"><i class="fas fa-circle online"></i> {{trans('labels.about')}} </p>
                    <p class="text-muted mb-1">{{Str::limit(strip_tags($providerdata->about),100)}}</p>
                </div>
            </div>
            <hr>
            <div class="provider-info">
                <p class="mb-1"><i class="far fa-envelope"></i> {{$providerdata->email}} </p>
                <!--<p class="mb-0"><i class="fas fa-phone-alt"></i> {{$providerdata->mobile}} </p>-->
            </div>
        </div>
    </div>
    <div class="sidebar mt-4">
        <h2 class="title bg-white p-3 mb-0">Location</h2>
        <div class="map mb-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448193.9510431331!2d76.76356386805334!3d28.64428735048874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1695452165925!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="p-3">
                <h4>{{ $servicedata->service_name }}</h4>
                <p class="mb-0">{{strip_tags($providerdata->address)}}</p>
            </div>
        </div>
    </div>
    <div class="card available-widget">
        <div class="card-body">
            <h5 class="card-title">{{trans('labels.service_availability')}}</h5>
            <hr>
            <ul>
                @if(!empty($timingdata) && count($timingdata)>0)
                @foreach($timingdata as $time)
                @if($time->is_always_close == 1)
                <li><span>{{$time->day}}</span>{{trans('labels.unavailable')}}</li>
                @else
                <li><span>{{$time->day}}</span>{{$time->open_time." - ".$time->close_time}}</li>
                @endif
                @endforeach
                @else

                <li class="text-center">{{trans('labels.no_data')}}</li>
                @endif
            </ul>
        </div>
    </div>
</div>

</div>
@else
<p class="text-center">{{trans('labels.no_data')}}</p>
@endif
</div>
</div>
@endsection