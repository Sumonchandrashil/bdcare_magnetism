@include('frontend.header')

{{--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}

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
        else {
            alert('Select Speciality/Hospital')
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
</script>

<!-- ###########################
    BANNER SECTION
########################### -->

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif

<section class="banner" style="min-height: 650px">
    <div class="container">
        <!-- <form action="{{url('search-doc-for-appointment')}}" method="post" > -->
        <form action="{{url('search-data')}}" method="GET" >
            {{ csrf_field() }}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="bannerContent">
                    <h1><b>Your health partner </b></h1>
                    <h3>Find and Book Doctor/Hospital </h3>
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


</section>

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
                                        <a href="{{ url('/emergency-health-service') }}">
                                            Emergency Health Services
                                        </a>
                                        <span>|</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('/online-consult') }}">
                                            Online Consult
                                        </a>
                                        <span>|</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('/more-packages') }}">
                                            Book Checkup
                                        </a>
                                        <span>|</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('/patient-referral') }}">
                                            Patient Referral
                                        </a>
                                        <span>|</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('/ask-doctor') }}">
                                            Ask health Question
                                        </a>
                                        <span>|</span>
                                    </li>
                                    <li>
                                        <a href="{{ url('/blog') }}">
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

<!-- ###########################
    HEALTH CHECKUP SECTION
########################### -->


<!-- ###########################
    VIDEO CHAT SECTION
########################### -->

<section class="videoChat">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="videoChatLeft" style="padding-top: 60px;">
                    <a href="{{ url('/online-consult') }}">
                        <h3>Consult Online</h3>
                    </a>
                    <p>
                        <i class="fas fa-dot-circle"></i><span>0000</span>doctor online
                    </p>
                    <ul>
                        <li>
                            <i class="fas fa-check">
                                <span>Verified doctor</span>
                            </i>
                        </li>
                        <li>
                            <i class="fas fa-check">
                                <span>Patient recommendation</span>
                            </i>
                        </li>
                        <li>
                            <i class="fas fa-check">
                                <span>Video chat availability</span>
                            </i>
                        </li>
                        <li>
                            <i class="fas fa-check">
                                <span>Verified doctor</span>
                            </i>
                        </li>
                        <li>
                            <i class="fas fa-check">
                                <span>Patient recommendation</span>
                            </i>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="videoChatRight">
                    <h1>Skip the waiting room<br><span>Video chat with a doctor</span></h1>
                    <div class="chatImg">
                        <img src="{!! asset('assets/frontend/images/consultation.png') !!}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    function filter_hos_using_area() {

        var type = $('#type').val();

        if(type =='H')
        {
            get_hospital_list();
        }
    }

    function get_areas() {

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

@include('frontend.footer')
