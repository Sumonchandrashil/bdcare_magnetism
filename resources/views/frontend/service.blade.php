@include('frontend.header')



<!-- ###########################
    SERVICE DETAILS SECTION
########################### -->





<section class="askDoctor package-details">
    <div class="container-fluid">
        <div class="row package-header">
            <div class="col-md-12">
                <h3>{{ $Service->name }}</h3>

                <h4>Available from {{date('d-M-Y',strtotime($Service->service_date))}}</h4>
            </div>
        </div>
        <div class="container">
            <div class="booking-content package-details-content">
                <div class="row">
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
                    <div class="col-md-12 package-description">
                        <h4>Service Details</h4>
                        <p>{{ $Service->details }}</p>
                    </div>
                    <div class="col-md-5">
                        <div class="products-info">
                            @if(isset($Service->image)!="")
                                <img src="{{url('/public').$Service->image}}">
                            @else
                                <img width="50%" class="img-fluid rounded" src="{{url('img/service.jpeg')}}">
                            @endif

                            <table>
                                <tbody>
                                <tr>
                                    <td>HotLine <span style="font-size: 12px">(Call for Urgent Booking)</span></td>
                                    <td>{{ $Service->hot_line_number }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-7" style="background: #f6f6f6; padding:15px 15px 30px; ">
                        <div class="package-summary">
                            <h4>Terms & Conditions</h4>
                            <div style="max-height: 450px; overflow-y: auto">
                                <h5>Terms</h5>
                                <p>{{ $Service->terms }}</p>
                                <h5>Conditions</h5>
                                <p>{{ $Service->conditions }}</p>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 offset-md-3 mt-4" >

                        <div class="booking-form">
                            <h4>Patient Details</h4>

                            <form action="{{url('submit_service')}}" method="post" enctype="multipart/form-data">
                                @csrf

                                <?php

                                if($user_data != '')
                                {
                                    $name = $user_data->name;
                                    $number = $user_data->number;
                                    $address = $user_data->address;
                                    $email = $user_data->email;
                                    $age = $user_data->age;
                                    $gender = $user_data->gender;

                                }
                                else
                                {
                                    $name = '';
                                    $number = '';
                                    $address = '';
                                    $email = '';
                                    $age = '';
                                    $gender = '';
                                }

                                ?>

                                <div class="form-group booking-date">
                                    <div class="form-column">
                                        <label>Probable booking date : </label>
                                    </div>
                                    <div class="form-column">
                                        <input type="date" name="bookdate" placeholder="D/M/Y"  class="form-control" required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Patient's Name : </label>
                                    <input type="text" name="name" value=" {{ $name }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Patient's Address : </label>
                                    <input type="text" name="address" value=" {{ $address }}" class="form-control" required>
                                </div>
                                {{--<div class="form-group">
                                    <label>Issue Details : </label>
                                    <textarea name="details" class="form-control" placeholder="Write require issue details"></textarea>
                                </div>--}}
                                <div class="form-group">
                                    <div class="form-column">
                                        <label>Age : </label>
                                        <input type="number" name="age" value="{{ $age }}" class="form-control">
                                    </div>
                                    <div class="form-column">
                                        <label>Gender : </label>
                                        <select name="gender" class="form-control">
                                            <option <?php if ($gender==''){?> selected <?php } ?> value="{{$gender}}">Select Gender</option>
                                            <option <?php if ($gender=='M'){?> selected <?php } ?> value="M" >Male</option>
                                            <option <?php if ($gender=='F'){?> selected <?php } ?> value="F" >Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Mobile Number : </label>
                                    <input type="text" name="number" value=" {{$number}}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Email : <span></span></label>
                                    <input type="email" name="email" value=" {{ $email }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="service_id"  class="mobBtn" value="<?=$service_id;?>">
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
        {{--New design ( client requirement )--}}
    </div>
</section>


@include('frontend.footer')
