
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info " data-toggle="modal" data-target="#exampleModal">ADD Medical Records</button>

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
            <th>Title</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $doc_data)
            <tr>
                <td>{{$doc_data->title}}</td>
                <td align="center">
                    <?php

                    if ($doc_data->image){?>
                    <a href="{{url('uploads/medical_records/'.$doc_data->image)}}"><embed src="uploads/medical_records/{{$doc_data->image}}" width="20%"></a>
                    <?php }else{ ?>
                    Not Set
                    <?php } ?>
                </td>
                <td>

                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="get_data(<?=$doc_data->id;?>);">Edit</button>

                    <a onclick="return confirm('Are you sure you want to delete this Specialty?');" class="btn btn-danger" href="{{url('DeleteMedicalRecord')."/".$doc_data->id}}">Delete</a></td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Title</th>
            <th>Image</th>
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
                <form action="{{url('AddMedicalRecord')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Medical Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Title</label>
                                <input class="form-control" name="title" placeholder="Ex: X-ray, CT Scan">
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Photo</label>
                            <input type="file" class="form-control" name="photo">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Data</button>
                        </div>
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
                <form action="{{url('EditMedicalRecord')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" id="row_id" >

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Medical Record</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Title</label>
                                <input class="form-control" name="title2" id="title2" placeholder="Ex: X-ray, CT Scan">
                            </div>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Photo</label>
                            <input type="file" class="form-control" name="photo2" id="photo2">
                            <br>
                            <div id="targetLayer">

                            </div>
                            {{--<img src="uploads/health_article/" class="img img-responsive" width="50%">--}}

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Data</button>
                        </div>
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
            url:"{{url('getDataMedicalRecord')}}",
            data: {'row_id':row_id},
            dataType: 'json',
            success:function(data) {

                $('#row_id').val(data.id);
                //var val2 = data.speciality_id;
                //console.log(data);
                $('#title2').val(data.title);

                if(data.image)
                {
                    $("#targetLayer").html('<img src="uploads/medical_records/'+data.image+'" width="150px"  class="responsive" />');
                }

                //$("#photo2").load(data.image);

            }
        });

    }
</script>
