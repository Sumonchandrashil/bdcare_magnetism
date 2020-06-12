<div class="profileNav">
    <div class="profileNavArea">

        {{--<div class="navItem">
            <a href="{{url('dashboard')}}">
                <p>Dashboard</p>
            </a>
        </div>--}}

        <div class="navItem">
            <a href="{{url('UserProfile')}}">
                <p class="{{ Request::is('UserProfile*') ? 'navItemActive' : '' }}">User Info</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('notifications')}}">
                <p class="{{ Request::is('notifications*') ? 'navItemActive' : '' }}">Notifications</p>
            </a>
        </div>

        <?php if(Auth::user()->role_id == 3) {?>

        <div class="navItem">
            <a href="#"
               class="dropdown-toggle {{ Request::is('doctors_profile-backend*') ? 'navItemActive' : '' }} {{ Request::is('DoctorDegree*') ? 'navItemActive' : '' }} {{ Request::is('DoctorSpeciality*') ? 'navItemActive' : '' }} {{ Request::is('DoctorHospitalDetail*') ? 'navItemActive' : '' }} {{ Request::is('DoctorClinicDetail*') ? 'navItemActive' : '' }}"
               data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <br>&nbsp;&nbsp;&nbsp;Create
                Profile </a>
            <ul class="dropdown-menu">
                <li>
                    <div class="navItem">
                        <a href="{{url('doctors_profile-backend')}}">
                            <p class="{{ Request::is('doctors_profile-backend*') ? 'navItemActive' : '' }}">Profile
                                Info</p>
                        </a>

                    </div>
                </li>
                <li>
                    <div class="navItem">
                        <a href="{{url('DoctorDegree')}}">
                            <p class="{{ Request::is('DoctorDegree*') ? 'navItemActive' : '' }}">Add Degree</p>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="navItem">
                        <a href="{{url('DoctorSpeciality')}}">
                            <p class="{{ Request::is('DoctorSpeciality*') ? 'navItemActive' : '' }}">Add Speciality</p>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="navItem">
                        <a href="{{url('DoctorHospitalDetail')}}">
                            <p class="{{ Request::is('DoctorHospitalDetail*') ? 'navItemActive' : '' }}">Add
                                Hospital/Clinic</p>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="navItem">
                        <a href="{{url('DoctorClinicDetail')}}">
                            <p class="{{ Request::is('DoctorClinicDetail*') ? 'navItemActive' : '' }}">Chamber
                                Details</p>
                        </a>
                    </div>
                </li>

            </ul>
        </div>

        <div class="navItem">
            <a href="{{url('about')}}">
                <p class="{{ Request::is('about*') ? 'navItemActive' : '' }}">About</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('appointment-booked')}}">
                <p class="{{ Request::is('appointment-booked*') ? 'navItemActive' : '' }}">My Appointments</p>
            </a>
        </div>

        {{--<div class="navItem">--}}
        {{--<a href="{{url('create-prescription')}}">--}}
        {{--<p class="{{ Request::is('create-prescription*') ? 'navItemActive' : '' }}">Create Prescription</p>--}}
        {{--</a>--}}
        {{--</div>--}}

        <div class="navItem">
            <a href="{{url('OnlineConsult')}}">
                <p class="{{ Request::is('OnlineConsult*') ? 'navItemActive' : '' }}">Consult</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('add-health-article')}}">
                <p class="{{ Request::is('add-health-article*') ? 'navItemActive' : '' }}">Health Articles</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('doctor-feedback')}}">
                <p class="{{ Request::is('doctor-feedback*') ? 'navItemActive' : '' }}">Feedback</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('doctor-off-days')}}">
                <p class="{{ Request::is('doctor-off-days*') ? 'navItemActive' : '' }}">Doc Off Days</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('report-doctor')}}">
                <p>Report</p>
            </a>
        </div>

        <?php } elseif(Auth::user()->role_id == 4){?>

        <div class="navItem">
            <a href="{{url('patient_info')}}">
                <p class="{{ Request::is('patient_info*') ? 'navItemActive' : '' }}">My Profile</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('regular-medication')}}">
                <p class="{{ Request::is('regular-medication*') ? 'navItemActive' : '' }}">Ongoing Medicine</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('medical-records')}}">
                <p class="{{ Request::is('medical-records*') ? 'navItemActive' : '' }}">Medical Records</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('appointment-booking')}}">
                <p class="{{ Request::is('appointment-booking*') ? 'navItemActive' : '' }}">My Appointments</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('appointment-online')}}">
                <p class="{{ Request::is('appointment-online*') ? 'navItemActive' : '' }}">Video Call<span style="font-size: 10px"> (under construction)</span></p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('report-patient')}}">
                <p>Report</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('package-order-patient')}}">
                <p>My Package Order</p>
            </a>
        </div>

        <div class="navItem">
            <a href="{{url('service-order-patient')}}">
                <p>My Service Order</p>
            </a>
        </div>

        <?php }?>

    </div>
</div>
<?php
$key = "Phone";
$HTTP_USER_AGENT = $_SERVER["HTTP_USER_AGENT"];
//preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", );
$HTTP_USER_AGENT = preg_replace("/[^a-zA-Z 0-9]+/", " ", $HTTP_USER_AGENT);

/* if (in_array($key, $HTTP_USER_AGENT))
 {
     echo "Word found";
 }
 else
 {
     echo "Word not found";
 }*/
?>
<script>
    $(window).on('load', function () {
        $('html,body').animate({
                scrollTop: $(".profileContent").offset().top
            },
            'slow');
    });
</script>
