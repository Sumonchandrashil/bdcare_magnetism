@include('frontend.header')


<!-- ###########################
    ASK A DOCTOR SECTION
########################### -->


<section class="askDoctor">

    <div class="container-fluid">

        <div class="row package-header">
            <div class="col-md-12">
                <h1>{{$health_package->package_name}}</h1>

                <h4>(Ideal for person aged: {{$health_package->age_group}})</h4>
            </div>
        </div>
        <div class="container">
            @if(session()->has('successMsg'))
                <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn"
                     role="alert">
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
            <div class="booking-content">
                <div class="row">
                    <div class="col-md-5">
                        <div class="package-summary">
                            <h4>This package includes {{$health_package->no_of_tests}} tests</h4>
                            <p>{{$health_package->description}}  </p>
                            <ul>
                                <li><i class="fas fa-check"></i>{{$health_package->discount}}% Off</li>
                                <li>
                                    <i class="fas fa-check"></i>{{$health_package->price-($health_package->price*$health_package->discount)/100 }}
                                    /-
                                </li>
                                <li><i class="fas fa-check"></i><strike>{{$health_package->price}}/-</strike></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="booking-form">
                            <h4>Patient Details</h4>

                            <form action="{{url('submit_package')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group booking-date">
                                    <div class="form-column">
                                        <label>Probable booking date : </label>
                                    </div>
                                    <div class="form-column">
                                        <input type="date" name="book_date" placeholder="D/M/Y" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Patient's Name :
                                        <span> (Report will be generated with this name)</span></label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Patient's Address : </label>
                                    <input type="text" name="address" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <div class="form-column">
                                        <label>Age : </label>
                                        <input type="number" name="age" min="0" class="form-control">
                                    </div>
                                    <div class="form-column">
                                        <label>Gender : </label>
                                        <select name="gender" class="form-control">
                                            <option value="" selected>Select gender</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                            <option value="O">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number : </label>
                                    <input type="number" name="number" minlength="10" min="0" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Email : <span>(Your report will be send on this email address)</span></label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                                <div class="agree-box">
                                    <label>Home sample collection needed or not ?</label>
                                    <input type="radio" value="1" name="sample_collection">Yes
                                    <input type="radio" value="0" name="sample_collection">No
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="package_id" class="mobBtn" value="<?=$package_id;?>">
                                </div>


                                <div class="booking-btn">
                                    <input type="submit" value="Submit" class="submitQuestion">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>


@include('frontend.footer')


<script>

    $(document).ready(function () {

        $(".selectSpeciality").click(function () {
            $(".specialityPanel").slideToggle('slow', function () {

            });
        });

    });

</script>
