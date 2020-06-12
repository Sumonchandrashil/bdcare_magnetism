@include('frontend.header')

<!-- ###########################
    LOGIN SECTION
########################### -->


<section class="login">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                <div class="loginBar">
                    <ul>
                        <li>
                            <a href="{{ url('admin-login') }}">
                                <i class="fas fa-sign-in-alt"></i><span>Login</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('register') }}">
                                <i class="fas fa-user-plus"></i><span>Register</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="loginPanelRight">
                    <div class="loginForm" style="height: auto">
                        <h5 align="center"><u>OTP Verification</u></h5>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                {!! Form::open(['url' => 'validatingsignup','class'=>'m-login__form m-form']) !!}

                                @if(session()->has('code'))
                                    <div class="m-alert m-alert--outline alert alert-success alert-dismissible animated fadeIn" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                        <span>Please insert the provided secret code correctly{{--{{ session()->get('code') }}--}}</span>
                                    </div>
                                @endif


                                <div class="form-group">
                                    {{--<input type="hidden" name="vali_code" value="{{ session()->get('code') }}">--}}
                                    <input type="number" class="form-control" id="secret_code" name="secret_code" placeholder="write your secret code" autocomplete="off">
                                </div>

                                <small style="text-align: center">
                                    Click here for another code <span style="font-weight: bold;"><a href="#">resend code</a></span>
                                </small>

                                <input type="hidden" name="type" value="4">

                                <button type="submit" class="btn btn-primary loginBtn">Verify</button>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="loginPanelLeft">
                    <div class="loginImage">
                        <img src="{!! asset('assets/frontend/images/login.jpg') !!}">
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@include('frontend.footer')
