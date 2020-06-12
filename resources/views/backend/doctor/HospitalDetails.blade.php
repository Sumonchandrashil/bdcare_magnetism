
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="{{url('assets/clockpicker/dist/bootstrap-clockpicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/clockpicker/assets/css/github.min.css')}}">

<style>
    .select2-container{
        border: 1px solid silver;
        border-radius: 5px;
    }
</style>

<div class="profileContent" style="padding: 50px">

    <button class="btn btn-info " data-toggle="modal" data-target="#exampleModal">ADD Hospital Data</button>

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
            <th>Hospital Name</th>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($doc_data as $doc_data)
            <tr>
                <td>{{$doc_data->get_hospital ? $doc_data->get_hospital->hospital_name : ''}}</td>
                <td>{{$doc_data->day}}</td>
                <td>{{date("g:i a", strtotime($doc_data->f_time))}}</td>
                <td>{{date("g:i a", strtotime($doc_data->s_time))}}</td>

                <td><button class="btn btn-info" data-toggle="modal" data-target="#exampleModal2" onclick="get_data(<?=$doc_data->id;?>);">Edit</button>&nbsp;
                    <a onclick="return confirm('Are you sure you want to delete this Hospital?');" class="btn btn-danger" href="{{url('DeleteHospitalDetails')."/".$doc_data->id}}">Delete</a></td>

            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th>Hospital Name</th>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>

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
                <form action="{{url('AddHospitalData')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="row_id" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hospital Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputCity">Hospital</label>
                                <select class="form-control select2 search" name="hospital" required style="width: 100%">
                                    @foreach($hospital as $hospital_item)
                                        <option value="{{$hospital_item->id}}">{{$hospital_item->hospital_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">

                                <table class="table table-bordered" id="re_table">
                                    <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th style="text-align: center">Start Time</th>
                                        <th style="text-align: center">End Time</th>
                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>

                                                <select class="form-control select2 search" name="day[]" style="width: 100%">

                                                    <option value="Sat">Sat</option>
                                                    <option value="Sun">Sun</option>
                                                    <option value="Mon">Mon</option>
                                                    <option value="Tue">Tue</option>
                                                    <option value="Wed">Wed</option>
                                                    <option value="Thu">Thu</option>
                                                    <option value="Fri">Fri</option>

                                                </select>
                                            </td>
                                            <td>

                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                    <input placeholder="Use 24hr format" type="text" class="form-control" name="f_time[]" required autocomplete="off">
                                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                                </div>
                                            </td>
                                            <td>

                                                <div class="input-group clockpicker_S" data-placement="left" data-align="top" data-autoclose="true">
                                                    <input type="text" placeholder="Use 24hr format" class="form-control" name="s_time[]" required autocomplete="off">
                                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                                                </div>
                                            </td>
                                            <td>

                                                <div  class="input-group" data-placement="center" data-align="top" data-autoclose="true">
                                                    <div align="center"><a href="#" onclick="add_row()">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;</a></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
            <form action="{{url('EditHospitalData')}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="row_id" id="row_id" >
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hospital Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputCity">Hospital</label>
                            <select class="form-control select2 search" name="hospital2" id="hospital2" required style="width: 100%">
                                @foreach($hospital as $hospital_item)
                                    <option value="{{$hospital_item->id}}">{{$hospital_item->hospital_name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Day</label>
                            <select class="form-control select2 search" name="day2" id="day2" style="width: 100%">

                                <option value="Sat">Sat</option>
                                <option value="Sun">Sun</option>
                                <option value="Mon">Mon</option>
                                <option value="Tue">Tue</option>
                                <option value="Wed">Wed</option>
                                <option value="Thu">Thu</option>
                                <option value="Fri">Fri</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputCity">Start Time</label>
                            {{--<input type="time" class="form-control" name="f_time2" id="f_time2" required>--}}
                            <div class="input-group clockpicker2" data-placement="left" data-align="top" data-autoclose="true">
                                <input type="text" class="form-control" name="f_time2" id="f_time2" required autocomplete="off">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputCity">End Time</label>
                            {{--<input type="time" class="form-control" name="s_time2" id="s_time2" required>--}}
                            <div class="input-group clockpicker_S2" data-placement="left" data-align="top" data-autoclose="true">
                                <input type="text" class="form-control" name="s_time2" id="s_time2" required autocomplete="off">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-time"></span>
                                </span>
                            </div>
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
    $(document).ready(function() {
        $('#example').DataTable();
    } );

    function get_data(row_id) {
        //alert(row_id);
        $.ajax({
            type:'GET',
            url:"{{url('getDataHospital')}}",
            data: {'row_id':row_id},
            dataType: 'json',
            success:function(data) {

                $('#row_id').val(data.id);
                var val2 = data.hospital_id;
                var val3 = data.day;
                //console.log(data);
                $('#hospital2 option[value='+val2+']').attr('selected','selected');
                $('#f_time2').val(data.f_time);
                $('#s_time2').val(data.s_time);
                $('#day2 option[value='+val3+']').attr('selected','selected');

                $('#hospital2').select2({
                    data: val2
                });

                $('#day2').select2({
                    data: val3
                });

            }
        });

    }

    function add_row() {
        var i = document.getElementById('re_table').getElementsByTagName("tr").length;

        var row_str = '<td><select class="form-control select2 search" name="day[]" id="day'+ i +'" style="width: 100%"><option value="Sat">Sat</option> <option value="Sun">Sun</option><option value="Mon">Mon</option><option value="Tue">Tue</option><option value="Wed">Wed</option><option value="Thu">Thu</option><option value="Fri">Fri</option></select> </td> <td> <div class="input-group clockpicker'+ i +'" data-placement="left" data-align="top" data-autoclose="true"> <input type="text" class="form-control" name="f_time[]" required autocomplete="off" placeholder="Use 24hr format"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span> </div> </td> <td> <div class="input-group clockpicker_S'+ i +'" data-placement="left" data-align="top" data-autoclose="true"> <input type="text" placeholder="Use 24hr format" class="form-control" name="s_time[]" required autocomplete="off"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span> </div> </td> <td> <div  class="input-group" data-placement="center" data-align="top" data-autoclose="true"> <div align="center"><button type="button" class="remove btn btn-danger btn-sm">Remove</button></div> </div> </td>' ;


        $('#re_table tr:last').after('<tr>' + row_str + '</tr>');



        $('#day'+i).select2({
            placeholder: 'Select an option'
        });



        $('.clockpicker'+i).clockpicker();
        $('.clockpicker_S'+i).clockpicker();


    }

    $(document).on("click", "table#re_table button.remove", function ()
    {
        $(this).parents("tr").remove();
    });
</script>

<script type="text/javascript">
    $('.clockpicker').clockpicker();
    $('.clockpicker_S').clockpicker();

    $('.clockpicker2').clockpicker();
    $('.clockpicker_S2').clockpicker();

</script>

<script type="text/javascript" src="{{url('assets/clockpicker/dist/bootstrap-clockpicker.min.js')}}"></script>

<script type="text/javascript">
    $('.clockpicker').clockpicker()
        .find('input').change(function(){
        console.log(this.value);
    });
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $('.clockpicker-with-callbacks').clockpicker({
        donetext: 'Done',
        init: function() {
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    })
        .find('input').change(function(){
        console.log(this.value);
    });

    // Manually toggle to the minutes view
    $('#check-minutes').click(function(e){
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
</script>

<script type="text/javascript">
    $('.clockpicker_S').clockpicker()
        .find('input').change(function(){
        console.log(this.value);
    });
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $('.clockpicker-with-callbacks').clockpicker({
        donetext: 'Done',
        init: function() {
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    })
        .find('input').change(function(){
        console.log(this.value);
    });

    // Manually toggle to the minutes view
    $('#check-minutes').click(function(e){
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });

    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
</script>

<script type="text/javascript">
    $('.clockpicker2').clockpicker()
        .find('input').change(function(){
        console.log(this.value);
    });
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $('.clockpicker-with-callbacks').clockpicker({
        donetext: 'Done',
        init: function() {
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    })
        .find('input').change(function(){
        console.log(this.value);
    });

    // Manually toggle to the minutes view
    $('#check-minutes').click(function(e){
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
</script>

<script type="text/javascript">
    $('.clockpicker_S2').clockpicker()
        .find('input').change(function(){
        console.log(this.value);
    });
    var input = $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });

    $('.clockpicker-with-callbacks').clockpicker({
        donetext: 'Done',
        init: function() {
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    })
        .find('input').change(function(){
        console.log(this.value);
    });

    // Manually toggle to the minutes view
    $('#check-minutes').click(function(e){
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show')
            .clockpicker('toggleView', 'minutes');
    });

    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
</script>


<script type="text/javascript" src="{{url('assets/clockpicker/assets/js/highlight.min.js')}}"></script>
<script type="text/javascript">
    hljs.configure({tabReplace: '    '});
    hljs.initHighlightingOnLoad();
</script>
