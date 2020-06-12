@extends('master')

@section('title','Home')

@section('content')

        <!-- BEGIN: Subheader -->

        <div class="m-subheader ">

            <div class="d-flex align-items-center">

                <div class="mr-auto">

                    <h3 class="m-subheader__title ">Dashboard</h3>

                </div>

                <div>

                    <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">

                        <span class="m-subheader__daterange-label">

                            <span class="m-subheader__daterange-title"></span>

                            <span class="m-subheader__daterange-date m--font-brand"></span>

                        </span>

                        <a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">

                            <i class="la la-angle-down"></i>

                        </a>

                    </span>

                </div>

            </div>

        </div>



        <!-- END: Subheader -->

        <div class="m-content">

            <!--Begin::Section-->

            <div class="m-portlet">

                <div class="m-portlet__body  m-portlet__body--no-padding">

                    <div class="row m-row--no-padding m-row--col-separator-xl">

                        <div class="col-xl-4">



                            <!--begin:: Widgets/Stats2-1 -->

                            <div class="m-widget1">

                                <div class="m-widget1__item">

                                    <div class="row m-row--no-padding align-items-center">

                                        <div class="col">

                                            <h3 class="m-widget1__title">Member Profit</h3>

                                            <span class="m-widget1__desc">Awerage Weekly Profit</span>

                                        </div>

                                        <div class="col m--align-right">

                                            <span class="m-widget1__number m--font-brand">+$17,800</span>

                                        </div>

                                    </div>

                                </div>

                                <div class="m-widget1__item">

                                    <div class="row m-row--no-padding align-items-center">

                                        <div class="col">

                                            <h3 class="m-widget1__title">Orders</h3>

                                            <span class="m-widget1__desc">Weekly Customer Orders</span>

                                        </div>

                                        <div class="col m--align-right">

                                            <span class="m-widget1__number m--font-danger">+1,800</span>

                                        </div>

                                    </div>

                                </div>

                                <div class="m-widget1__item">

                                    <div class="row m-row--no-padding align-items-center">

                                        <div class="col">

                                            <h3 class="m-widget1__title">Issue Reports</h3>

                                            <span class="m-widget1__desc">System bugs and issues</span>

                                        </div>

                                        <div class="col m--align-right">

                                            <span class="m-widget1__number m--font-success">-27,49%</span>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <!--end:: Widgets/Stats2-1 -->

                        </div>

                        <div class="col-xl-4">



                            <!--begin:: Widgets/Daily Sales-->

                            <div class="m-widget14">

                                <div class="m-widget14__header m--margin-bottom-30">

                                    <h3 class="m-widget14__title">

                                        Daily Sales

                                    </h3>

                                    <span class="m-widget14__desc">

													Check out each collumn for more details

												</span>

                                </div>

                                <div class="m-widget14__chart" style="height:120px;">

                                    <canvas id="m_chart_daily_sales"></canvas>

                                </div>

                            </div>



                            <!--end:: Widgets/Daily Sales-->

                        </div>

                        <div class="col-xl-4">



                            <!--begin:: Widgets/Profit Share-->

                            <div class="m-widget14">

                                <div class="m-widget14__header">

                                    <h3 class="m-widget14__title">

                                        Profit Share

                                    </h3>

                                    <span class="m-widget14__desc">

                                        Profit Share between customers

                                    </span>

                                </div>

                                <div class="row  align-items-center">

                                    <div class="col">

                                        <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">

                                            <div class="m-widget14__stat">45</div>

                                        </div>

                                    </div>

                                    <div class="col">

                                        <div class="m-widget14__legends">

                                            <div class="m-widget14__legend">

                                                <span class="m-widget14__legend-bullet m--bg-accent"></span>

                                                <span class="m-widget14__legend-text">37% Sport Tickets</span>

                                            </div>

                                            <div class="m-widget14__legend">

                                                <span class="m-widget14__legend-bullet m--bg-warning"></span>

                                                <span class="m-widget14__legend-text">47% Business Events</span>

                                            </div>

                                            <div class="m-widget14__legend">

                                                <span class="m-widget14__legend-bullet m--bg-brand"></span>

                                                <span class="m-widget14__legend-text">19% Others</span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <!--end:: Widgets/Profit Share-->

                        </div>

                    </div>

                </div>

            </div>



            <!--End::Section-->





            <div class="m-portlet">

                <div class="m-portlet__body  m-portlet__body--no-padding">

                    <div class="row m-row--no-padding m-row--col-separator-xl">

                        <div class="col-xl-4">



                            <!--begin:: Widgets/Stats2-1 -->

                            <div class="m-widget1">

                                <div class="m-widget1__item">

                                    <div class="row m-row--no-padding align-items-center">

                                        <div class="col">

                                            <h3 class="m-widget1__title">Member Profit</h3>

                                            <span class="m-widget1__desc">Awerage Weekly Profit</span>

                                        </div>

                                        <div class="col m--align-right">

                                            <span class="m-widget1__number m--font-brand">+$17,800</span>

                                        </div>

                                    </div>

                                </div>

                                <div class="m-widget1__item">

                                    <div class="row m-row--no-padding align-items-center">

                                        <div class="col">

                                            <h3 class="m-widget1__title">Orders</h3>

                                            <span class="m-widget1__desc">Weekly Customer Orders</span>

                                        </div>

                                        <div class="col m--align-right">

                                            <span class="m-widget1__number m--font-danger">+1,800</span>

                                        </div>

                                    </div>

                                </div>

                                <div class="m-widget1__item">

                                    <div class="row m-row--no-padding align-items-center">

                                        <div class="col">

                                            <h3 class="m-widget1__title">Issue Reports</h3>

                                            <span class="m-widget1__desc">System bugs and issues</span>

                                        </div>

                                        <div class="col m--align-right">

                                            <span class="m-widget1__number m--font-success">-27,49%</span>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <!--end:: Widgets/Stats2-1 -->

                        </div>

                        <div class="col-xl-4">



                            <!--begin:: Widgets/Daily Sales-->

                            <div class="m-widget14">

                                <div class="m-widget14__header m--margin-bottom-30">

                                    <h3 class="m-widget14__title">

                                        Daily Sales

                                    </h3>

                                    <span class="m-widget14__desc">

													Check out each collumn for more details

												</span>

                                </div>

                                <div class="m-widget14__chart" style="height:120px;">

                                    <canvas id="m_chart_daily_sales"></canvas>

                                </div>

                            </div>



                            <!--end:: Widgets/Daily Sales-->

                        </div>

                        <div class="col-xl-4">



                            <!--begin:: Widgets/Profit Share-->

                            <div class="m-widget14">

                                <div class="m-widget14__header">

                                    <h3 class="m-widget14__title">

                                        Profit Share

                                    </h3>

                                    <span class="m-widget14__desc">

                                        Profit Share between customers

                                    </span>

                                </div>

                                <div class="row  align-items-center">

                                    <div class="col">

                                        <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">

                                            <div class="m-widget14__stat">45</div>

                                        </div>

                                    </div>

                                    <div class="col">

                                        <div class="m-widget14__legends">

                                            <div class="m-widget14__legend">

                                                <span class="m-widget14__legend-bullet m--bg-accent"></span>

                                                <span class="m-widget14__legend-text">37% Sport Tickets</span>

                                            </div>

                                            <div class="m-widget14__legend">

                                                <span class="m-widget14__legend-bullet m--bg-warning"></span>

                                                <span class="m-widget14__legend-text">47% Business Events</span>

                                            </div>

                                            <div class="m-widget14__legend">

                                                <span class="m-widget14__legend-bullet m--bg-brand"></span>

                                                <span class="m-widget14__legend-text">19% Others</span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                            <!--end:: Widgets/Profit Share-->

                        </div>

                    </div>

                </div>

            </div>





            <br><br>

            <!--Begin::Section-->

            <div class="row">

                    <div class="col-xl-8">



                    <!--begin:: Widgets/Best Sellers-->

                    <div class="m-portlet m-portlet--full-height ">

                        <div class="m-portlet__head">

                            <div class="m-portlet__head-caption">

                                <div class="m-portlet__head-title">

                                    <h3 class="m-portlet__head-text">

                                        Best Sellers

                                    </h3>

                                </div>

                            </div>

                            <div class="m-portlet__head-tools">

                                <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">

                                    <li class="nav-item m-tabs__item">

                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget5_tab1_content" role="tab">

                                            Last Month

                                        </a>

                                    </li>

                                    <li class="nav-item m-tabs__item">

                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget5_tab2_content" role="tab">

                                            last Year

                                        </a>

                                    </li>

                                    <li class="nav-item m-tabs__item">

                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget5_tab3_content" role="tab">

                                            All time

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="m-portlet__body">



                            <!--begin::Content-->

                            <div class="tab-content">

                                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">



                                    <!--begin::m-widget5-->

                                    <div class="m-widget5">

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product6.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Great Logo Designn

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            author:

                                                                        </span>

                                                        <span class="m-widget5__info-author-name">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">19,200</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">1046</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product10.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Branding Mockup

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">24,583</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">3809</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product11.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Awesome Mobile App

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">10,054</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">1103</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                    <!--end::m-widget5-->

                                </div>

                                <div class="tab-pane" id="m_widget5_tab2_content" aria-expanded="false">



                                    <!--begin::m-widget5-->

                                    <div class="m-widget5">

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product11.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Branding Mockup

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">24,583</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">3809</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product6.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Great Logo Designn

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">19,200</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">1046</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product10.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Awesome Mobile App

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">10,054</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">1103</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                    <!--end::m-widget5-->

                                </div>

                                <div class="tab-pane" id="m_widget5_tab3_content" aria-expanded="false">



                                    <!--begin::m-widget5-->

                                    <div class="m-widget5">

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product10.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Branding Mockup

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">10.054</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">1103</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product11.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Great Logo Designn

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">24,583</span><br>

                                                    <span class="m-widget5__sales">sales</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">3809</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="m-widget5__item">

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__pic">

                                                    <img class="m-widget7__img" src="assets/app/media/img//products/product6.jpg" alt="">

                                                </div>

                                                <div class="m-widget5__section">

                                                    <h4 class="m-widget5__title">

                                                        Awesome Mobile App

                                                    </h4>

                                                    <span class="m-widget5__desc">

                                                                        Make Metronic Great Again.Lorem Ipsum Amet

                                                                    </span>

                                                    <div class="m-widget5__info">

                                                                        <span class="m-widget5__author">

                                                                            Author:

                                                                        </span>

                                                        <span class="m-widget5__info-author m--font-info">

                                                                            Fly themes

                                                                        </span>

                                                        <span class="m-widget5__info-label">

                                                                            Released:

                                                                        </span>

                                                        <span class="m-widget5__info-date m--font-info">

                                                                            23.08.17

                                                                        </span>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="m-widget5__content">

                                                <div class="m-widget5__stats1">

                                                    <span class="m-widget5__number">19,200</span><br>

                                                    <span class="m-widget5__sales">1046</span>

                                                </div>

                                                <div class="m-widget5__stats2">

                                                    <span class="m-widget5__number">1046</span><br>

                                                    <span class="m-widget5__votes">votes</span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                    <!--end::m-widget5-->

                                </div>

                            </div>



                            <!--end::Content-->

                        </div>

                    </div>



                    <!--end:: Widgets/Best Sellers-->

                </div>

                <div class="col-xl-4">

                    <!--begin:: Widgets/Audit Log-->

                    <div class="m-portlet m-portlet--full-height ">

                        <div class="m-portlet__head">

                            <div class="m-portlet__head-caption">

                                <div class="m-portlet__head-title">

                                    <h3 class="m-portlet__head-text">

                                        Audit Log

                                    </h3>

                                </div>

                            </div>

                            <div class="m-portlet__head-tools">

                                <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">

                                    <li class="nav-item m-tabs__item">

                                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_widget4_tab1_content" role="tab">

                                            Today

                                        </a>

                                    </li>

                                    <li class="nav-item m-tabs__item">

                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget4_tab2_content" role="tab">

                                            Week

                                        </a>

                                    </li>

                                    <li class="nav-item m-tabs__item">

                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_widget4_tab3_content" role="tab">

                                            Month

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div>

                        <div class="m-portlet__body">

                            <div class="tab-content">

                                <div class="tab-pane active" id="m_widget4_tab1_content">

                                    <div class="m-scrollable" data-scrollable="true" data-height="400" style="height: 400px; overflow: hidden;">

                                        <div class="m-list-timeline m-list-timeline--skin-light">

                                            <div class="m-list-timeline__items">

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>

                                                    <span class="m-list-timeline__text">12 new users registered</span>

                                                    <span class="m-list-timeline__time">Just now</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>

                                                    <span class="m-list-timeline__text">System shutdown <span class="m-badge m-badge--success m-badge--wide">pending</span></span>

                                                    <span class="m-list-timeline__time">14 mins</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>

                                                    <span class="m-list-timeline__text">New invoice received</span>

                                                    <span class="m-list-timeline__time">20 mins</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>

                                                    <span class="m-list-timeline__text">DB overloaded 80% <span class="m-badge m-badge--info m-badge--wide">settled</span></span>

                                                    <span class="m-list-timeline__time">1 hr</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>

                                                    <span class="m-list-timeline__text">System error - <a href="#" class="m-link">Check</a></span>

                                                    <span class="m-list-timeline__time">2 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>

                                                    <span class="m-list-timeline__text">Production server down</span>

                                                    <span class="m-list-timeline__time">3 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>

                                                    <span class="m-list-timeline__text">Production server up</span>

                                                    <span class="m-list-timeline__time">5 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>

                                                    <span href="javascript:void(0)" class="m-list-timeline__text">New order received <span class="m-badge m-badge--danger m-badge--wide">urgent</span></span>

                                                    <span class="m-list-timeline__time">7 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>

                                                    <span class="m-list-timeline__text">12 new users registered</span>

                                                    <span class="m-list-timeline__time">Just now</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>

                                                    <span class="m-list-timeline__text">System shutdown <span class="m-badge m-badge--success m-badge--wide">pending</span></span>

                                                    <span class="m-list-timeline__time">14 mins</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>

                                                    <span class="m-list-timeline__text">New invoice received</span>

                                                    <span class="m-list-timeline__time">20 mins</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>

                                                    <span class="m-list-timeline__text">DB overloaded 80% <span class="m-badge m-badge--info m-badge--wide">settled</span></span>

                                                    <span class="m-list-timeline__time">1 hr</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>

                                                    <span class="m-list-timeline__text">New invoice received</span>

                                                    <span class="m-list-timeline__time">20 mins</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>

                                                    <span class="m-list-timeline__text">DB overloaded 80% <span class="m-badge m-badge--info m-badge--wide">settled</span></span>

                                                    <span class="m-list-timeline__time">1 hr</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>

                                                    <span class="m-list-timeline__text">System error - <a href="#" class="m-link">Check</a></span>

                                                    <span class="m-list-timeline__time">2 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>

                                                    <span class="m-list-timeline__text">Production server down</span>

                                                    <span class="m-list-timeline__time">3 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>

                                                    <span class="m-list-timeline__text">Production server up</span>

                                                    <span class="m-list-timeline__time">5 hrs</span>

                                                </div>

                                                <div class="m-list-timeline__item">

                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>

                                                    <span href="javascript:void(0)" class="m-list-timeline__text">New order received <span class="m-badge m-badge--danger m-badge--wide">urgent</span></span>

                                                    <span class="m-list-timeline__time">7 hrs</span>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="tab-pane" id="m_widget4_tab2_content">

                                </div>

                                <div class="tab-pane" id="m_widget4_tab3_content">

                                </div>

                            </div>

                        </div>

                    </div>



                    <!--end:: Widgets/Audit Log-->

                </div>

            </div>

            <!--End::Section-->

        </div>

@stop
