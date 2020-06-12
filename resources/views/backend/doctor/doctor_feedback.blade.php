<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
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
    <div class='table-responsive'>
        <div style="overflow-x:auto;">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>SL#</th>
                    <th>Patient Name</th>
                    <th>Comment</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;?>
                @foreach($doc_feedback_data as $doc_data)
                    <tr>
                        <td><?=$i++?></td>
                        <td>{{$doc_data->get_patient->patient_name}}</td>
                        <td>{{$doc_data->comment}}</td>
                        <td>{{dateConvertDBtoForm($doc_data->created_at)}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>SL#</th>
                    <th>Off Day</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('add-doctor-off-days')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add doctor Off Day</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Date</label>
                                <div class="input-group datepicker" data-provide="datepicker">
                                    <input type="date" class="form-control" name="doctor_off_day">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

</div>


<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{url('update-doctor-off-days')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" id="row_id">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Article Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Date</label>
                                <div class="input-group datepicker" data-provide="datepicker">
                                    <input type="date" class="form-control" name="doctor_off_day" id="doctor_off_day">
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#example').DataTable();
        // table.order( [ 0, 'asc' ] ).draw();

        // $('#example').DataTable();
    });

    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-3d'
    });

    function get_data(row_id) {
        $.ajax({
            type: 'GET',
            url: "{{url('editDoctorOffDays')}}",
            data: {'row_id': row_id},
            dataType: 'json',
            success: function (data) {
                $('#row_id').val(data.id);
                $('#doctor_off_day').val(data.doctor_off_day);
            }
        });
    }

</script>
