<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>BDCare | Login</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->

		<!--begin::Global Theme Styles -->
		<link href="{!! asset('assets/vendors/base/vendors.bundle.css') !!}" rel="stylesheet" type="text/css" />


		<!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="{!! asset('assets/demo/default/base/style.bundle.css') !!}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->
		<link rel="shortcut icon" href="{!! asset('assets/demo/default/media/img/logo/favicon.ico') !!}" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login" style="background-image: url({!! asset('assets/app/media/img//bg/bg-3.jpg') !!});">
				<div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
					<div class="m-login__container">
						<div class="m-login__logo">
							<a href="{{ url('/') }}">
								<img src="{!! asset('assets/app/media/img/logos/bdcare-logo.png') !!}" width="300px">
							</a>
						</div>
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Log In To BDCare</h3>
							</div>
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

								<div class="form-group m-form__group">
									<input class="form-control m-input" type="text" placeholder="Email" name="email">
								</div>
								<div class="form-group m-form__group">
									<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password" autocomplete="off">
								</div>
								<div class="row m-login__form-sub">
									<div class="col m--align-left m-login__form-left">
										<label class="m-checkbox  m-checkbox--focus">
											<input type="checkbox" name="remember"> Remember me
											<span></span>
										</label>
									</div>
									<div class="col m--align-right m-login__form-right">
										<a href="javascript:;" id="m_login_forget_password" class="m-link">Sign Up</a>
									</div>
								</div>
								<div class="m-login__form-action">
									<button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Log In</button>
								</div>
							{!! Form::close() !!}
						</div>
						<div class="m-login__forget-password">
							<div class="m-login__head">
								<h3 class="m-login__title">Sign Up Here</h3>
								<div class="m-login__desc">Enter your Name, Email & Password:</div>
							</div>

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

                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Name" name="name" id="name" autocomplete="off">
                                <input class="form-control m-input" type="email" placeholder="Email" name="email" id="m_email" autocomplete="off">
                                <input class="form-control m-input" type="number" placeholder="Mobile" name="mobile" id="mobile" autocomplete="off">
                                <input class="form-control m-input" type="password" placeholder="password" name="password" id="m_password" autocomplete="off">
                                <input class="form-control m-input" type="password" placeholder="confirm password" name="conf_password" id="conf_password" autocomplete="off">

                            </div>
                            <br>
                            <div class="form-group m-form__group" align="">

                                <select id="type" name="type" class="form-control m-bootstrap-select m_selectpicker select2" style="width: 100%;border-radius: 12px;">

                                    <option value="0" > Select User Type </option>
                                    <option value="4" > Patient </option>
                                    <option value="3" > Doctor </option>
                                </select>
                            </div>

                            <div class="m-login__form-action">
                                <button type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Log In</button>
                                <button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom m-login__btn">Cancel</button>
                            </div>
                            {!! Form::close() !!}
						</div>

					</div>
				</div>
			</div>
		</div>

        <script>
            var Select2= {
                init:function() {
                    $(".select2").select2( {
                            placeholder: "Please select an option"
                        }
                    )
                }
            };
            jQuery(document).ready(function() {
                    Select2.init()
                }
            );
        </script>
		<!-- end:: Page -->
        <link href="{!! asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js') !!}" rel="stylesheet" type="text/css" />
		<!--begin::Global Theme Bundle -->
		<script src="{!! asset('assets/vendors/base/vendors.bundle.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/base/scripts.bundle.js') !!}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		<script src="{!! asset('assets/snippets/custom/pages/user/login.js') !!}" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>
