<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$hospital_details->hospital_name}} Hospital page</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" href="{!! asset('assets/frontend/images/logo.png') !!}" type="image/gif">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/hospital-landing-page/css/bdcare-hospital.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('assets/hospital-landing-page/css/responsive.css') !!}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

</head>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>
<body>

<!--Banner Section start-->
<div class="hospital-section">

    <div class="banner-section">
        <img src="{!! asset("public/uploads/hospital_cover_photo/$hospital_details->cover_image") !!}" alt="Sorry! Image not available"
             onError="this.onerror=null;this.src='{!! asset('img/cover-not-found.jpg') !!}';">
    </div>

    <!--Hospital title start-->
    <div class="hospital-title">
        <a href="javascript:void(0)"><img src="{!! asset("public/uploads/hospital_logo/$hospital_details->logo") !!}" alt="Sorry! Image not available"
                        onError="this.onerror=null;this.src='{!! asset('img/not-available.jpg') !!}';"></a>
        <h1>{{$hospital_details->hospital_name}}</h1>
    </div>
    <!--Hospital title end-->

    <!--Highlighted address start-->
    <div class="highlight-address">
        <div class="address-icon">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <div class="address-text">
            <h2>{{$hospital_details->address}}</h2>
            {{--<h2>Email: {{$hospital_details->email}}</h2>--}}
        </div>
    </div>
    <!--Highlighted address end-->

    <!--Helpline start-->
    <div class="helpline">
        <h2>HelpLine: <a href="tel:+88{{$hospital_details->help_line}}" id="underline_color"><span style="color: #fff;">{{$hospital_details->help_line}}</span></a></h2>
    </div>
    <!--Helpline end-->

    <!--About section start-->
    <div class="container-fluid about-section">
        <div class="container">
            <div class="about-title">
                <h2>About Us:</h2>
            </div>
            <div class="about-text">
                <p>
                    {{substr($hospital_details->description, 0, 300)}}

                    @php
                        $data_limit = str_word_count($hospital_details->description);
                    @endphp

                    @if($data_limit > 200)
                        <span class="" data-target="#moreDetails" data-toggle="collapse" aria-expanded="false" aria-controls="moreDetails">
                        <i class="fas fa-ellipsis-h"></i></span>
                    @endif
                </p>
                <div class="collapse" id="moreDetails">
                    <p>
                        {{substr($hospital_details->description, 301)}}
                    </p>
                </div>
            </div>

        </div>
    </div>
    <!--About section end-->

    <!--//Hospital Bio section start-->
    <div class="container bio-section">
        <div class="row">
            <div class="col-md-8">
                <div class="about-title">
                    <h2>Hospital Details:</h2>
                </div>
                <table>
                    <tbody>
                    <tr>
                        <td>Type of Hospital</td>
                        <td>{{$hospital_details->type}}</td>
                    </tr>
                    <tr>
                        <td>Centers of Excellence</td>
                        <td>
                            <p>{{$hospital_details->excellence_center}}</p>
                        </td>
                    </tr>
                    {{--<tr>
                        <td>Number of Specialist</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Number of Hospital Bed</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Diagnosis/Lab Facilities</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Online Delivery Report</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Having ICU, CCU <span>(How many icu bed)</span>?</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Ambulance Service (<span>Having ICU Ambulance</span>)?</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>OT Details</td>
                        <td></td>
                    </tr>--}}
                    <?php if($hospital_facility->count() > 0){?>
                    <?php foreach ($hospital_facility as $row_facility){?>
                    <tr>
                        <td><?= $row_facility->get_facility ? $row_facility->get_facility->facility_name : 'Not Found';?></td>
                        <td><?= $row_facility->remarks ;?></td>
                    </tr>
                    <?php } }?>
                    <tr>
                        <td>Emergency Details</td>
                        <td>{{$hospital_details->emergency_details}}</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <!--Doctor profile start-->
            <div class="col-md-4">
                <div class="doctor-list">
                    <h4 style="background: #CCCCCC;color: white">Doctor List</h4>
                    <div class="get-appointment" >
                        <h4>Get Online Appointment!</h4>
                        <span>Click on desired doctor name and confirm appointment</span>
                    </div>

                    <?php foreach ($doctor_data as $row_doc) {
                    $check_status = DB::table('doctors_datas')->where('created_by',$row_doc->doctor_id)->where('status',1)->first();
                    if($check_status){

                        ?>

                    <div class="doctor-profile">
                        <a href="{{url('filter-doctor-data/'.$row_doc->doctor_id.'/'.$city_id.'/'.$area_id."?type=D")}}">
                            <div class="doctor-photo">

                                <?php
                                $pic = DB::table('users')->select('user_photo')->where('id',$row_doc->doctor_id)->first()->user_photo;

                                if($pic){?>

                                <img src="{!! asset('uploads/user_photo/'.$pic) !!}" alt="Sorry! Image not available"
                                     onError="this.onerror=null;this.src='{!! asset('img/photo.png') !!}';">

                                <?php
                                }
                               ?>

                               {{-- <img src="public/uploads/user_photo/{{$row_doc->get_user->user_photo}}" alt="Sorry! Image not available"
                                     onError="this.onerror=null;this.src='{!! asset('img/photo.png') !!}';">--}}
                            </div>
                            <div class="doctor-info">
                                <h5>Cardiologist</h5>
                                <h4>{{$row_doc->get_doctor ? $row_doc->get_doctor->doctor_name : 'Not Found'}}</h4>
                                <h5>MBBS, MD</h5>
                            </div>
                        </a>
                    </div>
                    <?php } }?>

                    <a href="#" style="color:#0097b9;font-weight: bold;text-align: right;display: block;padding-right: 12px" data-toggle="modal" data-target="#myModal"> See all Doctor's</a>

                </div>
                <div class="single-image-section">

                    <?php
                        if($hospital_gallery_data->count() > 0){
                        foreach ($hospital_gallery_data as $img_val){
                        ?>
                    <div class="image-list">
                        <img width="50px" height="250px" src="{!! asset('public/uploads/hospital_gallery/'.$img_val->picture)!!}">
                    </div>
                    <?php } }?>
                </div>
            </div>
            <!--//Doctor profile end-->

        </div>
    </div>
    <!--//Hospital Bio section end-->

    <!--Footer options start-->
    <div class="container-fluid footer-options">
        <div class="row">
            <ul>
                <li>

                    <a href="{{ url('/') }}"> <span>BdCare</span> Home</a>
                </li>
                <li>
                    {{--<a href="javascript:void(0)">Contact</a>--}}
                </li>
                <li>
                   <span>Web Link : </span> &nbsp;<a href="<?=$hospital_details->web_address;?>"> {{$hospital_details->web_address}}</a>
                </li>
            </ul>
        </div>
    </div>
    <!--Footer options end-->


    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Doctor List</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="table_id" class="display table table-responsive">
                        <thead style="background : #00a3b6; padding: 12px 10px; color: #fff; border : none;">
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Specialities</th>
                            <th>Degrees</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($all_doctors as $row)
                        <?php
                        $check_status = DB::table('doctors_datas')->where('created_by',$row->doctor_id)->where('status',1)->first();
                        if($check_status){?>
                        <tr>
                            <td width="25%"><img style="width: 30%" src="public/uploads/user_photo/{{$row->get_user->user_photo}}" alt="Sorry! Image not available" onError="this.onerror=null;this.src='{!! asset('img/photo.png') !!}';"></td>
                            <td width="25%"><a href="{{url('filter-doctor-data/'.$row->doctor_id.'/'.$city_id.'/'.$area_id."?type=D")}}">{{$row->get_doctor ? $row->get_doctor->doctor_name : 'Not Found'}}</a></td>
                            <td width="25%">Specialities</td>
                            <td width="25%">Degrees</td>
                        </tr>
                            <?php } ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button style="background : #00a3b6; padding: 10px 20px; color: #fff; border : none; border-radius: 0;" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</div>
<!--Banner Section end-->

<!--Bootstrap JQuery-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
{{--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>--}}
</body>
</html>
