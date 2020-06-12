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

            <div class="col-lg-8 col-md-8 col-xs-12 offset-md-2">
                <div class="loginPanelRight">
                    <div class="loginForm" style="height: auto">
                        {!! Form::open(['url' => 'forget-pass','class'=>'m-login__form m-form']) !!}
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
                        {{--<div class="form-group">
                            <input required type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email" name="email">
                        </div>--}}
                        <div class="form-group">
                            <input required type="number" class="form-control" id="exampleInputMobile1" placeholder="Enter your Mobile Number" name="mobile">
                        </div>

                        <a href="{{url('admin-login')}}">Go back to login</a>
                        <button type="submit" class="btn btn-primary loginBtn">Submit</button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>


@include('frontend.footer')
