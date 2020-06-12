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
                    <th>Caller</th>
                    <th>Duration</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $index=>$data)
                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$data->ParticipantName}}</td>
                        <td>{{gmdate("H:i:s", $data->ParticipantDuration)}}</td>
                        <td>{{dateConvertDBtoForm($data->date)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
