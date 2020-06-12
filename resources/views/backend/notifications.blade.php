
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<div class="profileContent" style="padding: 50px">

    <div class='table-responsive'>  <div style="overflow-x:auto;">
            <table id="example" class="display table " style="width:100%">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Details</th>

                </tr>
                </thead>
                <tbody>
                @foreach($data as $doc_data)
                    <tr>
                        <td>{{$doc_data->title}}</td>
                        <td>
                            @if($doc_data->read_unread_status ==1)
                              {{$doc_data->details}}
                            @else
                                <div class="form-group" style="display: flex">

                                  <div style="width: 80%">{{substr($doc_data->details, 0, 50) . '...'}}</div>
                                    <form action="{{ url('read-unread') }}" method="POST" style="padding: 0 15px 0">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-sm btn-info" >Read</button>
                                        <input type="hidden" name="id" value="{{$doc_data->id}}">
                                    </form>

                                </div>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Title</th>
                    <th>Details</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Modal -->

</div>




<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
