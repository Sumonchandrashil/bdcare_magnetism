
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<style>
    .select2-container{
        border: 1px solid silver;
        border-radius: 5px;
    }
</style>
<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info " data-toggle="modal" data-target="#exampleModal">ADD Speciality</button>

    <br><br>

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
            <th>Speciality Name</th>
            <th>Training</th>

            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($doc_data as $doc_data)
            <tr>
                <td>{{$doc_data->get_speciality ? $doc_data->get_speciality->speciality_name : ''}}</td>
                <td>{{$doc_data->remarks}}</td>
                <td>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="get_data(<?=$doc_data->id;?>);">Edit</button>

                    <a onclick="return confirm('Are you sure you want to delete this Specialty?');" class="btn btn-danger" href="{{url('DeleteSpeciality')."/".$doc_data->id}}">Delete</a></td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Speciality Name</th>
            <th>Training</th>

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
                <form action="{{url('AddSpeciality')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Speciality Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Speciality</label>
                                <select class="form-control select2 search" id="speciality" name="speciality" required style="width: 100%">
                                    @foreach($speciality as $speciality_item)
                                        <option value="{{$speciality_item->id}}">{{$speciality_item->speciality_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Training if any(Optional)</label>
                                <textarea class="form-control" name="remarks" placeholder="Write about your training related practice"></textarea>
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


<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{url('EditSpeciality')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" id="row_id" >

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Speciality Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Speciality</label>
                                <select class="form-control select2 search" name="speciality2" id="speciality2" required style="width: 100%">
                                    @foreach($speciality as $speciality_item)
                                        <option value="{{$speciality_item->id}}">{{$speciality_item->speciality_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Training if any(Optional)</label>
                                <textarea class="form-control" name="remarks2" id="remarks2"></textarea>
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




<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    function get_data(row_id) {
        //alert(row_id);
        $.ajax({
            type:'GET',
            url:"{{url('getDataSpeciality')}}",
            data: {'row_id':row_id},
            dataType: 'json',
            success:function(data) {

                $('#row_id').val(data.id);
                var val2 = data.speciality_id;
                //console.log(data);
                $('#speciality2 option[value='+val2+']').attr('selected','selected');
                $('#remarks2').val(data.remarks);

                $('#speciality2').select2({
                    data: val2
                });

            }
        });

    }
</script>
