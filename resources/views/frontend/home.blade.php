@include('frontend.header')

<script>

    function get_hospital()
    {
        get_hospital_list();

        var type = $('#type').val();

        if(type == 'H')
        {
            //$("#doctor_name").setAttribute('type', 'hidden');

            var y = document.getElementById("doctor_name");
            y.type= "hidden";

            $('.wrapper').fadeOut();

            $("#hospital_names").css('display', 'block');
            $("#submit_button").css('display', 'block');
        }
        else if(type == 'S')
        {
            document.getElementById('doctor_name').placeholder='Enter Speciality Name';

            var y = document.getElementById("doctor_name");
            y.type= "block";

            $("#hospital_names").css('display', 'none');
            $("#submit_button").css('display', 'none');
        }
    }

    $(document).ready(function(){

        $('#doctor_name').keyup(function(){
            var query = $(this).val();

            var city = $('#city').val();
            var area = $('#area').val();
            var type = $('#type').val();

            if(city == '' || area == '' || type == '')
            {
                alert('Please Select City, Area & Type of Search First');
                return;
            }

            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('autocomplete.fetch') }}",
                    method:"POST",
                    data:{query:query, _token:_token, city:city, area:area, type:type},
                    success:function(data){
                        $('#DoctorList').fadeIn();
                        $('#DoctorList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function(){
            //$('#doctor_name').val($(this).text());
            $('#doctorList').fadeOut();
        });

    });

    function change_placeholder(type) {



    }
</script>
<!-- ###########################
    BANNER SECTION
########################### -->

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="banner">
    <div class="container">

        <form action="{{ url('search-data') }}" method="GET" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="bannerContent">
                    <h1><b>{{ __('messages.Your_health_partner') }} </b></h1>
                    <h3>{{ __('messages.Find_and_Book_Doctor_Hospital') }} </h3>
                    <div class="row">

                        <div class="col-lg-2 col-md-2 col-xs-12 no-padding">
                            <div class="bannerSearch">
                                <div class="searchBox">
                                    <ul>
                                        <li><i class="fas fa-building"></i></li>
                                        <li class="ivl_list" style="width: 97% !important;margin-top: 12px">

                                            <select class="form-control select2 search" name="city" id="city" onchange="get_areas()">

                                                <option value="">Select City</option>

                                                <?php foreach ($city as $city_row ) {?>

                                                <option value="<?=$city_row->id;?>"><?=$city_row->city_name;?></option>
                                                <?php }?>
                                            </select>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-xs-12 no-padding">
                            <div class="bannerSearch">
                                <div class="searchBox">
                                    <ul>
                                        <li><i class="fas fa-map-marker-alt"></i></li>
                                        <li class="ivl_list" style="width: 88% !important;margin-top: 12px">
                                            <select class="form-control select2 search" name="area" id="area" onchange="filter_hos_using_area()">
                                                <option value="">Area</option>
                                                <?php foreach ($area as $area_row ) {?>
                                                <option value="<?=$area_row->id;?>"><?=$area_row->area_name;?></option>
                                                <?php }?>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                            {{--<input type="submit" class="btn btn-sm btn-warning" value="search">--}}
                            <div class="bannerSearch">
                                <div class="searchBox">
                                    <ul>
                                        <li><i class="fas fa-glasses"></i></li>
                                        <li class="ivl_list" style="width: 88% !important;margin-top: 12px">
                                            <select class="form-control select2 search" name="type" id="type" onchange="get_hospital()">
                                                {{--<option value="">Doctor/Hospital</option>--}}
                                                {{--<option value="D">Doctor</option>--}}
                                                <option value="">Doctor/Hospital</option>
                                                <option value="S">Doctor</option>
                                                <option value="H">Hospital</option>

                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-6 col-md-6 col-xs-12 no-padding">
                            <div class="bannerSearch">
                                <div class="searchBox">
                                    <ul>
                                        <li><i class="fas fa-search modify"></i></li>

                                            {{--<input type="text" name="doctor" class="search" placeholder="Search Doctor" id="tags" onkeyup="loadDocData();">--}}
                                            <div style="display: none; padding: 15px 15px 15px 30px;" id="hospital_names">

                                                <select style="width: 100%;" class="form-control search select2 modify-select-result" name="hospital" id="hospital" >
                                                    <?php foreach ($hospital as $hospital_row ) {?>
                                                       <option value="<?=$hospital_row->id;?>"><?=$hospital_row->hospital_name;?></option>
                                                    <?php }  ?>
                                                </select>

                                            </div>

                                                    <input autocomplete="off" style="width: 350px; padding-left: 30px;border: none;margin-left: 5px; padding-top: 7px; height: 53px;text-align: left;" type="text" name="doctor_name" id="doctor_name" class="form-control" placeholder="Enter Hospital/Speciality Name" required/>

                                                    <div id="DoctorList"></div>

{{ csrf_field() }}

                                        </li>


                                    </ul>
                                    <button class="search-btn" id="submit_button" style="display: none"><i class="fas fa-search modify2"></i> Search</button>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


        {{--<div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="bannerImg" align="center" style="height: 151px">
                    <input id="submit_button" type="submit" class="btn btn-warning btn-lg" value="Search" style="border-radius: 12px;display: none">
                </div>
            </div>
        </div>--}}

        </form>
    </div>

    </div>

</section>
<section class="banner-small desktop-hide">
    <img src="{{ asset('img/banner-small-client.png') }}">
</section>

<section class="service-link">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                <div class="bannerMenuBottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-xs-12">
                                <div class="bannerMenuBottomBox">
                                    <ul>

                                        <li>
                                            <a href="{{ url('online-consult') }}">
                                                Online Consult
                                            </a>
                                            <span>|</span>
                                        </li>
                                        <li>
                                            <a href="{{ url('more-packages') }}">
                                                Book Checkup
                                            </a>
                                            <span>|</span>
                                        </li>
                                        <li>
                                            <a href="{{ url('emergency-health-service') }}">
                                                Emergency Health Services
                                            </a>
                                            <span>|</span>
                                        </li>
                                        <li>
                                            <a href="{{ url('patient-referral') }}">
                                                Patient Referral
                                            </a>
                                            <span>|</span>
                                        </li>
                                        <li>
                                            <a href="{{ url('ask-doctor') }}">
                                                Ask health Question
                                            </a>
                                            <span>|</span>
                                        </li>
                                        <li>
                                            <a href="{{url('blog')}}">
                                                Read health Article
                                            </a>
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
</section>


<!-- ###########################
    HEALTH CHECKUP SECTION
########################### -->


<section class="healthCheckup" id="healthCheckup">
    <div class="container">
        <h1>Affordable full body health checkups</h1>
        <div class="row">
            <?php foreach ($health_package as $health_data) {?>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="checkupContent">
                    <img class="pkg-header-img"  src="{!! asset('assets/frontend/images/titleBar.png') !!}">
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
            <?php } ?>
        </div>
    </div>
    <a href="{{url('more-packages')}}">
        <h2>More Packages</h2>
    </a>

</section>



<!-- ###########################
    VIDEO CHAT SECTION
########################### -->

<section class="videoChat">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="videoChatLeft">
                    <a href="{{ url('/online-consult') }}">
                        <h3>Consult Online</h3>
                    </a>
                    <p>
                        <i class="fas fa-dot-circle"></i><span>0000</span>Doctor Online
                    </p>
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Verified doctor</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Doctor provide e-prescription</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>2-days free followup</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>100% private and confidential</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Easy refund policy</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="videoChatRight">
                    <div class="v-title">
                        <h1> Video chat with a doctor</h1>
                        <span>(Skip the waiting room)</span>
                    </div>
                    <div class="chatImg">
                        <img src="{!! asset('assets/frontend/images/consultation.png') !!}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ###########################
    MEDICAL TOUR SECTION
########################### -->


<section class="medicalTour">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="medicalTourLeft">
                    <h1>Want to make a <span>Medical Tour Outside Bangladesh?</span></h1>
                    <span>We refer to top foreign hospitals</span>
                    <div class="tourImg">
                        <img src="{!! asset('assets/frontend/images/doctors.png') !!}">
                    </div>
                    <h4>in India, Singapore, Thailand and Malaysia </h4>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="medicalTourRight">
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Refer to world class hospitals (JCI accredited)</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Most experianced and renowned doctors</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Online report assessment </span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Doctor opinion and cost evaluation is FREE </span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Airport pickup and drop for FREE </span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Translator to solve language difficulties for FREE </span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Online discussion with doctor after returning home  </span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Comprehensive and well treatment is guaranteed</span>
                        </li>

                    </ul>
                    <a href="{{ url('patient-referral') }}">
                        <h3>Enter the process</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ###########################
    HEALTH SERVICES SECTION
########################### -->

<section class="healthServices">
    <h1>Emergency health services</h1>
    <div class="container">
        <div class="row">

                <?php foreach ($health_service as $service_row) { ?>
                <div class="col-lg-3 col-md-3 col-xs-12">
                    <div class="healthContent">
                        <div class="healthImg">
                            <?php if ($service_row->image != ''){?>
                            <img src="{{url('/public').$service_row->image}}">
                                <?php }else{?>
                            <img src="{!! asset('assets/frontend/images/icon1.png') !!}">
                            <?php } ?>
                        </div>
                        <h4><a style="color: #0097b9" href="{{url('service_details').'/'.$service_row->id}}">{{$service_row->name}}</a></h4>
                        {{--<h4><a style="color: #0097b9" href="{{url('service_details').'/'.$service_row->id}}">{{$service_row->name}}</a></h4>--}}
                        <p align="center"> {{substr($service_row->terms, 0, 70) . '...'}}</p>
                        {{--<a onclick="alert({{$service_row->hot_line_number}});">
                            <h5>Order</h5>
                        </a>--}}
                        <a href="{{url('service_details').'/'.$service_row->id}}">
                            <h5>Order</h5>
                        </a>
                    </div>
                </div>
                <?php } ?>

            <div class="col-lg-3 col-md-3 col-xs-12">
                <div class="healthContentCus">
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Reliable and trustworthy</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Certified Lab</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Simple and Convenient</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Extensive test coverage</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Online reports delivery</span>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ url('emergency-health-service') }}" >See More</a>--}}
                        {{--</li>--}}
                    </ul>

                </div>

            </div>



        </div>

    </div>
    <a href="{{ url('emergency-health-service') }}">
        <h2>More Services</h2>
    </a>
</section>



<!-- ###########################
    ASK QUESTION SECTION
########################### -->


<section class="askQuestion">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="askContent">
                    <h1>Ask a health question and get answer from doctor. its free!</h1>
                    <div class="askImg">
                        <img src="{!! asset('assets/frontend/images/ask-doctor.png') !!}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="askContent">
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Verified doctor</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Problem related answer</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Quick response</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Privacy and anonymity guaranteed</span>
                        </li>
                    </ul>
                    <a href="{{ url('ask-doctor') }}">
                        <h3>Submit your question</h3>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ###########################
    HEALTH TIPS SECTION
########################### -->

<?php /*
<section class="healthTips">
    <h1>Read <span>health tips</span> top <span>articles</span>
        from health experts</h1>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="healthSlider">

                    @foreach($health_articles as $healthArticle)
                    <div class="healthSliderBox">
                        <div class="healthSliderBoxImg" align="center">
                            <img style="width: 75%; max-height: 200px" src="{{url('uploads/health_article')."/".$healthArticle->image}}">
                        </div>
                        <h3><a href="{{url('blog_single').'/'.$healthArticle->id}}">{{$healthArticle->title}}</a></h3>
                        <h4>{{$healthArticle->get_doctor ? $healthArticle->get_doctor->doctor_name : ''}}</h4>
                        <h5>{{$healthArticle->get_doctor ? $healthArticle->get_doctor->current_designation : ''}}</h5>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
*/ ?>


    <section class="blog-me pt-100 pb-100" id="blog">
         <div class="container">
            <div class="row">
               <div class="col-xl-6 mx-auto text-center">
                  <div class="section-title pt-100 mb-100">
                     <h4>Read <span>health tips</span> top <span>articles</span> <br>
                        from health experts</h4>
                  </div>
               </div>
            </div>
            <div class="row">
                @foreach($health_articles as $healthArticle)
               <div class="col-md-4">
                  <!-- Single Blog -->
                  <div class="single-blog">
                     <div class="blog-img">
                         @if($healthArticle->image !='')
                            <img src="{{url('public/uploads/health_article/thumb')."/".$healthArticle->image}}" width="600px" alt="{{$healthArticle->title}}">
                         @else
                             <img src="{!! asset('assets/frontend/images/no_image1.png') !!}" width="50px">
                         @endif
                        <div class="post-category">
                           <a href="{{url('blog_single').'/'.$healthArticle->id}}"> <i class="fa fa-tag"></i> {{$healthArticle->get_doctor ? $healthArticle->get_doctor->doctor_name : ''}}</a>
                        </div>
                     </div>

                      <div class="blog-content">
                          <div class="blog-title">
                              <h4><a href="{{url('blog_single').'/'.$healthArticle->id}}">{{ $healthArticle->title }}</a></h4>
                              <div class="meta">
                                  <ul>
                                      <li>{{ date('d M Y', strtotime($healthArticle->date)) }}</li>
                                  </ul>
                              </div>
                          </div>

                          <a href="{{url('blog_single').'/'.$healthArticle->id}}" class="box_btn">read more</a>

                          <div class="doctor-specialty">

                              <div>
                                  <h6>Degree</h6>
                                  <ul>
                                      @foreach($healthArticle->get_doctor->get_degree as $degrees)
                                          <li><i class="fas fa-check"></i> {{$degrees->get_degree->degree_name}}</li>
                                      @endforeach
                                  </ul>

                              </div>

                              <div>
                                  <h6>Specialty</h6>
                                  <ul>
                                      @foreach($healthArticle->get_doctor->get_speciality as $spaciality)
                                          <li><i class="fas fa-check"></i> {{$spaciality->get_speciality->speciality_name}}</li>
                                      @endforeach
                                  </ul>

                              </div>
                          </div>

                      </div>
                  </div>
               </div>
               @endforeach
               <div class="col-md-12 text-center blog-content">
                   <a href="{{url('blog')}}" class="box_btn">See All Articles</a>
               </div>
            </div>
         </div>
    </section>


<!-- ###########################
    SOURCE APP SECTION
########################### -->


<section class="sourceApp">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="sourceAppLeft">
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Multi-level security checks</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Multiple data backups</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Strengthen data privacy policy</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>End to end encription</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Non-relational database(NoSQL)</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Records are accessible only by you</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="sourceAppRight">
                    <h1>All your medical records in one secure app</h1>
                    <div class="tourImg">
                        <img src="{!! asset('assets/frontend/images/data-security.png') !!}">
                    </div>
                    <h4>its safe and secure</h4>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- ###########################
    INSTANT DOCTOR SECTION
########################### -->


<section class="instant">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="instantLeft">
                    <h1>Instant doctor appointment</h1>
                    <div class="instantImg">
                        <img src="{!! asset('assets/frontend/images/doctor.png') !!}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="instantRight">
                    <h1>Guaranteed!</h1>
                    <a href="{{ url('book-appointment') }}">
                        <h3>Find me the right doctor</h3>
                    </a>
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Verified doctor</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Patient recommendation</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Video chat availability</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ###########################
    PATIENT REFERRAL SECTION
########################### -->


<div class="container-fluid patient-referral">
    <div class="single-page-header">
        <div class="container">
            <div class="page-title">
                <h2>Patients are looking you</h2>
                <p>Patients are looking for right doctor on BDcare.</p>
                <p>Start your digital journey with BDcare Profile.</p>
                <h6>Lets take the first step and create your account:</h6>
                <form>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="pname" placeholder="type full name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="pname" placeholder="type mobile number" class="form-control">
                        <div class="note">Note: OTP will be send to this number for verification.</div>
                    </div>
                    <div class="create-profile-btn">
                        <a href="javascript:void(0)">Continue</a>
                    </div>
                    <div class="note">If you already have an account. <a href="{{ url('/admin-login') }}">Please login here</a></div>
                </form>
            </div>
            <div class="page-header__icon">
                <img src="{{ asset('assets/frontend/images/page-header/patient-referral.png') }}">
            </div>
        </div>
    </div>
</div>


<!-- ###########################
    BDCARE APP SECTION
########################### -->


<section class="bdCareApp">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="bdCareAppLeft">
                    <div class="bdCareImg">
                        <img src="{!! asset('assets/frontend/images/download-app.png') !!}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="bdCareAppRight">
                    <h1>Download the bdcare App</h1>
                    <ul>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Find doctors and book appointments</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>consult doctor onlines</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>order emergency health services</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Store health records</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Patient referral to abroad</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Ask health question</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Read health tips</span>
                        </li>
                    </ul>
                    <div class="downloadApp">
                        <a href="https://play.google.com/store/apps/details?id=com.iventure.bdcare">
                            {{--<i class="fab fa-google-play"></i>--}}
                            <span>{{ __('messages.Download_the_App') }}</span>
                            <img src="{!! asset('assets/frontend/images/icon/google-play2.png') !!}">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.footer')

<script>

    function filter_hos_using_area() {

        var type = $('#type').val();

        if(type =='H')
        {
            get_hospital_list();
        }
    }

    function get_areas()
    {

        var city = $('#city').val();
        var type = $('#type').val();

        if(type =='H')
        {
            get_hospital_list();
        }

        if(city != '')
        {
            /*var _token = $('input[name="_token"]').val();*/

            $.ajax({
                type:'GET',
                url:"{{url('get_areas')}}",
                data:{ city:city },
                success:function(data){

                    $('#area').html(data);
                }
            });
        }

    }

    function get_hospital_list()
    {
        var city = $('#city').val();
        var area = $('#area').val();

        if(city != '' && area != '')
        {
            $.ajax({
                type:'GET',
                url:"{{url('get_hospital_list')}}",
                data:{ city:city, area: area },
                success:function(data){

                    $('#hospital').html(data);
                }
            });
        }
    }

</script>
<style>

    .wrapper{
        width:25rem;
        height: 70vh;
        font-size: 1.2rem;
        float: left;
        position: absolute;
        z-index: 999;
    }

    .card{
        background-color: #fff;
        border-radius: 0.2rem;
        box-shadow: 0px 0px 0.1rem rgba(0,0,0,0.3), 0px 0.2rem 0.2rem rgba(0,0,0,0.3);
        overflow:auto;
    }

    .mat_list{
        list-style-type: none;
        display:block;
        height: 100%;
    }
    .mat_list>li{
        margin-top:-1px;
        width:100%;
        max-height: 100%;
        transition: max-height 0.5s;
        overflow: hidden;
    }
    .mat_list>li::before{
        content: "";
        width: 75%;
        display:block;
        margin:auto;
        border-top:1px solid rgba(0,0,0,0.3);
    }
    .mat_list>li.hide{
        max-height:0px;
    }
    .mat_list_title{
        background-color: #955;
        color: rgba(255,255,255,0.75);
    }
    .mat_list_title[style*="background"]{
        height: 10rem;
        position:relative;
        background-size: cover;
        background-position: center center;
    }
    .mat_list_title>h1{
        font-size: 2rem;
        font-weight: 100;
    }
    .mat_list_title[style*="background"]>h1{
        position:absolute;
        bottom:0px;
        background-color: rgba(0,0,0,0.75);
    }
</style>
