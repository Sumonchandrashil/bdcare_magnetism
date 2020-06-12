@include('frontend.header')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="/resources/demos/style.css">

<style>
    #area{
        width: 180px;
    }
</style>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $( function() {

        <?php

        $i=1;

        foreach ($doc_data as $dt)

                {

                    $days = DB::table('doctors_hospital_details')->select('day','f_time','s_time')->where('hospital_id',$dt->hospital_id)->where('doctor_id',$dt->doctor_id)->get();



                    foreach ($days as $day_dt){



                ?>



                 $( "#datepicker<?=$i;?>").datepicker({

                    beforeShowDay: function(date) {

                        var day = date.getDay();

                        var dayy = $("#dt_count<?=$i;?>").val();

                        //alert(dayy);

                        return [(day == dayy)];

                    }});



        <?php $i++; } } ?>

    } );



    $( function() {

        <?php

        $i=100000;

        foreach ($doc_Clinic_data as $dt)

        {

        

		$days = DB::table('doctors_clinic_details')->select('day','f_time','s_time')->where('doctor_id',$dt->doctor_id)->get();



        foreach ($days as $day_dt){



        ?>



        $( "#datepicker<?=$i;?>").datepicker({

            beforeShowDay: function(date) {

                var day = date.getDay();

                var dayy = $("#dt_count<?=$i;?>").val();

                //alert(dayy);

                return [(day == dayy)];

            }});



        <?php $i++; } } ?>

    } );





    

    function check_field(T) {



        var T_pos = T.split('-')[0];

        var url_pos = T.substring(T.indexOf("-") + 1);

        //alert(T_pos) ;

        /*alert(T_pos) ;

        alert(url_pos) ;

        return;*/



        var date = $('#datepicker'+T_pos).val();

        var url = $('#url'+url_pos).val()+'/'+date;





        if(date == '')

        {

            document.getElementById("datepickerspan"+T_pos).innerHTML = 'Date Field is required';

            return false;

        }

        else {



            var answer = confirm("Are you sure want to book ?")



            if (answer){



                window.location = url;



            }

            else{



                alert("Booking Cancled");



            }



        }





    }

</script>

<script>

    $(document).ready(function(){



        $('#doctor_name').keyup(function(){

            var query = $(this).val();



            var city = $('#city').val();

            var area = $('#area').val();



            if(query != '')

            {

                var _token = $('input[name="_token"]').val();

                $.ajax({

                    url:"{{ route('autocomplete.fetch') }}",

                    method:"POST",

                    data:{query:query, _token:_token, city:city, area:area},

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

</script>

<!-- ###########################

    BANNER SECTION

########################### -->

<?php

$CityList = DB::table('cities')->orderBy('city_name','ASC')->get();



if (isset($city_id)) {

    $areaList = DB::table('areas')->where('city',$city_id)->orderBy('area_name','ASC')->get();

} else {

    $areaList = DB::table('areas')->orderBy('area_name','ASC')->get();

}



$SpecialityList = DB::table('specialities')->orderBy('speciality_name','ASC')->get();

?>

<section class="searchTop">

    <div class="container">

        <div class="row" >

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



                                    <option value="{{$city->id}}" @if(isset($city_id) && $city->id == $city_id) selected @endif >{{$city->city_name}}</option>



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

                            <li style="margin-top: -20px;margin-left: 10px;">

                                <select name="area" class="select2" id="area">



                                    @foreach($areaList as $area)



                                        <option value="{{$area->id}}" @if(isset($area_id) && $area->id == $area_id) selected @endif>{{$area->area_name}}</option>



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

                                <i class="fas fa-search"></i>

                            </li>

                            <li style="margin-top: -21px;

    margin-left: -4px;">



                                <input style="width: 100%" autocomplete="off" type="text" name="doctor_name" id="doctor_name" placeholder="Enter Speciality Name" />



                                <div id="DoctorList" style="position: absolute"></div>



                                {{ csrf_field() }}

                            </li>

                        </ul>

                    </div>

                </div>

            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                <div class="searchArea">

                    <p>

                        <a href="#">

                            <input type="checkbox" name=""><span>Online Booking</span>

                        </a>

                    </p>

                </div>

            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                <div class="searchArea">

                    <h6 id="filter">All Filters

                        <i id="filterArrow" class="fas fa-arrow-down"></i>

                    </h6>

                </div>

            </div>

            <div class="col-lg-2 col-md-2 col-xs-12 no-padding">

                <div class="searchArea">

                    <div class="dropdown dropdownCustom">

                        <button class="btn btn-secondary dropdown-toggle sort" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                            Sort By-

                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                            <a class="dropdown-item" href="#">Price Low to High</a>

                            <a class="dropdown-item" href="#">Price High to LOw</a>

                            <a class="dropdown-item" href="#">Relevance</a>

                        </div>

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

        <p>{{$count}} matches found for hospital: <span>Your Selection{{--General Physician In Dhaka--}}</span></p>

        <div class="row">

            <div class="col-lg-8 col-md-8 col-xs-12" >

                <?php $i=1; $T=1;?>

                @foreach($doc_data as $row_data)

                <?php if(isset($row_data->get_doctor->status) && $row_data->get_doctor->status == 1) { ?>

                <div class="filteredbox" >

                    <div class="row" style="background-color: white;">

                        <div class="col-md-2 col-xs-12 no-padding">

                            <div class="filteredboxArea">

                                <div class="filteredImg">

                                    <?php

                                    $pic = DB::table('users')->select('user_photo')->where('id',$row_data->doctor_id)->first()->user_photo;

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

                                            ->join('degrees','degrees.id','=','doctors_degree_details.degree_id')

                                            ->where('doctors_degree_details.doctor_id',$row_data->doctor_id)

                                            ->get();

                                        foreach ($degree as $row_degree)

                                            {

                                                echo $row_degree->degree_name.', ';

                                            }

                                        ?>

                                            <br>

                                        {{$row_data->get_doctor ? number_format($row_data->get_doctor->year_of_experience) : ''}} years experience<br>

                                        {{$row_data->get_doctor ? $row_data->get_doctor->current_designation : 'Designation'}}

                                    </a>

                                </p>

                                <ul style="margin-left: -40px;">

                                    <?php



                                    //DB:table('doctors_degree_details')->where('doctor_id',$row_data->doctor_id)->get()->degree_id;

                                    $Speciality = DB::table('doctors_speciality_details')

                                        ->select('specialities.speciality_name')

                                        ->join('specialities','specialities.id','=','doctors_speciality_details.speciality_id')

                                        ->where('doctors_speciality_details.doctor_id',$row_data->doctor_id)

                                        ->get();

                                    foreach ($Speciality as $row_speciality)

                                    {

                                        ?>

                                        <li>

                                            <span class="badge badge-secondary">{{$row_speciality->speciality_name}}</span>

                                        </li>

                                    <?php

                                    }

                                    ?>



                                </ul>

                                <br>



                            </div>

                        </div>

                        <?php

                        $day = DB::table('doctors_hospital_details')->select('day','f_time','s_time')->where('hospital_id',$row_data->hospital_id)->where('doctor_id',$row_data->doctor_id)->get();

                        ?>

                        <div class="col-md-4 col-xs-12 no-padding">

                            <div class="filteredboxArea areaRight">

                                <ul>

                                    <li>

                                        <i class="fas fa-thumbs-up"></i><span style="color: green; font-weight: bold;">100%</span>

                                    </li>

                                    <li>

                                        <i class="fas fa-comments"></i><span>224 Feedback</span>

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

                                    <button class="btn btn-primary btn-sm bookAppointment bookAppointment<?=$i;?>" data-toggle="tab" href="#home">

                                        <i class="fas fa-calendar-check"></i>Book Appointment

                                    </button>



                                    <button class="btn btn-primary btn-sm callNowTwo callNow<?=$i;?>">

                                        <i class="fab fa-readme"></i>View Details

                                    </button>



                                    <a href="https://play.google.com/store/apps/details?id=com.iventure.bdcare" target="_blank" style="">

                                        <button class="btn btn-primary btn-sm " >

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

                                    <p style="text-align: center">Select a time slot to book an appointment</p>



                                    <div class="tab-content">

                                        <div id="home" class=""><b><?php echo DB::table('hospitals')->where('id',$row_data->hospital_id)->first()->hospital_name;?></b>

								    <span>



                                        @foreach($day as $day_list)



                                            <?php

                                            /*switch ($day_dt->day){

                                            case "Sat":

                                                $dayy=6;

                                                break;

                                            case "Sun":

                                                $dayy=0;

                                                break;

                                            case "Mon":

                                                $dayy=1;

                                                break;

                                            case "Tue":

                                                $dayy=2;

                                                break;

                                            case "Wed":

                                                $dayy=3;

                                                break;

                                            case "Thr":

                                                $dayy=4;

                                                break;

                                            case "Fri":

                                                $dayy=5;

                                                break;

                                            }*/

                                                if($day_list->day == 'Sat')

                                                {

                                                    $dayy = 6;

                                                }

                                                elseif($day_list->day == 'Sun')

                                                {

                                                    $dayy = 0;

                                                }

                                                elseif($day_list->day == 'Mon')

                                                {

                                                    $dayy = 1;

                                                }

                                                elseif($day_list->day == 'Tue')

                                                {

                                                    $dayy = 2;

                                                }

                                                elseif($day_list->day == 'Wed')

                                                {

                                                    $dayy = 3;

                                                }

                                                elseif($day_list->day == 'Thu')

                                                {

                                                    $dayy = 4;

                                                }

                                                elseif($day_list->day == 'Fri')

                                                {

                                                    $dayy = 5;

                                                }

                                            ?>



                                            <ul class="list-inline">

								   			<li class="list-inline-item"><i class="far fa-calendar"></i>{{$day_list->day}}

                                                <input type="text" class="form-control" id="datepicker<?=$T;?>" name="datepicker" placeholder="Select Appointment Date">

                                                <div id="datepickerspan<?=$T;?>" style="color: red"></div>

                                                <input type="hidden" id="dt_count<?=$T;?>" value="<?=$dayy?>">

                                            </li>



                                            <?php



                                                $f_time = $day_list->f_time;

                                                $s_time = $day_list->s_time;



                                                // Declare and define two dates

                                                $date1 = "1970-01-01 ".$f_time;

                                                $date2 = "1970-01-01 ".$s_time;



                                                $date1 = strtotime($date1);

                                                $date2 = strtotime($date2);



                                                // Formulate the Difference between two dates

                                                $diff = abs($date2 - $date1);



                                                // To get the year divide the resultant date into

                                                // total seconds in a year (365*60*60*24)

                                                $years = floor($diff / (365*60*60*24));



                                                // To get the month, subtract it with years and

                                                // divide the resultant date into

                                                // total seconds in a month (30*60*60*24)

                                                $months = floor(($diff - $years * 365*60*60*24)

                                                    / (30*60*60*24));



                                                // To get the day, subtract it with years and

                                                // months and divide the resultant date into

                                                // total seconds in a days (60*60*24)

                                                $days = floor(($diff - $years * 365*60*60*24 -

                                                        $months*30*60*60*24)/ (60*60*24));



                                                // To get the hour, subtract it with years,

                                                // months & seconds and divide the resultant

                                                // date into total seconds in a hours (60*60)

                                                $hours = floor(($diff - $years * 365*60*60*24

                                                        - $months*30*60*60*24 - $days*60*60*24)

                                                    / (60*60));



                                                // To get the minutes, subtract it with years,

                                                // months, seconds and hours and divide the

                                                // resultant date into total seconds i.e. 60

                                                $minutes = floor(($diff - $years * 365*60*60*24

                                                        - $months*30*60*60*24 - $days*60*60*24

                                                        - $hours*60*60)/ 60);



                                                // To get the minutes, subtract it with years,

                                                // months, seconds, hours and minutes



                                                $seconds = floor(($diff - $years * 365*60*60*24

                                                    - $months*30*60*60*24 - $days*60*60*24

                                                    - $hours*60*60 - $minutes*60));



                                                $f_time = strtotime($f_time);



                                                $loop_length = ($hours*4);



                                                $timeList = array();

                                                $time_loop = 1;

                                                for ($k=1;$k<=$loop_length;$k++)

                                                {

                                                if($k == 1)

                                                {

                                                    $start_time = date("H:i", strtotime('+0 minutes', $f_time));

                                                    //array_push($timeList,$start_time);

                                                    //array_push($timeList, array('time' => $start_time));

                                                }

                                                else

                                                {

                                                    $start_time = date("H:i", strtotime('+15 minutes', $f_time));

                                                    $f_time = strtotime($start_time);

                                                    // array_push($timeList,$start_time);

                                                    //array_push($timeList, array('time' => $start_time));

                                                }

                                                ?>

                                                <?php

                                                    $url = url('app-booking/'.$row_data->doctor_id.'/'.$row_data->hospital_id.'/'.$day_list->day.'/'.$start_time);

                                                ?>



                                            <?php $zzz = $T.'-'.$time_loop;?>

                                            <li style="line-height: 50px" class="list-inline-item"><a onclick="check_field('<?=$zzz;?>');"  class="btn btn-outline-primary">{{date('h:i a', strtotime($start_time))}}</a></li>

                                            &nbsp;<input type="hidden" value="<?=$url?>" id="url<?=$time_loop?>">

                                            <?php

                                                $time_loop++;

                                                }

                                                ?>



								    	</ul>



                                            <hr>

                                                <?php $T++;?>

                                        @endforeach



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

                                <span>Phone Number</span>

                                <h1>{{$row_data->get_doctor ? $row_data->get_doctor->emergency_contact : ''}}</h1>





                                <p>

                                    By calling this number, you agree to the <a href="#">Terms & Conditions</a>. If you could not connect

                                    with the doctor, please write to info@bdcare.com

                                </p>

                            </div>

                        </div>

                    </div>



                </div>





                    <?php $i++;?>

                    <?php } ?>

                @endforeach



                    <p>{{$ClinicCount}} matches found for Clinic: <span>Your Selection{{--General Physician In Dhaka--}}</span></p>

                    <?php $i=1;$T = 100000;$doc_id=0;?>

                    @foreach($doc_Clinic_data as $row_data)

                        <?php if(isset($row_data->get_doctor->status) && $row_data->get_doctor->status == 1 && $doc_id != $row_data->doctor_id) { ?>
                        <?php $doc_id = $row_data->doctor_id;?>
                        <div class="filteredbox" >

                            <div class="row" style="background-color: white;">

                                <div class="col-md-2 col-xs-12 no-padding">

                                    <div class="filteredboxArea">

                                        <div class="filteredImg">

                                            <?php

                                                $pic = DB::table('users')->select('user_photo')->where('id',$row_data->doctor_id)->first()->user_photo;

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

                                                    ->join('degrees','degrees.id','=','doctors_degree_details.degree_id')

                                                    ->where('doctors_degree_details.doctor_id',$row_data->doctor_id)

                                                    ->get();

                                                foreach ($degree as $row_degree)

                                                {

                                                    echo $row_degree->degree_name.', ';

                                                }

                                                ?>

                                                <br>

                                                {{$row_data->get_doctor ? number_format($row_data->get_doctor->year_of_experience) : ''}} years experience<br>

                                                {{$row_data->get_doctor ? $row_data->get_doctor->current_designation : 'Designation'}}

                                            </a>

                                        </p>

                                        <ul style="margin-left: -40px;">

                                            <?php



                                            //DB:table('doctors_degree_details')->where('doctor_id',$row_data->doctor_id)->get()->degree_id;

                                            $Speciality = DB::table('doctors_speciality_details')

                                                ->select('specialities.speciality_name')

                                                ->join('specialities','specialities.id','=','doctors_speciality_details.speciality_id')

                                                ->where('doctors_speciality_details.doctor_id',$row_data->doctor_id)

                                                ->get();

                                            foreach ($Speciality as $row_speciality)

                                            {

                                            ?>

                                            <li>

                                                <span class="badge badge-secondary">{{$row_speciality->speciality_name}}</span>

                                            </li>

                                            <?php

                                            }

                                            ?>



                                        </ul>

                                        <br>



                                    </div>

                                </div>

                                <?php

                                $day = DB::table('doctors_clinic_details')->select('day','f_time','s_time')->where('doctor_id',$row_data->doctor_id)->where('clinic',$row_data->clinic)->get();

                                ?>

                                <div class="col-md-4 col-xs-12 no-padding">

                                    <div class="filteredboxArea areaRight">

                                        <ul>

                                            <li>

                                                <i class="fas fa-thumbs-up"></i><span style="color: green; font-weight: bold;">100%</span>

                                            </li>

                                            <li>

                                                <i class="fas fa-comments"></i><span>224 Feedback</span>

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





                                            <a href="https://play.google.com/store/apps/details?id=com.iventure.bdcare" target="_blank" style="">

                                                <button class="btn btn-primary btn-sm " >

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

                                    <div class="callNowTwoPanel callNowPanelClinic<?=$i;?>" style="height: auto">

                                        <span>Phone Number</span>

                                        <h1>{{$row_data->get_doctor ? $row_data->get_doctor->emergency_contact : ''}}</h1>

                                        <?php

                                        $clinic_datas = DB::table('doctors_clinic_details')->where('doctor_id',$row_data->doctor_id)->where('clinic',$row_data->clinic)->get();
                                        //print_r($clinic_datas);
                                        if($clinic_datas){

                                        ?>

                                        <b>Clinic Data: </b><br>

                                        @foreach($clinic_datas as $clinic_data)

                                            <p style="text-align: center">

                                                <span style="font-weight: bold">Chamber name & Address: </span>{{$clinic_data->clinic}}, {{$clinic_data->address}}

                                            <?php

                                            if($clinic_data->day == 'Sat')
                                            {
                                                $dayy = 6;
                                            }
                                            elseif($clinic_data->day == 'Sun')
                                            {
                                                $dayy = 0;
                                            }
                                            elseif($clinic_data->day == 'Mon')
                                            {
                                                $dayy = 1;
                                            }
                                            elseif($clinic_data->day == 'Tue')
                                            {
                                                $dayy = 2;
                                            }
                                            elseif($clinic_data->day == 'Wed')
                                            {
                                                $dayy = 3;
                                            }
                                            elseif($clinic_data->day == 'Thu')
                                            {
                                                $dayy = 4;
                                            }
                                            elseif($clinic_data->day == 'Fri')
                                            {
                                                $dayy = 5;
                                            }
                                            ?>

                                            <ul class="list-inline">

                                                <li class="list-inline-item"><i class="far fa-calendar"></i> {{$clinic_data->day}} </li>

                                                <input type="text" class="form-control" id="datepicker<?=$T;?>" name="datepicker" placeholder="Select Appointment Date">

                                                <div id="datepickerspan<?=$T;?>" style="color: red"></div>

                                                <input type="hidden" id="dt_count<?=$T;?>" value="<?=$dayy?>">

                                                <?php



                                                $f_time = $clinic_data->f_time;

                                                $s_time = $clinic_data->s_time;



                                                // Declare and define two dates

                                                $date1 = "1970-01-01 ".$f_time;

                                                $date2 = "1970-01-01 ".$s_time;



                                                $date1 = strtotime($date1);

                                                $date2 = strtotime($date2);



                                                // Formulate the Difference between two dates

                                                $diff = abs($date2 - $date1);



                                                // To get the year divide the resultant date into

                                                // total seconds in a year (365*60*60*24)

                                                $years = floor($diff / (365*60*60*24));



                                                // To get the month, subtract it with years and

                                                // divide the resultant date into

                                                // total seconds in a month (30*60*60*24)

                                                $months = floor(($diff - $years * 365*60*60*24)

                                                    / (30*60*60*24));



                                                // To get the day, subtract it with years and

                                                // months and divide the resultant date into

                                                // total seconds in a days (60*60*24)

                                                $days = floor(($diff - $years * 365*60*60*24 -

                                                        $months*30*60*60*24)/ (60*60*24));



                                                // To get the hour, subtract it with years,

                                                // months & seconds and divide the resultant

                                                // date into total seconds in a hours (60*60)

                                                $hours = floor(($diff - $years * 365*60*60*24

                                                        - $months*30*60*60*24 - $days*60*60*24)

                                                    / (60*60));



                                                // To get the minutes, subtract it with years,

                                                // months, seconds and hours and divide the

                                                // resultant date into total seconds i.e. 60

                                                $minutes = floor(($diff - $years * 365*60*60*24

                                                        - $months*30*60*60*24 - $days*60*60*24

                                                        - $hours*60*60)/ 60);



                                                // To get the minutes, subtract it with years,

                                                // months, seconds, hours and minutes



                                                $seconds = floor(($diff - $years * 365*60*60*24

                                                    - $months*30*60*60*24 - $days*60*60*24

                                                    - $hours*60*60 - $minutes*60));



                                                $f_time = strtotime($f_time);



                                                $loop_length = ($hours*4);



                                                $timeList = array();

                                                $T_time_loop = 100000;

                                                for ($k=1;$k<=$loop_length;$k++)

                                                {

                                                if($k == 1)

                                                {

                                                    $start_time = date("H:i", strtotime('+0 minutes', $f_time));

                                                    //array_push($timeList,$start_time);

                                                    //array_push($timeList, array('time' => $start_time));

                                                }

                                                else

                                                {

                                                    $start_time = date("H:i", strtotime('+15 minutes', $f_time));

                                                    $f_time = strtotime($start_time);

                                                    // array_push($timeList,$start_time);

                                                    //array_push($timeList, array('time' => $start_time));

                                                }

                                                ?>

                                                <?php

                                                $url = url('clinic-app-booking/'.$row_data->doctor_id.'/0'.$clinic_data->id.'/'.$day_list->day.'/'.$start_time);

                                                ?>

                                                <?php $yyy = $T.'-'.$T_time_loop;?>

                                                <li style="line-height: 50px" class="list-inline-item"><a onclick="check_field('<?=$yyy?>');" class="btn btn-outline-primary">{{date('h:i a', strtotime($start_time))}}</a></li>

                                                &nbsp;<input type="hidden" value="<?=$url?>" id="url<?=$T_time_loop?>">

                                                <?php

                                                $T_time_loop++;

                                                }

                                                ?>



                                            </ul>

                                            </p>

                                            <?php $T++;?>

                                        @endforeach



                                        <?php } ?>



                                        <p>

                                            By calling this number, you agree to the <a href="#">Terms & Conditions</a>. If you could not connect

                                            with the doctor, please write to info@bdcare.com

                                        </p>

                                    </div>

                                </div>

                            </div>



                        </div>





                        <?php $i++;?>

                        <?php } ?>

                    @endforeach

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

                                <p><span><?=DB::table('hospitals')->count()+DB::table('doctors_clinic_details')->count();?>+</span> Clinics & Hospitals</p>

                            </li>

                            <li>

                                <p><span><?=DB::table('patient_appointment_details')->count();?>+</span> Appointments</p>

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



                        <img style="width: 100%" src="{!! asset('assets/frontend/images/titleBar.png') !!}">

                    <div class="checkupTitle" style="margin-top: -90px"> <h3>{{$health_data->package_name}}</h3>

                        <h4>Ideal for person aged: {{$health_data->age_group}}</h4>

                    </div>

                    <div class="checkupContentBox">

                        <h3>Includes {{$health_data->no_of_tests}} Tests</h3>

                        <h4>{{$health_data->description}}</h4>

                    </div>

                    {{--<div class="checkupBlankBox">



                    </div>--}}

                    <div class="checkupPriceBox">

                        <div class="container-fluid">

                            <div class="row">

                                <div class="col-md-4 col-xs-12">

                                    <div class="priceBox">

                                        <h3>{{$health_data->discount}}% Off</h3>

                                    </div>

                                </div>

                                <div class="col-md-4 col-xs-12">

                                    <div class="priceBox">

                                        <h4>{{$health_data->price}}/-</h4>

                                        <h4><strike>{{($health_data->price*$health_data->discount)/100}}/-</strike></h4>

                                    </div>

                                </div>

                                <div class="col-md-4 col-xs-12">

                                    <div class="priceBox" style="padding-top: 23px;">

                                        <a href="{{url('package_booking'.'/'.$health_data->id)}}">

                                            <h5>Book</h5>

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <br>

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

    $(document).ready(function(){



        $("#filter").click(function(){

            $("#filterPanel").slideToggle('slow', function() {

                $('#filterArrow').toggleClass("fa-arrow-down fa-arrow-up");

            });

        });





        <?php

        $j=1;

        foreach($doc_data as $row_data){?>

        $(".callNow<?=$j;?>").click(function(){

            $(".callNowPanel<?=$j;?>").slideToggle('slow', function() {



            });

        });



        $(".bookAppointment<?=$j;?>").click(function(){

            $(".appointmentPanel<?=$j;?>").slideToggle('slow', function() {



            });

        });

        <?php $j++; } ?>



        <?php

        $j=1;

        foreach($doc_Clinic_data as $row_data){?>

        $(".callNowClinic<?=$j;?>").click(function(){

            $(".callNowPanelClinic<?=$j;?>").slideToggle('slow', function() {



            });

        });



        $(".bookAppointmentClinic<?=$j;?>").click(function(){

            $(".appointmentPanelClinic<?=$j;?>").slideToggle('slow', function() {



            });

        });

        <?php $j++; } ?>



    });





    function get_areas() {



        var city = $('#city').val();



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



</script>

{{--<style>



    .wrapper{

        width:25rem;

        height: 70vh;

        font-size: 1.2rem;

        float: left;

        position: absolute;

        z-index: 999;

    }

    .wrapper p,a, h1{

        padding:1rem;

        display:block;

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

</style>--}}



