
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<style>
    .select2-container{
        border: 1px solid silver;
        border-radius: 5px;
    }
</style>

<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info push_js" data-toggle="modal" data-target="#exampleModal">ADD Degree</button>

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
    <table id="example" class="display table" style="width:100%">
        <thead>
        <tr>
            <th>Degree Name</th>
            <th>Institute</th>
            <th>Passing Year</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($doc_data as $doc_data)
            <tr>
                <td>{{$doc_data->get_degree ? $doc_data->get_degree->degree_name : ''}}</td>
                <td>{{$doc_data->institute}}</td>
                <td>{{$doc_data->passing_year}}</td>
                <td>
                    <button class="btn btn-info" data-toggle="modal" data-target="#exampleModal2" onclick="get_data(<?=$doc_data->id;?>)">Edit</button>&nbsp;
                    <a onclick="return confirm('Are you sure you want to delete this Degree?');" class="btn btn-danger" href="{{url('DeleteDegree')."/".$doc_data->id}}">Delete</a></td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Degree Name</th>
            <th>Institute</th>
            <th>Passing Year</th>
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
                <form action="{{url('AddDegree')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Degree Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Degree</label>
                                <select class="form-control select2 search" name="degree" id="degree" required style="width: 100%">


                                    @foreach($degreesss as $degree_item)
                                        <option value="{{$degree_item->id}}">{{$degree_item->degree_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Institute</label>
                                <textarea class="form-control" name="institute" required placeholder="Ex: Dhaka Medical, Appolo "></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Passing Year</label>
                                <input type="number" class="form-control" name="passing_year" id="passing_year" required placeholder="Year of Passing " />
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

<div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('EditDegree')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="row_id" id="row_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Degree Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCity">Degree</label>
                            <select class="form-control select2 search" name="degree2" id="degree2" required style="width: 100%">
                                @foreach($degreesss as $degree_itm)
                                    <option value="{{$degree_itm->id}}">{{$degree_itm->degree_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCity">Institute</label>
                            <textarea class="form-control" name="institute2" id="institute2" required placeholder="institute name "></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCity">Passing Year</label>
                            <input type="number" class="form-control" name="passing_year2" id="passing_year2" required placeholder="Year of Passing " />
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

    /*$(document).ready(function(){
        $(".push_js").click(function(){
            $('.select2').select2();
        });
    });*/



    $(document).ready(function() {
        $('#example').DataTable();
    } );

    function get_data(row_id) {
        //alert(row_id);
        $.ajax({
            type:'GET',
            url:"{{url('getDataDegree')}}",
            data: {'row_id':row_id},
            dataType: 'json',
            success:function(data) {

                $('#row_id').val(data.id);
                var val2 = data.degree_id;
                //console.log(data);
                $('#degree2 option[value='+val2+']').attr('selected','selected');
                $('#institute2').val(data.institute);
                $('#passing_year2').val(data.passing_year);
                $('#degree2').select2({
                    data: val2
                });

            }
        });

    }
</script>
