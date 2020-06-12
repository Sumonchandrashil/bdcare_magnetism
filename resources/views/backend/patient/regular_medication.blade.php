
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style>
    .select2-container{
        border: 1px solid silver;
        border-radius: 5px;
    }
</style>
<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info " data-toggle="modal" data-target="#exampleModal">ADD Medication</button>
    <br><br>
    <span style="color: red">@foreach ($errors->all() as $error)
        {!! $errors->first() !!}
    @endforeach
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
            <th>Medication Name</th>
            <th>Details</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach($patient_data as $patient_row)
            <tr>
                {{--<td>{{$patient_row->medication_name}}</td>--}}
                <td> {{$patient_row->get_medicine ? $patient_row->get_medicine->medicine_name: ''}} </td>

                <td>{{$patient_row->description}}</td>
                <td>
                    <?php
                        if ($patient_row->status == 1 )
                            {
                                echo "Active";
                            }
                        elseif ($patient_row->status == 0)
                            {
                                echo "InActive";
                            }
                    ?>
                </td>
                <td>
                    <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal2" onclick="get_data(<?=$patient_row->id;?>)">Edit</button>&nbsp;
                    <a onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger" href="{{url('DeleteMedication').'/'.$patient_row->id}}">Delete</a></td>
            </tr>
                @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Medication Name</th>
            <th>Details</th>
            <th>Status</th>
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
                <form action="{{url('add_medication')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Drescription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Medicine Name</label>
                                {{--<input type="text" class="form-control" name="medication_name" placeholder="Title" ></input>--}}
                                <select class="form-control select2 search" name="medication_name" required style="width: 100%" >
                                    @foreach($medicines as $medicine)
                                    <option value="<?=$medicine->id;?>"><?=$medicine->medicine_name;?></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Detail</label>
                                <textarea type="text" class="form-control" name="detail" placeholder="Details About the Medication" ></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Status</label>
                                <input type="checkbox" class="form-control-feedback" name="status" value="1">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{url('update_medication')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" id="row_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Drescription</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Medicine Name</label>
                                {{--<input type="text" class="form-control" name="medication_name2" id="title2" placeholder="Title" ></input>--}}
                                <select class="form-control select2 search" name="medication_name2" id="title2" required style="width: 100%">
                                    @foreach($medicines as $medicine)
                                        <option value="<?=$medicine->id;?>"><?=$medicine->medicine_name;?></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Detail</label>
                                <textarea type="text" class="form-control" name="detail2" id="detail2" placeholder="Details About the Medication" ></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Status</label>
                                <input type="checkbox" class="form-control-feedback" name="status2" id="status2" >
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    function get_data(row_id) {

        $.ajax({
            type:'GET',
            url:"{{url('getMedication')}}",
            data: {'row_id':row_id},
            dataType: 'json',
            success:function(data) {

                $('#row_id').val(data.id);
                //$('#title2').val(data.medication_name);
                $('#title2 option[value='+data.medication_name+']').attr('selected','selected');
                $('#detail2').val(data.description);

                $('#title2').select2({
                    data: data.medication_name
                });

                if(data.status == '1')
                {
                    //$('#status2').val('checked');
                    $( "#status2" ).prop( "checked", true );
                }
                else if(data.status == 'null' || data.status == '0')
                {
                    //$('#status2').val('checked');
                    $( "#status2" ).prop( "checked", false );
                }

            }
        });

    }
</script>
