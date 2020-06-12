<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<div class="profileContent" style="padding: 50px">
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
    <div class='table-responsive'><h3 align="center">You can see all ongoing and upcoming appointment here. Here you can
            manage your patient also</h3>
        <div style="overflow-x:auto;">
            <table id="example" class="display table " style="width:100%">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient Name</th>
                    <th>Want to meet you at</th>
                    <th>Day</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($appointment_data as $row)
                    <?php
                    $row_id = $row->id;
                    $patient_id = $row->patient_id;
                    ?>
                    <tr>
                        <td>{{$row->date}}</td>
                        {{--<td>{{DB::table('patient_datas')->where('created_by', $row->patient_id)->first()->patient_name}}</td>--}}
                        <td>{{$row->get_patient ? $row->get_patient->patient_name : ''}}</td>
                        <td>
                            <?php if(substr($row->hospital_id, 0, 1) != 0){?>

                            {{ $row->get_hospital ? $row->get_hospital->hospital_name : '' }}

                            <?php }else { ?>
                    <?php
                                //DB::enableQueryLog();
                                $clinic_row_id = substr($row->hospital_id, 1);
                                //\App\Model\BDCare\DoctorsClinicDetails::where('id',432)->get()->count();
                                //dd(DB::getQueryLog());
                                echo DB::table('doctors_clinic_details')->select('clinic')->where('id', $clinic_row_id)->first() ? DB::table('doctors_clinic_details')->select('clinic')->where('id', $clinic_row_id)->first()->clinic : 'Not Available'; ?>
                    <?php } ?>

                        </td>
                        <td>{{$row->day}}</td>
                        <td>{{date('g:i a', strtotime($row->schedule))}}</td>
                        <td>{{$row->status == 0 ? 'Not Confirmed' : 'Confirmed'}}</td>
                        <td style="color: white">
                            <?php if($row->status == 0){?>
                            <a href="{{url('patient_booking_status_update').'/'.$row->id}}" class="btn btn-info btn-sm">Confirm
                                Booking</a>
                            <?php }elseif($row->status == 1){?>
                            <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal"
                               onclick="push_data(<?=$row_id;?>,<?=$patient_id;?>);">Prescription</a>
                            <?php }elseif($row->status == 2){?>
                            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal2"
                                    onclick="get_data(<?=$row_id;?>)">Edit
                            </button>
                            <a style="color: white" class="btn btn-warning btn-sm"
                               href="{{url('view-prescription')."/".$row_id}}" target="_blank">View Prescription</a>
                            <?php }?>
                        </td>
                    </tr>
                @endforeach

                </tbody>
                {{--<tfoot>
                <tr>
                    <th>Patient Name</th>
                    <th>Hospital Name</th>
                    <th>Day</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>--}}
            </table>
            {{--<div class="float-right">{{ $appointment_data->links('vendor.pagination.bootstrap-4') }}</div>--}}
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width: 130%">
                <form action="{{url('prescription_data')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" id="row_id">
                    <input type="hidden" name="patient_id" id="patient_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Prescription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <h5 align="right"><b>Date:</b> {{date('d-M-y')}}</h5>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Findings</label>
                                <textarea type="text" class="form-control" name="history"
                                          placeholder="History"></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                {{--<label for="inputCity">Medication</label>
                                <textarea type="text" class="form-control" name="diagonosis" placeholder="Diagonosis" ></textarea>--}}
                                <table class="table table-bordered" id="re_table">
                                    <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th style="text-align: center">Type</th>
                                        <th style="text-align: center">Dose</th>
                                        <th style="text-align: center">Before Meal</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control select2 search" name="medicine[]" id="medicine"
                                                    required style="width: 100%">
                                                @foreach($medicines as $medicine)
                                                    <option
                                                        value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td align="center">
                                            <select name="type[]">
                                                <option value="cap">Cap</option>
                                                <option value="sirup">Sirup</option>
                                                <option value="tablet">Tablet</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="morning[]" placeholder="Morning"
                                                   style="width: 30%" required>
                                            <input type="number" name="noon[]" placeholder="Noon" style="width: 30%"
                                                   required>
                                            <input type="number" name="night[]" placeholder="Night" style="width: 30%"
                                                   required>
                                        </td>
                                        <td align="center"><input type="checkbox" name="meal[]" class=""></td>
                                        <td align="center"><a href="#" onclick="add_row()"><i class="fa fa-plus"
                                                                                              aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Tests/Suggested Diogonosis</label>
                                <textarea type="text" class="form-control" name="tests" placeholder="Tests"></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Recommendation</label>
                                <textarea type="text" class="form-control" name="recommendation"
                                          placeholder="Recommendation"></textarea>
                            </div>
                        </div>

                        <div class="form-row" style="display: none">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Description</label>
                                <textarea type="text" class="form-control" name="description"
                                          placeholder="Description"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade my-appointment" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="width: 130%">
                <form action="{{url('prescription_data_update')}}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Prescription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal_dt">


                    <!--
                            <input type="hidden" name="row_id" id="row_id2">
                            <h5 align="right"> <b>Date:</b> {{date('d-M-y')}}</h5>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Findings</label>
                                    <textarea type="text" class="form-control" name="history" id="history2" placeholder="History" ></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Medication</label>
                                    {{--<textarea type="text" class="form-control" name="diagonosis" id="diagonosis2" placeholder="Diagonosis" ></textarea>--}}
                        <table class="table table-bordered" id="re_table2">
                            <thead>
                            <tr>
                                <th>Medicine</th>
                                <th style="text-align: center">Type</th>
                                <th style="text-align: center">Dose</th>
                                <th style="text-align: center">Before Meal</th>

                                <th style="text-align: center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <select class="form-control select2 search" name="medicine[]" id="medicine_s" required style="width: 100%">
                                                    @foreach($medicines as $medicine)
                        <option value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>
                                                    @endforeach
                        </select>
                    </td>

                    <td align="center">
                        <select name="type[]">
                                                    <option value="cap">Cap</option>
                                                    <option value="sirup">Sirup</option>
                                                    <option value="tablet">Tablet</option>
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" name="morning[]" placeholder="Morning" style="width: 30%">
                                                <input type="number" name="noon[]" placeholder="Noon" style="width: 30%">
                                                <input type="number" name="night[]" placeholder="Night" style="width: 30%">
                                            </td>
                                            <td align="center"><input type="checkbox" name="meal[]" class=""></td>

                                            <td align="center"><a href="#" onclick="add_row2()"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Tests/Suggested Diagonosis</label>
                                    <textarea type="text" class="form-control" name="tests" id="tests2" placeholder="Tests" ></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Recommendation</label>
                                    <textarea type="text" class="form-control" name="recommendation" id="recommendation2" placeholder="Recommendation" ></textarea>
                                </div>
                            </div>

                            <div class="form-row" style="display: none">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Description</label>
                                    <textarea type="text" class="form-control" name="description" id="description2" placeholder="Description" ></textarea>
                                </div>
                            </div>
                            -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('#example').DataTable({
            "order": [[0, "desc"]]
            // "ordering": false,
            /*"ordering" : true,
            "scrollCollapse" : true,
            "searching" : true,
            //"columnDefs" : [{"targets":3, "type":"date"}],

            "columns": [
                { data: "date", "orderData": desc },
            ]*/
        });

    });

    function push_data(row_id, patient_id) {
        /*alert(row_id);
        alert(patient_id);*/

        $('#row_id').val(row_id);
        $('#patient_id').val(patient_id);
    }

    function get_data(row_id) {

        $.ajax({
            type: 'GET',
            url: "{{url('getDataForEditPrescription')}}",
            data: {'row_id': row_id},
            //dataType: 'json',
            success: function (data) {
                //var jsonData = parseJSON(data.diagonosis)
                /*$('#row_id').val(data.id);
                $('#history2').val(data.history);
                $('#description2').val(data.description);
                $('#diagonosis2').val(data.diagonosis);
                $('#tests2').val(data.tests);
                $('#recommendation2').val(data.recommendation);*/
                document.getElementById("modal_dt").innerHTML = data;

                var count = document.getElementById('re_table2').getElementsByTagName("tr").length;
                var l = 0;
                //alert(count);
                for (l = 0; l < count; l++) {
                    $('#medicine' + l).select2({
                        placeholder: 'Select an option'
                    });
                }

            }
        });

    }

    function add_row() {
        var i = document.getElementById('re_table').getElementsByTagName("tr").length;

        var row_str = '<td><select class="form-control select2 search" name="medicine[]" id="medicine' + i + '" required style="width: 100%">' + ' @foreach($medicines as $medicine)' + ' <option value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>' + '@endforeach' + '</select>' + ' </td><td align="center">   <select name="type[]">     <option value="cap">Cap</option>  <option value="sirup">Sirup</option> <option value="tablet">tablet</option> </select> </td> <td>' + ' <input required type="number" name="morning[]" placeholder="Morning" style="width: 30%">' + ' <input required type="number" name="noon[]" placeholder="Noon" style="width: 30%">' + '  <input required type="number" name="night[]" placeholder="Night" style="width: 30%">' + ' </td>' + ' <td align="center"><input type="checkbox" name="meal[]" class=""></td><td align="center"><button type="button" class="remove btn btn-danger btn-sm">Remove</button></td>';

        $('#re_table tr:last').after('<tr>' + row_str + '</tr>');

        $('#medicine' + i).select2({
            placeholder: 'Select an option'
        });

    }

    // Remove button functionality
    $(document).on("click", "table#re_table button.remove", function () {
        $(this).parents("tr").remove();
    });

    function add_row2() {

        var j = document.getElementById('re_table2').getElementsByTagName("tr").length;

        var row_str = '<td><select class="form-control select2 search" name="medicine[]" id="medicine' + j + '" required style="width: 100%">' + ' @foreach($medicines as $medicine)' + ' <option value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>' + '@endforeach' + '</select>' + ' </td>' + '<td align="center">   <select name="type[]">     <option value="cap">Cap</option>  <option value="sirup">Sirup</option> <option value="tablet">tablet</option> </select> </td>' + ' <td>' + ' <input required type="number" name="morning[]" placeholder="Morning" style="width: 30%">' + ' <input required type="number" name="noon[]" placeholder="Noon" style="width: 30%">' + '  <input required type="number" name="night[]" placeholder="Night" style="width: 30%">' + ' </td>' + ' <td align="center"><input type="checkbox" name="meal[]" class=""></td><td align="center"><button type="button" class="remove btn btn-danger btn-sm">Remove</button></td>';

        $('#re_table2 tr:last').after('<tr>' + row_str + '</tr>');

        $('#medicine' + j).select2({
            placeholder: 'Select an option'
        });

    }

    // Remove button functionality
    $(document).on("click", "table#re_table2 button.remove", function () {
        $(this).parents("tr").remove();
    });
</script>
