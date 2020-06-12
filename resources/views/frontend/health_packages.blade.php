@include('frontend.header')

<section class="healthCheckup">
    <div class="single-page-header">
        <div class="container">
            <div class="page-title">
                <h3>Affordable full body Health Checkup</h3>
                <h5>Up to 30% off on checkup</h5>
            </div>
            <div class="page-header__icon">
                <img src="{{ asset('assets/frontend/images/page-header/health-package.png') }}" alt="health-package">
            </div>
        </div>
    </div>
    <div class="container-fluid health-checkup-bg">
        <div class="container">
            <h1>Affordable full body health checkups</h1>
            <div class="row">
                @foreach($health_package as $health_data)
                    <div class="col-lg-4 col-md-4 col-xs-12">
                        <div class="checkupContent">
                            <img class="pkg-header-img" src="{!! asset('assets/frontend/images/titleBar.png') !!}">
                            <div class="checkupTitle">
                                <h3>{{substr($health_data->package_name, 0, 50)}}</h3>
                                <h4>Ideal for person aged: {{$health_data->age_group}}</h4>
                            </div>
                            <div class="checkupContentBox">
                                <h3>Includes {{$health_data->no_of_tests}} Tests</h3>
                                <h4>{{substr($health_data->description, 0, 100)}}...</h4>
                                <div class="price-block">
                                    <hr>
                                    <div class="price-block__discount">
                                        <h3>{{$health_data->discount}}% Off</h3>
                                    </div>
                                    <div class="price-block__price">
                                        {{--<h4><b>{{$health_data->price}}/-</b></h4>--}}
                                        <h4><b>{{$health_data->price-($health_data->price*$health_data->discount)/100}}
                                                /-</b></h4>
                                        <h4><strike>{{$health_data->price}}/-</strike></h4>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="checkupBlankBox">

                            </div>--}}
                            <div class="checkupPriceBox">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="priceBox">
                                                <a href="{{url('package_details'.'/'.$health_data->id)}}"
                                                   class="package-details-btn">Details</a>
                                            </div>
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
    <div class="container">
        <div class="row health-checkup">
            <div class="comments-section">
                <div class="comment-note">
                    <h5>Reliable and Trustworthy</h5>
                    <p>All checkup will perform by well equiped and renowned Diagnostic labs and will examined by
                        qualified and experience professionals.</p>
                    <h5>Simple and Convenient</h5>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                        laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
                        voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                </div>
                <div class="comment-block">
                    <div class="comment-block__content">
                        <i class="fas fa-quote-right"></i>
                        <p>"Very professional Phlebo. Excellent job in collecting the sample. No pain at all. Got my
                            report also within 24 hours :)"</p>
                        <div class="comment-profile">
                            <span>Rashid J Siddique</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.footer')
