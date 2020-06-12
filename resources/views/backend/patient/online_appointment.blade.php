<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<h3 align="center">Call a Doctor using his/her speciality</h3>

<div class="profileContent" style="padding: 25px">


            <div class="form-row" style="margin-left: 0px;">
                <div class="form-group col-md-6 offset-3" style="text-align: center;border: 1px solid black;border-radius: 12px;background-color: white;">
                    <label for="inputCity"><b>Speciality</b></label>
                    <select class="form-control select2 search" name="Speciality" id="Speciality" onchange="filter_doc();" style="width: 100%;border: 1px solid black">
                        <option value="">Select Speciality</option>
                        @foreach($specialities as $speciality)
                            <option value="{{$speciality->id}}" >{{$speciality->speciality_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

    <div class='table-responsive'>
        <div id="doc_datas" style="overflow-x:auto;">



        </div>
    </div>



</div>

<script type="text/javascript">

    function filter_doc() {
        var speciality_id = $('#Speciality').val();

        $.ajax({
            type:'get',
            url:"{{url('getDocDataUsingSpeciality')}}",
            data: {'speciality_id':speciality_id},
            success:function(data) {

                console.log(data);

                $('#doc_datas').html(data);

                $(document).ready(function() {
                    $('#example').DataTable();
                } );

            }
        });

    }
</script>
