@include('frontend.header')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="//resources/demos/style.css">
<meta name="csrf-token" content="{{ csrf_token() }}"/>
<style>
    #area {
        width: 180px;
    }

    .isDisabled {
        color: currentColor;
        cursor: not-allowed;
        opacity: 0.5;
        text-decoration: none;
    }
</style>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $(function () {


            <?php
            use App\Model\BDCare\DoctorOffDaysDetails;

            $i = 1;

            foreach ($doc_data as $dt)
            {
            $days = DB::table('doctors_hospital_details')->select('day', 'f_time', 's_time')->where('hospital_id', $dt->hospital_id)->where('doctor_id', $dt->doctor_id)->get();

            $doc_off_days = DoctorOffDaysDetails::select('doctor_off_day')->where('doctor_id', $dt->doctor_id)->get();

            $formated_off_dates = [];

            if ($doc_off_days->count() > 0) {
                foreach ($doc_off_days as $row) {
                    $formated_off_dates[] = date('j-n-Y', strtotime($row->doctor_off_day));
                }
            }


            foreach ($days as $day_dt){
            ?>
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        var unavailableDates = <?= json_encode($formated_off_dates) ?>;

        function unavailable(date) {

            dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
            if ($.inArray(dmy, unavailableDates) == -1) {
                return [true, ""];
            } else {
                return [false, "", "Unavailable"];
            }
        }

        $("#datepicker<?=$i;?>").datepicker({
            minDate: today,
            beforeShowDay: function (date) {
                //console.log(date);
                var day_value = [];
                var condition = '';
                var day = date.getDay();
                var dayy = $("#dt_count<?=$i;?>").val();
                var counter = $("#dt_count<?=$i;?>").attr("counter") - 1;

                dmy = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                if ($.inArray(dmy, unavailableDates) == -1) {
                    // return [true, ""];
                } else {
                    return [false, "", "Unavailable"];
                }

                var Sat = null;
                var Sun = null;
                var Mon = null;
                var Wed = null;
                var Tue = null;
                var Thr = null;
                var Fri = null;

                for (var t = 1; t <= counter; t++) {
                    var temp = $("#dt_count<?=$i;?>").attr("value" + t);

                    if (temp == 6) {
                        Sat = 6;
                    }
                    if (temp == 0) {
                        Sun = 0;
                    }
                    if (temp == 1) {
                        Mon = 1;
                    }
                    if (temp == 2) {
                        Tue = 2;
                    }
                    if (temp == 3) {
                        Wed = 3;
                    }
                    if (temp == 4) {
                        Thr = 4;
                    }
                    if (temp == 5) {
                        Fri = 5;
                    }

                }

                var array_length = day_value.length - 1;//array length

                var weekend = day == Sat || day == Sun || day == Mon || day == Tue || day == Wed || day == Thr || day == Fri;

                return [weekend, weekend ? 'myweekend' : ''];
            },
            onSelect: function (dateText, inst) {

                /*var date = $(this).val();
                var time = $('#time').val();*/
                //$("#start").val(date + time.toString(' HH:mm').toString());
                var T = $("#T<?=$i;?>").val();
                var hospital = $("#hospital<?=$i;?>").val();
                var doctor = $("#doctor<?=$i;?>").val();
                var date = dateText;
                var token = $('input[name=_token]').val();
                var data = {
                    _token: token,
                    date: date,
                };

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    /* the route pointing to the post function */
                    url: '{{url('getShedule')}}',
                    type: 'get',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, date: date, doctor: doctor, hospital: hospital, T: T},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        //alert(data);
                        document.getElementById("schedule<?=$i;?>").innerHTML = data;
                    }
                });


            }
        });

        <?php $i++; } } //use App\Model\BDCare\DoctorOffDaysDetails;?>

    });

    $(function () {
            <?php
            $i = 100000;
            foreach ($doc_Clinic_data as $dt)
            {
            $days = DB::table('doctors_clinic_details')->select('day', 'f_time', 's_time')->where('doctor_id', $dt->doctor_id)->get();
            foreach ($days as $day_dt){
            ?>

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = mm + '/' + dd + '/' + yyyy;

        $("#datepicker<?=$i;?>").datepicker({
            minDate: today,
            beforeShowDay: function (date) {
                var day_value = [];
                var condition = '';
                var day = date.getDay();
                var dayy = $("#dt_count<?=$i;?>").val();
                var counter = $("#dt_count<?=$i;?>").attr("counter") - 1;

                var Sat = null;
                var Sun = null;
                var Mon = null;
                var Wed = null;
                var Tue = null;
                var Thr = null;
                var Fri = null;

                for (var t = 1; t <= counter; t++) {
                    //day_value[t] = $("#dt_count<?=$i;?>").attr("value"+t);
                    var temp = $("#dt_count<?=$i;?>").attr("value" + t);
                    //condition += ""+day == day_value[t] + '||'+"";
                    if (temp == 6) {
                        Sat = 6;
                    }
                    if (temp == 0) {
                        Sun = 0;
                    }
                    if (temp == 1) {
                        Mon = 1;
                    }
                    if (temp == 2) {
                        Tue = 2;
                    }
                    if (temp == 3) {
                        Wed = 3;
                    }
                    if (temp == 4) {
                        Thr = 4;
                    }
                    if (temp == 5) {
                        Fri = 5;
                    }

                }

                var array_length = day_value.length - 1;//array length

                //return [(day ==  0 || day == 6)];

                var weekend = day == Sat || day == Sun || day == Mon || day == Tue || day == Wed || day == Thr || day == Fri;

                return [weekend, weekend ? 'myweekend' : ''];
            },
            onSelect: function (dateText, inst) {
                var T = $("#T<?=$i;?>").val();
                var hospital = $("#hospital<?=$i;?>").val();
                var doctor = $("#doctor<?=$i;?>").val();
                var date = dateText;
                var token = $('input[name=_token]').val();
                var data = {
                    _token: token,
                    date: date,
                };
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    /* the route pointing to the post function */
                    url: '{{url('getSheduleClinic')}}',
                    type: 'get',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, date: date, doctor: doctor, hospital: hospital, T: T},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) {
                        //alert(data);
                        document.getElementById("schedule<?=$i;?>").innerHTML = data;
                    }
                });


            }
        });



        <?php $i++; } } ?>

    });

    function check_field_hos(T1, T2) {

        var T_pos = T1;

        var url_pos = T2;


        var date = $('#datepicker' + T_pos).val();

        var url = $('#url' + url_pos).val() + '/' + date;

        if (date == '') {
            document.getElementById("datepickerspan" + T_pos).innerHTML = 'Date Field is required';
            return false;
        } else {
            var answer = confirm("Are you sure want to book ?");
            if (answer) {
                window.location = url;
            } else {
                alert("Booking Cancled");
            }
        }
    }

    function check_field_clinic(T1, T2) {

        var T_pos = T1;

        var url_pos = T2;

        var date = $('#datepicker' + T_pos).val();

        var url = $('#url' + url_pos).val() + '/' + date;

        if (date == '') {
            document.getElementById("datepickerspan" + T_pos).innerHTML = 'Date Field is required';
            return false;
        } else {
            var answer = confirm("Are you sure want to book ?");
            if (answer) {
                window.location = url;
            } else {
                alert("Booking Cancled");
            }
        }
    }

</script>

<script>

    $(document).ready(function () {

        $('#doctor_name').keyup(function () {
            var query = $(this).val();

            var city = $('#city').val();
            var area = $('#area').val();
            var type = $('#type').val();

            if (city == '' || area == '' || type == '') {
                alert('Please Select City, Area & Type of Search First');
                return;
            }

            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('autocomplete.fetch') }}",
                    method: "POST",
                    data: {query: query, _token: _token, city: city, area: area, type: type},
                    success: function (data) {
                        $('#DoctorList').fadeIn();
                        $('#DoctorList').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function () {
            //$('#doctor_name').val($(this).text());
            $('#doctorList').fadeOut();
        });
    });

</script>

<!-- ###########################

    BANNER SECTION

########################### -->

<?php
$CityList = DB::table('cities')->orderBy('city_name', 'ASC')->get();

if (isset($city_id)) {
    $areaList = DB::table('areas')->where('city', $city_id)->orderBy('area_name', 'ASC')->get();
} else {
    $areaList = DB::table('areas')->orderBy('area_name', 'ASC')->get();
}

$SpecialityList = DB::table('specialities')->orderBy('speciality_name', 'ASC')->get();

?>

<section class="searchTop">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">
                <div class="searchArea">
                    <div class="areaBox">
                        <ul>
                            <li style="margin-top: -5px">
                                <i class="fas fa-map-marker-alt"></i>
                            </li>
                            <li style="margin-top: -5px">
                                <select name="city" class="select2" id="city" onchange="get_areas()">
                                    <option value="">Select City</option>
                                    @foreach($CityList as $city)
                                        <option value="{{$city->id}}"
                                                @if(isset($city_id) && $city->id == $city_id) selected @endif >
                                            {{$city->city_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </li>
                            <li style="margin-top: -5px">
                                <i class="fas fa-map-pin"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">
                <div class="searchArea">
                    <div class="areaBox">
                        <ul>
                            <li style="margin-top: -5px">
                                <i class="fas fa-search"></i>
                            </li>
                            <li style="margin-top: -20px;margin-left: 10px;" class="search-filter-field">
                                <select name="area" class="select2" id="area">
                                    @foreach($areaList as $area)
                                        <option value="{{$area->id}}"
                                                @if(isset($area_id) && $area->id == $area_id) selected @endif>
                                            {{$area->area_name}}
                                        </option>
                                    @endforeach
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">
                <div class="searchArea">
                    <div class="areaBox">
                        <ul>
                            <li style="margin-top: -5px">
                                <i class="fas fa-glasses"></i>
                            </li>
                            <li style="margin-top: -5px;margin-left: 15px;" class="search-filter-field">
                                <select class="form-control select2 search" name="type" id="type">
                                    <option value="S"
                                            <?php if(isset($_GET['type']) && $_GET['type'] == 'S') { ?> selected <?php } ?>>
                                        Doctor
                                    </option>
                                    <option value="H"
                                            <?php if(isset($_GET['type']) && $_GET['type'] == 'H') { ?> selected <?php } ?>>
                                        Hospital
                                    </option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                <div class="searchArea">

                    <div class="areaBox">

                        <ul>

                            <li style="margin-top: -5px">

                                <i class="fas fa-search"></i>

                            </li>

                            <li style="margin-top: -21px;margin-left: -4px;" class="search-filter-field">

                                <input style="width: 100%; padding: 4px; border:none;" autocomplete="off" type="text"
                                       name="doctor_name" id="doctor_name"
                                       placeholder="Enter Speciality/Hospital Name"/>

                                <div id="DoctorList" style="position: absolute"></div>

                                {{ csrf_field() }}

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                {{--<div class="searchArea">

                    <h6 id="filter">All Filters

                        <i id="filterArrow" class="fas fa-arrow-down"></i>

                    </h6>

                </div>--}}

            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                <div class="searchArea">

                    <div class="dropdown dropdownCustom">

                        {{-- <button class="btn btn-secondary dropdown-toggle sort" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                             Sort By-

                         </button>

                         <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                             <a class="dropdown-item" href="#">Price Low to High</a>

                             <a class="dropdown-item" href="#">Price High to LOw</a>

                             <a class="dropdown-item" href="#">Relevance</a>

                         </div>--}}

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-12  col-md-12 col-xs-12">

            <div id="filterPanel">

                <div class="row">

                    <div class="col-lg-3 col-md-3 col-xs-12">

                        <div class="filterPanelArea">

                            <ul>

                                <li><h4>Gender</h4></li>

                                <li>

                                    <input type="checkbox" name=""><span>Male Doctor</span>

                                </li>

                                <li>

                                    <input type="checkbox" name=""><span>Female Doctor</span>

                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-3 col-xs-12">

                        <div class="filterPanelArea">

                            <ul>

                                <li><h4>Consultation Fee</h4></li>

                                <li>

                                    <input type="radio" name=""><span>Free</span>

                                </li>

                                <li>

                                    <input type="radio" name=""><span>1-200</span>

                                </li>

                                <li>

                                    <input type="radio" name=""><span>201-500</span>

                                </li>

                                <li>

                                    <input type="radio" name=""><span>501+</span>

                                </li>

                            </ul>

                        </div>

                    </div>

                    <div class="col-lg-3 col-md-3 col-xs-12">

                        <div class="filterPanelArea">


                        </div>

                    </div>

                    <div class="col-lg-3 col-md-3 col-xs-12">


                        <div class="filterPanelArea">


                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- ###########################

    FILTERED SECTION

########################### -->


<section class="filtered">

    <div class="container">

        <p class="filter-search-title"><strong> Matches found for hospital:
                <span>Your Selection{{--General Physician In Dhaka--}}</span> </strong></p>

        <div class="row">

            <div class="col-lg-8 col-md-8 col-xs-12">

                <?php $i = 1; $T = 1;?>

                @foreach($doc_data as $row_data)

                    <?php if(isset($row_data->get_doctor->status) && $row_data->get_doctor->status == 1) { ?>

                    <div class="filteredbox">

                        <div class="row" style="background-color: white;">

                            <div class="col-md-2 col-xs-12 no-padding">

                                <div class="filteredboxArea">

                                    <div class="filteredImg">

                                        <?php

                                        $pic = DB::table('users')->select('user_photo')->where('id', $row_data->doctor_id)->first()->user_photo;

                                        if($pic){?>

                                        <img src="{!! asset('uploads/user_photo/'.$pic) !!}">

                                        <?php }else{?>

                                        <img src="{!! asset('uploads/user_photo/user_photo.png') !!}">

                                        <?php } ?>


                                    </div>

                                    <!-- <p>SPONSORED</p> -->

                                </div>

                            </div>

                            <div class="col-md-6 col-xs-12 no-padding">

                                <div class="filteredboxArea areaMiddle">

                                    <h3>

                                        <a href="#">

                                            {{$row_data->get_doctor ? $row_data->get_doctor->doctor_name : ''}}

                                        </a>

                                    </h3>

                                    <p>

                                        <a href="#">

                                            <?php



                                            //DB:table('doctors_degree_details')->where('doctor_id',$row_data->doctor_id)->get()->degree_id;

                                            $degree = DB::table('doctors_degree_details')
                                                ->select('degrees.degree_name')
                                                ->join('degrees', 'degrees.id', '=', 'doctors_degree_details.degree_id')
                                                ->where('doctors_degree_details.doctor_id', $row_data->doctor_id)
                                                ->get();

                                            foreach ($degree as $row_degree) {

                                                echo $row_degree->degree_name . ', ';

                                            }

                                            ?>

                                            <br>

                                            {{$row_data->get_doctor ? number_format($row_data->get_doctor->year_of_experience) : ''}}
                                            years experience<br>

                                            {{$row_data->get_doctor ? $row_data->get_doctor->current_designation : 'Designation'}}
                                            <br>
                                            {{$row_data->get_doctor ? $row_data->get_doctor->summary : 'Institute'}}

                                        </a>

                                    </p>

                                    <ul style="margin-left: -40px;">

                                        <?php



                                        //DB:table('doctors_degree_details')->where('doctor_id',$row_data->doctor_id)->get()->degree_id;

                                        $Speciality = DB::table('doctors_speciality_details')
                                            ->select('specialities.speciality_name')
                                            ->join('specialities', 'specialities.id', '=', 'doctors_speciality_details.speciality_id')
                                            ->where('doctors_speciality_details.doctor_id', $row_data->doctor_id)
                                            ->get();

                                        foreach ($Speciality as $row_speciality)

                                        {

                                        ?>

                                        <li>

                                            <span
                                                class="badge badge-secondary">{{$row_speciality->speciality_name}}</span>

                                        </li>

                                        <?php

                                        }

                                        ?>


                                    </ul>

                                    <br>


                                </div>

                            </div>

                            <?php

                            $day = DB::table('doctors_hospital_details')->select('day', 'f_time', 's_time')->where('hospital_id', $row_data->hospital_id)->where('doctor_id', $row_data->doctor_id)->get();

                            ?>

                            <div class="col-md-4 col-xs-12 no-padding">

                                <div class="filteredboxArea areaRight">

                                    <ul>

                                        <li>

                                            <i class="fas fa-thumbs-up"></i><span
                                                style="color: green; font-weight: bold;">{{$rating}}</span>

                                        </li>

                                        <li>

                                            <i class="fas fa-comments"></i><span>{{$count}} Feedback</span>

                                        </li>

                                        <li>

                                            <i class="fas fa-map-marker"></i><span>Address</span>

                                        </li>

                                        <li>

                                            <i class="fas fa-money-bill-alt"></i><span>{{$row_data->get_doctor ? $row_data->get_doctor->visiting_fees : ''}} BDT</span>

                                        </li>

                                        <li>

                                            <i class="far fa-clock"></i>

                                            <span>

                                                @foreach($day as $day_list)

                                                    {{$day_list->day}},

                                                    {{date("H:i", strtotime($day_list->f_time))}} -

                                                    {{date("H:i", strtotime($day_list->s_time))}},

                                                    <br>

                                                @endforeach

                                            </span>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                            <div class="container">

                                <br>

                                <div class="panel-group">

                                    <div class="panel panel-default" align="right">

                                        <button class="btn btn-primary btn-sm bookAppointment bookAppointment<?=$i;?>"
                                                data-toggle="tab" href="#home">

                                            <i class="fas fa-calendar-check"></i>Book Appointment

                                        </button>

                                        <button class="btn btn-primary btn-sm callNowTwo callNow<?=$i;?>">
                                            <i class="fab fa-readme"></i>View Details
                                        </button>
<!--https://play.google.com/store/apps/details?id=com.iventure.bdcare-->
                                        <a href="{{url('appointment-online')}}"
                                           target="_blank" style="">

                                            <button class="btn btn-sm " style="background-color: #F9C737">

                                                <i class="fab fa-android"></i>Online Consult

                                            </button>

                                        </a>

                                    </div>

                                </div>

                                <br>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-xs-12 no-padding">

                                <div class="appointmentPanel appointmentPanel<?=$i;?>">

                                    <div class="appointmentData">

                                        <p style="text-align: center;font-weight: bold">Select a date & time to book an
                                            appointment</p>

                                        <div class="tab-content">

                                            <div id="home" class="" align="center">

                                                <b style="font-style: oblique">
                                                    <?php echo DB::table('hospitals')->where('id', $row_data->hospital_id)->first()->hospital_name;?>
                                                </b>

                                                <span>



                                        <ul class="list-inline">

								   			<i class="far fa-calendar"></i><input style="width: 50%" type="text"
                                                                                  autocomplete="off"
                                                                                  class="form-control date-picker"
                                                                                  id="datepicker<?=$T;?>"
                                                                                  name="datepicker"
                                                                                  placeholder="Select Appointment Date">

                                                <div id="datepickerspan<?=$T;?>" style="color: red"></div>
                                                <input type="hidden" value="<?=$row_data->hospital_id;?>"
                                                       name="hospital" id="hospital<?=$T;?>">
                                                <input type="hidden" value="<?=$row_data->doctor_id;?>" name="doctor"
                                                       id="doctor<?=$T;?>">
                                                <input type="hidden" id="dt_count<?=$T;?>"

                                                       <?php
                                                       $val = 1;
                                                       foreach ($day as $row_val){

                                                       if ($row_val->day == 'Sat' || $row_val->day == 'SAT') {
                                                           $dayy = 6;
                                                       } elseif ($row_val->day == 'Sun' || $row_val->day == 'SUN') {
                                                           $dayy = 0;
                                                       } elseif ($row_val->day == 'Mon' || $row_val->day == 'MON') {
                                                           $dayy = 1;
                                                       } elseif ($row_val->day == 'Tue' || $row_val->day == 'TUE') {
                                                           $dayy = 2;
                                                       } elseif ($row_val->day == 'Wed' || $row_val->day == 'WED') {
                                                           $dayy = 3;
                                                       } elseif ($row_val->day == 'Thu' || $row_val->day == 'THU') {
                                                           $dayy = 4;
                                                       } elseif ($row_val->day == 'Fri' || $row_val->day == 'FRI') {
                                                           $dayy = 5;
                                                       }
                                                       ?>

                                                       value<?=$val;?>="<?=$dayy;?>"

                                                       <?php $val++;} ?>

                                                       counter="<?=$val;?>"
                                                >
                                                <input type="hidden" id="T<?=$T;?>" value="<?=$T;?>">
<hr>
                                                <div id="schedule<?=$T;?>"></div>

								    	</ul>
                                                <?php $T++;?>
								    </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-xs-12 no-padding">

                                <div class="callNowTwoPanel callNowPanel<?=$i;?>" style="height: auto">
                                    @if($row_data->get_doctor->bio_data !='')
                                        <span>BIO</span>
                                        <p> {{$row_data->get_doctor ? $row_data->get_doctor->bio_data : ''}}</p>
                                    @endif
                                    <p>
                                        By calling this number, you agree to the <a href="#">Terms & Conditions</a>. If
                                        you could not connect

                                        with the doctor, please write to info@bdcare.com

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php $i++;?>

                    <?php } ?>

                @endforeach

                <div style="margin-top: 15px">
                    {{--                    {{ $doc_data->links() }}--}}
                </div>


                <p><strong> Matches found for Clinic: </strong></p>

                <?php
                $i = 1;
                $T = 100000;
                $doc_id = 0;
                $clinic_array = [];
                ?>

                @foreach($doc_Clinic_data as $row_data)

                    <?php if(isset($row_data->get_doctor->status) && $row_data->get_doctor->status == 1 && $doc_id != $row_data->doctor_id && !in_array($row_data->clinic, $clinic_array)) { ?>
                    <?php
                    $doc_id = $row_data->doctor_id;
                    array_push($clinic_array, $row_data->clinic)
                    ?>

                    <div class="filteredbox">

                        <div class="row" style="background-color: white;">

                            <div class="col-md-2 col-xs-12 no-padding">

                                <div class="filteredboxArea">

                                    <div class="filteredImg">

                                        <?php

                                        $pic = DB::table('users')->select('user_photo')->where('id', $row_data->doctor_id)->first()->user_photo;

                                        if($pic){?>

                                        <img src="{!! asset('uploads/user_photo/'.$pic) !!}">

                                        <?php }else{?>

                                        <img src="{!! asset('uploads/user_photo/user_photo.png') !!}">

                                        <?php } ?>

                                    </div>

                                    <!-- <p>SPONSOREDDDDDDD</p> -->

                                </div>

                            </div>

                            <div class="col-md-6 col-xs-12 no-padding">

                                <div class="filteredboxArea areaMiddle">

                                    <h3>

                                        <a href="#">

                                            {{$row_data->get_doctor ? $row_data->get_doctor->doctor_name : ''}}

                                        </a>

                                    </h3>

                                    <p>

                                        <a href="#">

                                            <?php



                                            //DB:table('doctors_degree_details')->where('doctor_id',$row_data->doctor_id)->get()->degree_id;

                                            $degree = DB::table('doctors_degree_details')
                                                ->select('degrees.degree_name')
                                                ->join('degrees', 'degrees.id', '=', 'doctors_degree_details.degree_id')
                                                ->where('doctors_degree_details.doctor_id', $row_data->doctor_id)
                                                ->get();

                                            foreach ($degree as $row_degree) {

                                                echo $row_degree->degree_name . ', ';

                                            }

                                            ?>

                                            <br>

                                            {{$row_data->get_doctor ? number_format($row_data->get_doctor->year_of_experience) : ''}}
                                            years experience<br>

                                            {{$row_data->get_doctor ? $row_data->get_doctor->current_designation : 'Designation'}}
                                            <br>
                                            {{$row_data->get_doctor ? $row_data->get_doctor->summary : 'Institute'}}

                                        </a>

                                    </p>

                                    <ul style="margin-left: -40px;">

                                        <?php

                                        //DB:table('doctors_degree_details')->where('doctor_id',$row_data->doctor_id)->get()->degree_id;

                                        $Speciality = DB::table('doctors_speciality_details')
                                            ->select('specialities.speciality_name')
                                            ->join('specialities', 'specialities.id', '=', 'doctors_speciality_details.speciality_id')
                                            ->where('doctors_speciality_details.doctor_id', $row_data->doctor_id)
                                            ->get();

                                        foreach ($Speciality as $row_speciality)
                                        {
                                        ?>
                                        <li>
                                            <span
                                                class="badge badge-secondary">{{$row_speciality->speciality_name}}</span>
                                        </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                    <br>
                                </div>
                            </div>
                            <?php
                            $day = DB::table('doctors_clinic_details')->select('day', 'f_time', 's_time')->where('doctor_id', $row_data->doctor_id)->where('clinic', $row_data->clinic)->get();
                            ?>
                            <div class="col-md-4 col-xs-12 no-padding">

                                <div class="filteredboxArea areaRight">

                                    <ul>

                                        <li>

                                            <i class="fas fa-thumbs-up"></i><span
                                                style="color: green; font-weight: bold;">{{$rating}}</span>

                                        </li>

                                        <li>

                                            <i class="fas fa-comments"></i><span>{{$count}} Feedback</span>

                                        </li>

                                        <li>

                                            <i class="fas fa-map-marker"></i><span>Address</span>

                                        </li>

                                        <li>

                                            <i class="fas fa-money-bill-alt"></i><span>{{$row_data->get_doctor ? $row_data->get_doctor->visiting_fees : ''}} BDT</span>

                                        </li>

                                        <li>

                                            <i class="far fa-clock"></i>

                                            <span>

                                                @foreach($day as $day_list)

                                                    {{$day_list->day}},

                                                    {{date("H:i", strtotime($day_list->f_time))}} -

                                                    {{date("H:i", strtotime($day_list->s_time))}},

                                                    <br>

                                                @endforeach

                                            </span>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                            <div class="container">

                                <br>

                                <div class="panel-group">

                                    <div class="panel panel-default" align="right">

                                        <button class="btn btn-primary callNowTwo callNowClinic<?=$i;?>">

                                            <i class="fab fa-readme"></i>Book Appointment

                                        </button>

                                        <button class="btn btn-primary btn-sm callNowTwo callNowClinic<?=$i;?>">
                                            <i class="fab fa-readme"></i>View Details
                                        </button>
<!--https://play.google.com/store/apps/details?id=com.iventure.bdcare-->
                                        <a href="{{url('appointment-online')}}"
                                           target="_blank" style="">

                                            <button class="btn btn-sm " style="background-color: #F9C737">

                                                <i class="fab fa-android"></i>Online Consult

                                            </button>

                                        </a>

                                    </div>

                                </div>

                                <br>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-xs-12 no-padding">

                                <div class="callNowTwoPanel callNowPanelClinic<?=$i;?>" style="height: auto"
                                     align="center">

                                    <?php

                                    $clinic_datas = DB::table('doctors_clinic_details')->where('doctor_id', $row_data->doctor_id)->where('clinic', $row_data->clinic)->get();
                                    //print_r($clinic_datas);
                                    if($clinic_datas){

                                    ?>

                                    <b>Clinic Name & Address: </b> <?=$clinic_datas->first()->clinic;?>
                                    ,<?=$clinic_datas->first()->address;?><br>


                                    {{--<h1><span style="font-weight: bold;font-size: 12px">Phone Number:</span> {{$row_data->get_doctor ? $row_data->get_doctor->emergency_contact : ''}}</h1>--}}

                                    <ul class="list-inline">

                                        <i class="far fa-calendar"></i><input style="width: 50%" type="text"
                                                                              autocomplete="off"
                                                                              class="form-control date-picker"
                                                                              id="datepicker<?=$T;?>" name="datepicker"
                                                                              placeholder="Select Appointment Date">

                                        <div id="datepickerspan<?=$T;?>" style="color: red"></div>
                                        <input type="hidden" value="<?=$clinic_datas->first()->id;?>" name="hospital"
                                               id="hospital<?=$T;?>">
                                        <input type="hidden" value="<?=$row_data->doctor_id;?>" name="doctor"
                                               id="doctor<?=$T;?>">
                                        <input type="hidden" id="dt_count<?=$T;?>"

                                               <?php
                                               $val = 1;
                                               foreach ($day as $row_val){

                                               if ($row_val->day == 'Sat' || $row_val->day == 'SAT') {
                                                   $dayy = 6;
                                               } elseif ($row_val->day == 'Sun' || $row_val->day == 'SUN') {
                                                   $dayy = 0;
                                               } elseif ($row_val->day == 'Mon' || $row_val->day == 'MON') {
                                                   $dayy = 1;
                                               } elseif ($row_val->day == 'Tue' || $row_val->day == 'TUE') {
                                                   $dayy = 2;
                                               } elseif ($row_val->day == 'Wed' || $row_val->day == 'WED') {
                                                   $dayy = 3;
                                               } elseif ($row_val->day == 'Thu' || $row_val->day == 'THU') {
                                                   $dayy = 4;
                                               } elseif ($row_val->day == 'Fri' || $row_val->day == 'FRI') {
                                                   $dayy = 5;
                                               }
                                               ?>

                                               value<?=$val;?>="<?=$dayy;?>"

                                               <?php $val++;} ?>

                                               counter="<?=$val;?>"
                                        >
                                        <input type="hidden" id="T<?=$T;?>" value="<?=$T;?>">
                                        <hr>
                                        <div id="schedule<?=$T;?>"></div>

                                    </ul>
                                    <?php $T++;?>
                                    <?php } ?>
                                    <p>
                                        @if($row_data->get_doctor->bio_data !='')
                                            <span>BIO</span>
                                    <p> {{$row_data->get_doctor ? $row_data->get_doctor->bio_data : ''}}</p>
                                    @endif

                                    By calling this number, you agree to the <a href="#">Terms & Conditions</a>. If you
                                    could not connect

                                    with the doctor, please write to info@bdcare.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>





                    <?php $i++;?>

                    <?php } ?>

                @endforeach

                <div style="margin-top: 15px">
                    {{--{{ $doc_Clinic_data->links() }}--}}
                </div>

            </div>


            <div class="col-lg-4 col-md-4 col-xs-12">

                <div class="filteredbox">

                    <ul>

                        <li>

                            <a href="#">

                                <span>BdCare Blue Book</span>

                            </a>

                        </li>

                        <li style="">

                            <a href="#">

                                <span>Safety of your data</span>

                            </a>

                        </li>

                        <li style="">

                            <span>Most Searched Localities In Kolkata</span>

                        </li>

                        <li>

                            <a href="#">

                                Dentists in Salt Lake

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                Dental Practitioners in New Town

                            </a>

                        </li>

                        <li style="">

                            <a href="#">

                                <span>Health Articles</span>

                            </a>

                        </li>

                        <li>

                            <a href="#">

                                Root Canal

                            </a>

                        </li>

                        <li style="margin-bottom: 20px;">

                            <a href="#">

                                Tooth Extraction

                            </a>

                        </li>

                    </ul>

                    <div class="stats">

                        <h3><i class="fas fa-award"></i></h3>

                        <p>BdCare</p>

                        <ul>

                            <li>

                                <p><span><?=DB::table('doctors_datas')->count();?>+</span> Doctors</p>

                            </li>

                            <li>

                                <p><span><?=DB::table('users')->count();?>+</span> Users</p>

                            </li>

                            <li>

                                <p>
                                    <span><?=DB::table('hospitals')->count() + DB::table('doctors_clinic_details')->count();?>+</span>
                                    Clinics & Hospitals</p>

                            </li>

                            <li>

                                <p><span><?=DB::table('patient_appointment_details')->count();?>+</span> Appointments
                                </p>

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>


</section>


<section class="healthCheckup" id="healthCheckup">

    <div class="container">

        <h1>Affordable full body health checkups</h1>

        <div class="row">

            <?php foreach ($health_package as $health_data) {?>

            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="checkupContent">
                    <img class="pkg-header-img" src="{!! asset('assets/frontend/images/titleBar.png') !!}">
                    <div class="checkupTitle">
                        <h3>{{substr($health_data->package_name, 0, 50)}}</h3>
                        <h4>Ideal for person aged: {{$health_data->age_group}}</h4>
                    </div>
                    <div class="checkupContentBox">
                        <h3>Includes {{$health_data->no_of_tests}} Tests</h3>
                        <h4>{{substr($health_data->description,0,100)}}.....</h4>
                        <div class="price-block">
                            <hr>
                            <div class="price-block__discount">
                                <h3>{{$health_data->discount}}% Off</h3>
                            </div>
                            <div class="price-block__price">
                                <h4><b>{{$health_data->price-($health_data->price*$health_data->discount)/100}}/-</b>
                                </h4>
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
                                        <a href="{{url('package_details'.'/'.$health_data->id)}}"
                                           class="package-details-btn">Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>

            <?php } ?>

        </div>

    </div>

    <a href="{{url('more-packages')}}">

        <h2>More Packages</h2>

    </a>


</section>

<br>

<script>

    /*jQuery(document).ready(function () {

        Select2.init()

    });*/

</script>


@include('frontend.footer')


<script type="text/javascript">

    $(document).ready(function () {


        $("#filter").click(function () {

            $("#filterPanel").slideToggle('slow', function () {

                $('#filterArrow').toggleClass("fa-arrow-down fa-arrow-up");

            });

        });


        <?php

        $j = 1;

        foreach($doc_data as $row_data){?>

        $(".callNow<?=$j;?>").click(function () {

            $(".callNowPanel<?=$j;?>").slideToggle('slow', function () {


            });

        });


        $(".bookAppointment<?=$j;?>").click(function () {

            $(".appointmentPanel<?=$j;?>").slideToggle('slow', function () {


            });

        });

        <?php $j++; } ?>



        <?php

        $j = 1;

        foreach($doc_Clinic_data as $row_data){?>

        $(".callNowClinic<?=$j;?>").click(function () {

            $(".callNowPanelClinic<?=$j;?>").slideToggle('slow', function () {


            });

        });


        $(".bookAppointmentClinic<?=$j;?>").click(function () {

            $(".appointmentPanelClinic<?=$j;?>").slideToggle('slow', function () {


            });

        });

        <?php $j++; } ?>


    });


    function get_areas() {

        var city = $('#city').val();

        if (city != '') {


            $.ajax({

                type: 'GET',

                url: "{{url('get_areas')}}",

                data: {city: city},

                success: function (data) {


                    $('#area').html(data);

                }

            });

        }


    }
</script>





