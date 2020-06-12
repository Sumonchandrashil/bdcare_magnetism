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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Patient</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Doctor</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                {!! Form::open(['url' => 'signup','class'=>'m-login__form m-form']) !!}
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
                                        <input type="text" value="{{ old('name') }}" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Enter your Full name">
                                        @if($errors->has('name')) <span class="validation_msg" style="color: red"> <strong> {{ $errors->first('name') }} </strong> </span> @endif
                                    </div>
                                    {{--<div class="form-group">
                                        <input type="email" value="{{ old('email') }}" class="form-control" id="exampleInputPassword1" name="email" placeholder="Enter your email">
                                        @if($errors->has('email')) <span class="validation_msg" style="color: red"> <strong> {{ $errors->first('email') }} </strong> </span> @endif
                                    </div>--}}
                                    <div class="form-group">
                                        <input type="text" value="{{ old('mobile') }}" class="form-control" id="exampleInputMobile1" name="mobile" aria-describedby="emailHelp" placeholder="Enter your Mobile number" autocomplete="off">
                                        @if($errors->has('mobile')) <span class="validation_msg" style="color: red"> <strong> {{ $errors->first('mobile') }} </strong> </span> @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter your Password">
                                        @if($errors->has('password')) <span class="validation_msg" style="color: red"> <strong> {{ $errors->first('password') }} </strong> </span> @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="conf_password" placeholder="Confirm password">
                                        @if($errors->has('conf_password')) <span class="validation_msg" style="color: red"> <strong> {{ $errors->first('conf_password') }} </strong> </span> @endif
                                    </div>
                                    <small>
                                        You are registering as <span style="font-weight: bold;">Patient</span>
                                    </small>
                                    <input type="hidden" name="type" value="4">
                                    <button type="submit" class="btn btn-primary loginBtn">Sign up</button>
                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                {!! Form::open(['url' => 'signup','class'=>'m-login__form m-form']) !!}
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
                                        <input type="text" value="{{ old('name') }}" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp" placeholder="Enter your Full name">
                                    </div>
                                    {{--<div class="form-group">
                                        <input type="email" value="{{ old('email') }}" class="form-control" id="exampleInputPassword1" name="email" placeholder="Enter your email">
                                    </div>--}}
                                    <div class="form-group">
                                        <input type="text" value="{{ old('mobile') }}" class="form-control" id="exampleInputMobile1" name="mobile" aria-describedby="emailHelp" placeholder="Enter your Mobile number" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Enter your Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="exampleInputPassword1" name="conf_password" placeholder="Confirm password">
                                    </div>
                                    <small>
                                        You are registering as <span style="font-weight: bold;">Doctor</span>
                                    </small>
                                    <input type="hidden" name="type" value="3">
                                    <button type="submit" class="btn btn-primary loginBtn">Sign up</button>
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
