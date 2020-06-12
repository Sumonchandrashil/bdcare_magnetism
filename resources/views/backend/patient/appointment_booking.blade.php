
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style>
    .select2-container{
        border: 1px solid silver;
        border-radius: 5px;
    }
</style>
<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info " data-toggle="modal" data-target="#exampleModal">ADD Appointment</button>

    <br><br>
    <span style="color: red">

        @if($errors->has('doctor'))
            <span class="validation_msg"> <strong> {{ $errors->first('doctor') }} </strong> </span>
        @endif

        @if($errors->has('hospital'))
            <span class="validation_msg"> <strong> {{ $errors->first('hospital') }} </strong> </span>
        @endif

        @if($errors->has('schedule'))
            <span class="validation_msg"> <strong> {{ $errors->first('schedule') }} </strong> </span>
        @endif
</span>

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
    <div class='table-responsive'>  <div style="overflow-x:auto;">
    <table id="example" class="display table " style="width:100%">
        <thead>
        <tr>
            <th>Appointment Date</th>
            <th>Appointment Day</th>
            <th>schedule</th>
            <th>Doctor</th>
            <th>Hospital/Chamber</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($patient_data as $patient_row)
            <tr>
                <td>{{$patient_row->date}}</td>
                <td>{{$patient_row->day}}</td>
                <td>{{date('g:i a', strtotime($patient_row->schedule))}}</td>
                <td>{{ $patient_row->get_doctor ? $patient_row->get_doctor->doctor_name : '' }}</td>
                <td>
                    <?php if(substr($patient_row->hospital_id,0,1) != 0){?>

                    {{ $patient_row->get_hospital ? $patient_row->get_hospital->hospital_name : 'Not Available' }}

                    <?php }else{?>

                    <?php echo DB::table('doctors_clinic_details')->where('id',substr($patient_row->hospital_id,1))->first() ? DB::table('doctors_clinic_details')->where('id',substr($patient_row->hospital_id,1))->first()->clinic : 'Not Available';?>

                    <?php } ?>

                </td>
                <td>
                    <?php
                    if($patient_row->status == 0)
                        {
                            echo "Not Confirmed";
                        }
                    elseif ($patient_row->status == 1)
                    {
                        echo "Booking Confirmed";
                    }
                    elseif ($patient_row->status == 2)
                    {
                        echo "Prescribed";
                    }
                    ?>
                </td>
                <td>
                    <?php if($patient_row->status == 0){?>
                    {{--<button class="btn btn-info" data-toggle="modal" data-target="#exampleModal2">Edit</button>--}}
                    &nbsp;
                    <a onclick="return confirm('Are you sure you want to Cancel this Appointment?');" class="btn btn-danger btn-sm" href="{{url('DeleteAppointment')."/".$patient_row->id}}">Cancel</a>
                    <?php }elseif($patient_row->status == 1) {?>
                        <a onclick="return confirm('Are you sure you want to Cancel this Appointment?');" class="btn btn-danger btn-sm" href="{{url('DeleteAppointment')."/".$patient_row->id}}">Cancel</a>
                    <?php }elseif($patient_row->status == 2){?>
                        <a style="color: white" class="btn btn-warning btn-sm" href="{{url('view-prescription')."/".$patient_row->id}}">View Prescription</a>
                        <a style="color: white" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal3" onclick="get_row(<?=$patient_row->id;?>)">Feedback</a>
                    <?php } ?>
                </td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Appointment Day</th>
            <th>Appointment Date</th>
            <th>schedule</th>
            <th>Doctor</th>
            <th>Hospital/Chamber</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
        </div>
    </div>
    <!-- Modal -->


    <div class="modal fade" id="exampleModal3" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('AddPrescriptionComment')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id_comment" id="row_id_comment">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Comment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">

                            <div class="form-group col-md-7">
                                <label for="inputCity">Rating</label>
                                <div>
                                    <input type="number" class="form-control" name="rating" placeholder="Pls Rating 1 to 5">
                                </div>

                            </div>

                            <div class="form-group col-md-10">
                                <label for="inputCity">Review/Comment</label>
                                <div>
                                    <textarea cols="55" rows="5" name="comment"></textarea>
                                </div>

                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Data</button>
                        </div>
                </form>
            </div>
        </div>
    </div>



</div>
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('add_booking')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="row_id" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <select class="form-control select2 search" name="city" id="city" onchange="filter_doc();" style="width: 100%">
                                <option value="">Select City</option>
                                @foreach($city as $r_city)
                                    <option value="{{$r_city->id}}" >{{$r_city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Area</label>
                            <select class="form-control select2 search" name="area" id="area" onchange="filter_doc2();" style="width: 100%">
                                <option value="">Select Area</option>
                                @foreach($area as $area_item)
                                    <option value="{{$area_item->id}}">{{$area_item->area_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Hospital</label>
                            <div id="hospitalList">

                            </div>
                            {{--<select class="form-control" name="hospital" id="hospital" onchange="filter_doc3();">
                                <option value="">Select Hospital</option>
                                @foreach($hospital as $hospital)
                                    <option value="{{$hospital->id}}">{{$hospital->hospital_name}}</option>
                                @endforeach
                            </select>--}}
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Doctors</label>
                            <div id="doctorList">

                            </div>
                            {{--<select class="form-control" name="doctor" id="doctor">
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->created_by}}">{{$doctor->doctor_name}}</option>
                                @endforeach
                            </select>--}}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Day</label>
                            <div id="DayList"></div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Schedile</label>
                            <div id="ScheduleList"></div>
                            {{--<textarea class="form-control" name="schedule" ></textarea>--}}
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="col-md-8 col-md-4">
                            <label for="inputCity">Date:</label>
                            <input type="date" class="form-control" name="date" id="">
                        </div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Data</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('EditBooking')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="row_id" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Appointment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">City</label>
                            <select class="form-control select2 search" style="width: 100%" name="city2" id="city2" onchange="filter_doc();">
                                <option value="">Select City</option>
                                @foreach($city as $r_city)
                                    <option value="{{$r_city->id}}" >{{$r_city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Area</label>
                            <select class="form-control select2 search" style="width: 100%" name="area2" id="area2" onchange="filter_doc2();">
                                <option value="">Select Area</option>
                                @foreach($area as $area_item)
                                    <option value="{{$area_item->id}}">{{$area_item->area_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Hospital</label>
                            <div id="hospitalList">

                            </div>
                            <select class="form-control select2 search" name="hospital2" id="hospital2" onchange="filter_doc3();" style="width: 100%">
                                <option value="">Select Hospital</option>
                                @foreach($hospital as $hospital)
                                    <option value="{{$hospital->id}}">{{$hospital->hospital_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">Doctors</label>
                            <div id="doctorList">

                            </div>
                            <select class="form-control select2 search" name="doctor2" id="doctor2" style="width: 100%">
                                @foreach($doctors as $doctor)
                                    <option value="{{$doctor->created_by}}">{{$doctor->doctor_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCity">Schedile</label>
                            <div id="ScheduleList"></div>
                            {{--<textarea class="form-control" name="schedule" ></textarea>--}}
                        </div>

                    </div>




                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Data</button>
                    </div>
            </form>
        </div>


    </div>


</div>





<script type="text/javascript">
    $(document).ready(function() {
        // $('#example').DataTable();
        var table = $('#example').DataTable();
        table.order( [ 0, 'desc' ] ).draw();
    } );

    function push_data(that) {
        $("#test2").html(that);
    }

    function filter_doc() {

       get_areas();

       var city_id = $('#city').val();

       $.ajax({
            type:'GET',
            url:"{{url('GetDocData')}}",
            data: {'city_id':city_id},
            //dataType: 'json',
            success:function(data) {
                //alert(data);
                $('#hospitalList').html(data);

                $('#hospital').select2({
                    placeholder: 'Select an option'
                });
            }
        });
    }

    function filter_doc2() {
        var city_id = $('#city').val();
        var area_id = $('#area').val();

        $.ajax({
            type:'GET',
            url:"{{url('GetDocData2')}}",
            data: {'city_id':city_id, 'area_id':area_id},
            //dataType: 'json',
            success:function(data) {
                //alert(data);
                $('#hospital').select2();
                $('#hospitalList').html(data);

                $('#hospital').select2({
                    placeholder: 'Select an option'
                });

            }
        });
    }

    function filter_doc3()
    {
        var city_id     = $('#city').val();
        var area_id     = $('#area').val();
        var hospital_id = $('#hospital').val();

        $.ajax({
            type:'GET',
            url:"{{url('GetDocData3')}}",
            data: {'city_id':city_id, 'area_id':area_id, 'hospital_id':hospital_id},
            //dataType: 'json',
            success:function(data) {

                $('#doctorList').html(data);

                $('#doctor').select2({
                    placeholder: 'Select an option'
                });
            }
        });
    }

    function filter_day() {

        var hospital_id = $('#hospital').val();
        var doc_id = $('#doctor').val();

        $.ajax({
            type:'GET',
            url:"{{url('GetDocDay')}}",
            data: {'hospital_id':hospital_id, 'doc_id':doc_id},
            //dataType: 'json',
            success:function(data) {

                $('#DayList').html(data);

                $('#day').select2({
                    placeholder: 'Select an option'
                });
            }
        });

    }

    function filter_schedule() {
        var hospital_id = $('#hospital').val();
        var doc_id = $('#doctor').val();
        var day = $('#day').val();

        $.ajax({
            type:'GET',
            url:"{{url('GetDocSchedule')}}",
            data: {'hospital_id':hospital_id, 'doc_id':doc_id, 'day':day},
            //dataType: 'json',
            success:function(data) {

                $('#ScheduleList').html(data);
                $('#schedule').select2({
                    placeholder: 'Select an option'
                });
            }
        });

    }
</script>

<script>
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

    function get_row(row_id) {

       $('#row_id_comment').val(row_id);

    }
</script>
