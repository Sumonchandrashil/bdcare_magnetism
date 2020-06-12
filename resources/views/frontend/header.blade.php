<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online healthcare service,online doctor,ask a doctor,talk to a doctor online,online doctor consultation,
online doctor visit,dr online,medical advice online,internal doctor,ask doctor online,bd health,bd,web doctor,online health insurance,
speak to a doctor online,talk to a doctor,medical help online,see a doctor online,online doctor advice,online dr visit,online doctor prescription,
online doctor help,physicians online,doctor advice,online health services,online dr consultation,online docter,drs online,online drs,
online doctor app,healthcare websites,ask a dr,doctors in Chittagong,doctors in Dhaka,ask doctors,health insurance ,health insurance plans,
health insurance quotes,cheap health insurance,private medical insurance,online doctor,online doctor service,affordable health insurance,
health care plans,health insurance,private health insurance,individual health insurance,health insurance companies,medical insurance companies,
private health care,medical insurance,online medical care,health cover,affordable health care,health care insurance,medical Checkup,
Healthcare service,Air ambulance service,Home nurses,Medicine supply,Sample collection">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/all.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/slick.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/slick-theme.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/about.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/contact-us.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/blog.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/profile.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/ask_doctor.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/login.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/register.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/doctorsFilter.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/style.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/service_details.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/responsive.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/package-details.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/base.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/frontend/css/responsive-latest.css') !!}">

    <link rel="icon" href="{!! asset('assets/frontend/images/logo.png') !!}" type="image/gif">
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <script src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
    <link href="{!! asset('assets/frontend/css/select2.min.css') !!}" rel="stylesheet"/>
    <title>BdCare</title>
</head>


<body>


<!-- ###########################
    TOP BAR SECTION
########################### -->


<section class="header">

    <div class="top-bar">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="appDownload">
                    <i class="fas fa-mobile-alt">
                        <a class="navbar-brand"
                           href="https://play.google.com/store/apps/details?id=com.iventure.bdcare">{{ __('messages.Download_the_App') }}</a>
                    </i>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('book-appointment') }}">{{ __('messages.Video_chat_with_doctor') }} <span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('appointment-online')}}">{{ __('messages.Ask_doctor') }}
                                doctor</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('ask-doctor') }}">{{ __('messages.Ask_doctor') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('more-packages') }}">{{ __('messages.Book_checkup') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="hospitalsCity" class="nav-link dropdown-toggle" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">{{ __('messages.Hospitals') }}</a>
                            <div class="dropdown-menu" aria-labelledby="hospitalsCity">
                                <?php
                                use App\Model\BDCare\Notifications;use App\Model\BDCare\Setup\City;$cities = City::get();
                                if($cities->count() > 0){
                                foreach ($cities as $city){?>

                                <a class="dropdown-item"
                                   href="{{ url('hospitals-list/'.$city->id) }}">{{$city->city_name}}</a>

                                <?php }} ?>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="hospitalsCity" class="nav-link dropdown-toggle" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">{{ __('messages.Language') }}</a>
                            <div class="dropdown-menu" aria-labelledby="hospitalsCity">

                                <a class="dropdown-item" href="{{ url('language_switcher/bn') }}">{{ __('messages.bn') }} <img height="15px" src="{!! asset('assets/frontend/images/bd.png') !!}"></a>
                                <a class="dropdown-item" href="{{ url('language_switcher/en') }}">{{ __('messages.en') }} <img height="15px" src="{!! asset('assets/frontend/images/en.png') !!}"></a>

                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>


    </div>

    <div class="logoAndLogin">
        <div class="container">
            <div class="row">


                <div class="col-lg-2 col-md-2 col-xs-12">
                    <div class="logoSection">
                        <div class="logoImg">
                            <a href="{{ url('/') }}">
                                <img height="60px" src="{!! asset('assets/frontend/images/logo.png') !!}">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-md-8 col-xs-12"
                     style="font-family: 'Times New Roman';font-size: 20px;padding-top: 16px;">
                    <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        <b><i>{{ __('messages.Under_construction') }}</i></b></marquee>
                </div>

                <div class="col-lg-2 col-md-2 col-xs-12">
                    <div class="logInSection ">
                        <?php if(Auth::check()){

                        $notification = Notifications::where('status', 0)->where('created_for', Auth::User()->id)->get();

                        ?>

                        <a href="{{url('notifications')}}" class="notification-icon"><i
                                class="fas fa-bell"></i><span>{{$notification->count()}}</span></a>

                        <a href="#" class="dropdown-toggle my-profile2" data-toggle="dropdown">
                            <i class="fas fa-user"></i>
                            <strong> {{Auth::User()->user_name}} </strong>
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu profile-settings-dropdown">
                            <li>
                                <div class="navbar-login">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="profile-name">
                                                <div class="profile-photo">
                                                    <?php if (Auth::User()->user_photo){?>

                                                    <img width="50px"
                                                         src="uploads/user_photo/{{Auth::User()->user_photo}}">

                                                    <?php }else{?>

                                                    <img width="50px"
                                                         src="{!! asset('uploads/user_photo/user_photo.png') !!}">
                                                    <?php } ?>
                                                </div>
                                                <div class="profile-text">
                                                    <h5><strong>{{Auth::User()->user_name}}</strong></h5>
                                                    <h6>{{Auth::User()->email}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="dropdown-item">

                                                <?php if(Auth::user()->role_id != 1){?>
                                                <a href="{{url('UserProfile')}}">Dashboard</a>
                                                <?php }else{?>
                                                <a href="{{url('dashboard')}}">Dashboard</a>
                                                <?php } ?>

                                                <a href="{{url('notifications')}}">Notification</a>

                                                <?php if(Auth::user()->role_id == 3){?>

                                                <a href="{{url('doctors_profile-backend')}}">My Profile</a>
                                                <a href="{{url('DoctorDegree')}}">Add Degree</a>
                                                <a href="{{url('DoctorSpeciality')}}">Add Speciality</a>
                                                <a href="{{url('DoctorHospitalDetail')}}">Add Hospital/Clinic</a>
                                                <a href="{{url('DoctorClinicDetail')}}">Chamber Details</a>

                                                <a href="{{url('appointment-booked')}}">My Appointments</a>
                                                <a href="{{url('OnlineConsult')}}">Consult</a>
                                                <a href="{{url('add-health-article')}}">Add Health Articles</a>
                                                <a href="{{url('report-doctor')}}">Report</a>

                                                <?php } elseif(Auth::user()->role_id == 4){?>

                                                <a href="{{url('patient_info')}}">My Profile</a>

                                                <a href="{{url('regular-medication')}}">Ongoing Medicine</a>

                                                <a href="{{url('medical-records')}}">Medical Records</a>

                                                <a href="{{url('appointment-booking')}}">My Appointments</a>
                                                <a href="{{url('appointment-online')}}">Video Call<span style="font-size: 10px"> (under construction)</span></a>

                                                <a href="{{url('report-patient')}}">Report</a>
                                                <a href="{{url('package-order-patient')}}">My Package Order</a>
                                                <a href="{{url('service-order-patient')}}">My Service Order</a>
                                                <?php }?>

                                                <div class="logout">
                                                    <a href="{{ url('/logout') }}">Logout</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <?php }else{?>
                        <a href="{{ url('/admin-login') }}">
                            <h3 style="color: darkslategray;font-weight: bold">{{ __('messages.Login_Signup') }}</h3>
                        </a>
                    <?php } ?>

                    <!-- Profile -->

                        <!-- //Profile -->
                    </div>
                </div>

            </div>
        </div>

    </div>

    <style>
        .navbar-login {
            width: 305px;
            padding: 10px;
            padding-bottom: 0px;
        }

        .navbar-login-session {
            padding: 10px;
            padding-bottom: 0px;
            padding-top: 0px;
        }

        .icon-size {
            font-size: 87px;
        }

        .my-profile2 {
            float: right;
            padding: 32px;
        }

        .btnwidth {
            width: 75%;

            background-color: #005B75;
        }

    </style>

</section>
