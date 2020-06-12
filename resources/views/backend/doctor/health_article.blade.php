<!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<!-- Include Editor JS files. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">


<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info " data-toggle="modal" data-target="#exampleModal">ADD Health Article</button>

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
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
        <tr>
            <th>Title</th>
            <th>Details</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
/*        print_r($doc_data);
        */?>
        @foreach($doc_data as $doc_data)
            <tr>
                <td>{{$doc_data->title}}</td>
                <td>Click Edit to see details</td>
                <td>
                    <?php
                    if ($doc_data->image){?>
                    <img src="public/uploads/health_article/{{$doc_data->image}}" class="img img-responsive" width="50%">
                    <?php }else{ ?>
                        {{--<img src="{!! asset('assets/frontend/images/no_image.jpg') !!}" width="30%" height="30%">--}}
                        <img src="{!! asset('assets/frontend/images/no_image1.png') !!}" width="30%" height="30%">

                    <?php } ?>
                </td>
                <td>
                    <button type="button" id="edit"  class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="get_data(<?=$doc_data->id;?>);">Edit</button>
                    <a onclick="return confirm('Are you sure you want to delete this Article?');" class="btn btn-danger" href="{{url('DeleteHealthArticle')."/".$doc_data->id}}">Delete</a>
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Article Name</th>
            <th>Remarks</th>
			<th>Image</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{url('AddHealthArticle')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Article Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Title</label>
                                <input class="form-control" name="title" placeholder="Title of the article">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="description">Details</label>
                                <textarea class="note-editable panel-body textEditor" name="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Photo</label>
                            <input type="file" class="form-control" name="photo" >
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


<div class="container">
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{url('EditHealthArticle')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" id="row_id" >

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Article Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Title</label>
                                <input class="form-control" name="title2" id="title2">
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">

                                <label for="inputCity">Details</label>
                                <textarea class="form-control textEditorXXX" name="description2" id="description2" required></textarea>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Photo</label>
                            <input type="file" class="form-control" name="photo2" id="photo2">
                            <br>
                            <div id="targetLayer">

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


<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    $(document).ready(function() {
        $('.textEditor').summernote({
            dialogsInBody: true,
            height: 200,
            placeholder:'write here...',
        });
    });




    function get_data(row_id) {
        //alert(row_id);
        $('#description2').summernote('destroy');

        $.ajax({
            type:'GET',
            url:"{{url('getDataHealthArticle')}}",
            data: {'row_id':row_id},
            dataType: 'json',
            success:function(data) {

                $('#row_id').val(data.id);
                $('#title2').val(data.title);

                $('#description2').val(data.description);

                    setTimeout(function () {
                        $('#description2').summernote({
                            focus: true,
                            dialogsInBody: true,
                            height: 200,                            
                        });
                        console.log(data.description)
                    },500);

                if(data.image)
                {
                    $("#targetLayer").html('<img src="public/uploads/health_article/'+data.image+'" width="150px"  class="responsive" />');
                }

                //$("#photo2").load(data.image);

            }
        });

    }
</script>
