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


    <div>
        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" ><span class="text-white">Create Prescription</span></a>
    </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 130%">
                    <form action="{{url('prescription_data')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="row_id" id="row_id" >
                        <input type="hidden" name="patient_id" id="patient_id">

                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Prescription</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <h5 align="right"> <b>Date:</b> {{date('d-M-y')}}</h5>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Findings</label>
                                    <textarea type="text" class="form-control" name="history" placeholder="History" ></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    {{--<label for="inputCity">Medication</label>
                                    <textarea type="text" class="form-control" name="diagonosis" placeholder="Diagonosis" ></textarea>--}}
                                    <table class="table table-bordered" id="re_table">
                                        <thead>
                                        <tr>
                                            <th>Medicine</th>
                                            <th style="text-align: center">Type</th>
                                            <th style="text-align: center">Dose</th>
                                            <th style="text-align: center">Before Meal</th>
                                            <th style="text-align: center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-control select2 search" name="medicine[]" id="medicine" required style="width: 100%">
                                                    @foreach($medicines as $medicine)
                                                        <option value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td align="center">
                                                <select name="type[]">
                                                    <option value="cap">Cap</option>
                                                    <option value="sirup">Sirup</option>
                                                    <option value="tablet">Tablet</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="morning[]" placeholder="Morning" style="width: 30%" required>
                                                <input type="number" name="noon[]" placeholder="Noon" style="width: 30%" required>
                                                <input type="number" name="night[]" placeholder="Night" style="width: 30%" required>
                                            </td>
                                            <td align="center"><input type="checkbox" name="meal[]" class=""></td>
                                            <td align="center"><a href="#" onclick="add_row()"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Tests/Suggested Diogonosis</label>
                                    <textarea type="text" class="form-control" name="tests" placeholder="Tests" ></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Recommendation</label>
                                    <textarea type="text" class="form-control" name="recommendation" placeholder="Recommendation" ></textarea>
                                </div>
                            </div>

                            <div class="form-row" style="display: none">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Description</label>
                                    <textarea type="text" class="form-control" name="description" placeholder="Description" ></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal 2 -->
        <div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 130%">
                    <form action="{{url('prescription_data_update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Prescription</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modal_dt">


                        <!--
                            <input type="hidden" name="row_id" id="row_id2">
                            <h5 align="right"> <b>Date:</b> {{date('d-M-y')}}</h5>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Findings</label>
                                    <textarea type="text" class="form-control" name="history" id="history2" placeholder="History" ></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Medication</label>
                                    {{--<textarea type="text" class="form-control" name="diagonosis" id="diagonosis2" placeholder="Diagonosis" ></textarea>--}}
                                <table class="table table-bordered" id="re_table2">
                                    <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th style="text-align: center">Type</th>
                                        <th style="text-align: center">Dose</th>
                                        <th style="text-align: center">Before Meal</th>

                                        <th style="text-align: center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select class="form-control select2 search" name="medicine[]" id="medicine_s" required style="width: 100%">
                                                    @foreach($medicines as $medicine)
                            <option value="{{$medicine->id}}">{{$medicine->medicine_name}}</option>
                                                    @endforeach
                                </select>
                            </td>

                            <td align="center">
                                <select name="type[]">
                                                    <option value="cap">Cap</option>
                                                    <option value="sirup">Sirup</option>
                                                    <option value="tablet">Tablet</option>
                                                </select>
                                            </td>

                                            <td>
                                                <input type="number" name="morning[]" placeholder="Morning" style="width: 30%">
                                                <input type="number" name="noon[]" placeholder="Noon" style="width: 30%">
                                                <input type="number" name="night[]" placeholder="Night" style="width: 30%">
                                            </td>
                                            <td align="center"><input type="checkbox" name="meal[]" class=""></td>

                                            <td align="center"><a href="#" onclick="add_row2()"><i class="fa fa-plus" aria-hidden="true"></i></a></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Tests/Suggested Diagonosis</label>
                                    <textarea type="text" class="form-control" name="tests" id="tests2" placeholder="Tests" ></textarea>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Recommendation</label>
                                    <textarea type="text" class="form-control" name="recommendation" id="recommendation2" placeholder="Recommendation" ></textarea>
                                </div>
                            </div>

                            <div class="form-row" style="display: none">
                                <div class="form-group col-md-12">
                                    <label for="inputCity">Description</label>
                                    <textarea type="text" class="form-control" name="description" id="description2" placeholder="Description" ></textarea>
                                </div>
                            </div>
                            -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

</div>