@include('frontend.header')


<!-- ###########################
    ASK A DOCTOR SECTION
########################### -->


<section class="askDoctor package-details">
    <div class="container-fluid">

        <div class="row package-header">
            <div class="col-md-12">
                <h3>{{$health_package->package_name}}</h3>

                <h4>(Ideal for person aged {{$health_package->age_group}})</h4>
            </div>
        </div>
        <div class="container">
            @if(session()->has('successMsg'))
                <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <span>{{ session()->get('successMsg') }}</span>
                </div>
            @endif
            @if(session()->has('errorMsg'))
                <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <span>{{ session()->get('errorMsg') }}</span>
                </div>
            @endif
            <div class="booking-content package-details-content">
                <div class="row">
                    <div class="col-md-12 package-description">
                        <h4>Why book this Checkup?</h4>
                        <p>This checkup tests for Intellectual Abnormality, Thyroid Disorder, Liver Disorder, Diabetes Mellitus and Kidney Disorder. It also evaluates your Heart, Thyroid, Liver and Kidney.  </p>
                    </div>
                    <div class="col-md-5">
                        <div class="products-info">
                            {{--@if(isset($health_package->photo)!="")
                               <img src="{{url('/uploads/health_package_photo/'.$health_package->photo)}}">
                            @else
                               <img src="{!! asset('assets/frontend/images/package-details.png') !!}">
                            @endif--}}
                            <br>

                            <table>
                                <tbody>
                                <tr>
                                    <td>{{$health_package->no_of_tests}} Tests</td>
                                    <td>BDT {{$health_package->price}}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td> {{$health_package->discount}} %</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>BDT {{$health_package->price - (($health_package->price*$health_package->discount)/100)}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <a href="{{url('package_booking'.'/'.$health_package->id)}}">Book</a>

                            <h5>*Book this checkup and earn BDcareCash TK 50</h5>
                        </div>
                    </div>

                    <div class="col-md-7" style="background: #f6f6f6;">
                        <div class="package-summary">
                            <h4>This package includes {{$health_package->no_of_tests}} tests</h4>

                            <ul>
                                <?php
                                $eact_test = explode(',',$health_package->description);
                                ?>

                                @php
                                    $HTML = '';
                                    $more_btn = '';
                                @endphp

                                @foreach($eact_test as $key => $row_data)
                                    @if($key<3)
                                        <li><i class="fas fa-check"></i>{{$row_data}}</li>
                                    @else
                                        <?php $HTML .= '<li><i class="fas fa-check"></i>'.$row_data.'</li>'; ?>
                                    @endif

                                @endforeach

                                {{--{!! $more_btn !!}--}}

                                <div class="collapse" id="moreTest">
                                    {!! $HTML !!}
                                </div>
                                    @if(count($eact_test)>3)
                                        <div class="more-test">
                                            <a data-toggle="collapse" href="#moreTest" role="button" aria-expanded="false" aria-controls="moreTest" onclick="change_text();">
                                                <span id="more_less">More</span><span class="fas fa-ellipsis-h"></span>
                                            </a>
                                        </div>
                                    @endif
                            </ul>

                            <h5>What preparation is needed for this Checkup?</h5>
                            <p>Fasting is required for about 10 -12 hours before the sample collection. Consumption of water is permitted.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--New design ( client requirement )--}}

        {{--Others packages start--}}
        <div class="container others-packages healthCheckup"  id="healthCheckup">
            <h2><a href="{{url('/more-packages')}}"><span style="color: #fff;">Related Packages</span></a></h2>

            <div class="row">
                @foreach($related_health_package as $health_data)
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="checkupContent">
                        <img class="pkg-header-img"  src="{!! asset('assets/frontend/images/titleBar.png') !!}">
                        <div class="checkupTitle">
                            <h3>{{substr($health_data->package_name, 0, 30)}}</h3>
                            <h4>Ideal for person aged: {{$health_data->age_group}}</h4>
                        </div>
                        <div class="checkupContentBox">
                            <h3>Includes {{$health_data->no_of_tests}} Tests</h3>
                            <h4>{{$health_data->description}}</h4>
                            <div class="price-block">
                                <hr>
                                <div class="price-block__discount">
                                    <h3>{{$health_data->discount}}% Off</h3>
                                </div>
                                <div class="price-block__price">
                                    <h4><b>{{$health_data->price-($health_data->price*$health_data->discount)/100}}/-</b></h4>
                                    <h4><strike>{{($health_data->price)}}/-</strike></h4>
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
                                            <a href="{{url('package_details'.'/'.$health_data->id)}}" class="package-details-btn">Details</a>
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
        {{--Others packages end--}}

        <div class="container">
            <div class="row health-checkup">
                <div class="comments-section">
                    <div class="comment-note">
                        <h5>Reliable and Trustworthy</h5>
                        <p>All checkup will perform by well equiped and renowned Diagnostic labs and will examined by qualified and experience professionals.</p>
                        <h5>Simple and Convenient</h5>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                    <div class="comment-block">
                        <div class="comment-block__content">
                            <i class="fas fa-quote-right"></i>
                            <p>"Very professional Phlebo. Excellent job in collecting the sample. No pain at all. Got my report also within 24 hours :)"</p>
                            <div class="comment-profile">
{{--                                <img src="">--}}
                                <span>Rashid J Siddique</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('frontend.footer')


<script>

    $(document).ready(function() {

        $(".selectSpeciality").click(function(){
            $(".specialityPanel").slideToggle('slow', function() {

            });
        });

    });

    function change_text() {
        var val = document.getElementById("more_less");
        var value = val.textContent;

        if(value == "More")
        {
            document.getElementById("more_less").innerHTML = "Less";
        }
        else if(value == "Less")
        {
            document.getElementById("more_less").innerHTML = "More";
        }
    }
</script>
