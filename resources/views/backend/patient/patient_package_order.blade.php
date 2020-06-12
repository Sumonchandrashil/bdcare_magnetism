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
            <table id="example" class="display table" style="width:100%">
                <thead>
                <tr>
                    <th>SL#</th>
                    <th>Booking Date</th>
                    <th>Package Name</th>
                    <th>Patient's Name</th>
                    <th>Patient's Address</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                    <th>Sample Collection</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $index=>$data)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{dateConvertDBtoForm($data->book_date)}}</td>
                        <td>{{$data->package_name}}</td>
                        <td>{{$data->name}}</td>
                        <td>{{$data->address}}</td>
                        <td>{{$data->age}}</td>
                        <td>{{$data->gender!=null?($data->gender=='M'?'Male':'Female'):''}}</td>
                        <td>{{$data->number}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->sample_collection==0?'No':($data->sample_collection==1?'Yes':'')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->


</div>

<div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{url('ReplyOnlineConsult')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="row_id" id="row_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reply to the Article</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">

                            <label for="inputCity">Answer</label>
                            <textarea class="form-control" name="reply"></textarea>

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
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
