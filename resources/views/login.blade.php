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
                <div class="loginPanelLeft">
                    <div class="loginImage">
                        <img src="{!! asset('assets/frontend/images/login.jpg') !!}">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="loginPanelRight">
                    <div class="loginForm" style="height: auto">
                        {!! Form::open(['url' => 'login','class'=>'m-login__form m-form']) !!}
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
                            <div class="form-group">

                                <input required type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your Mobile No" name="email"
                                       <?php
                                               if (Session::get('forget_pass_mobile_otp_login'))
                                                   { ?>
                                       value="<?=Session::get('forget_pass_mobile_otp_login');?>"
                                                 <?php  }
                                       ?>
                                       >
                            </div>
                            <div class="form-group">
                                <input required type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password" name="password">
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label remember" for="exampleCheck1">Remember me</label>
                            </div>
                            <a href="{{url('forget_pass')}}">Forgot Password</a>
                            <button type="submit" class="btn btn-primary loginBtn">Login</button>
                        {!! Form::close() !!}
                        {{--<hr style="margin-top: 30px;">
                        <a href="#" onclick="alert('Not Set Yet')">
                            <button class="btn btn-primary gmailLogin">
                                <i class="fab fa-google"></i>
                                Login with Gmail
                            </button>
                        </a>
                        <a href="#" onclick="alert('Not Set Yet')">
                            <button class="btn btn-primary fbLogin">
                                <i class="fab fa-facebook-f"></i>
                                Login with Facebook
                            </button>
                        </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@include('frontend.footer')
