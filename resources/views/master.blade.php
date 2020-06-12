<!DOCTYPE html>
<html lang="en">
	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>BDCare | @yield('title')</title>
		<meta name="description" content="Multi column form examples">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script src="https://unpkg.com/vuejs-datepicker"></script>
		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
		<link rel="shortcut icon" href="{!! asset('assets/frontend/images/logo.png') !!}" />
		<!--end::Web font -->
		<!--begin::Global Theme Styles -->
		<link href="{!! asset('assets/vendors/base/vendors.bundle.css') !!}" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css') !!}" rel="stylesheet" type="text/css" />-->
		<link href="{!! asset('assets/demo/default/base/style.bundle.css') !!}" rel="stylesheet" type="text/css" />
		<!--Begin::Custom Style CSS -->
		<link href="{!! asset('assets/vendors/custom/datatables/datatables.bundle.css') !!}" rel="stylesheet" type="text/css" />
        <!--End::Custom Style CSS -->
		<!-- sweetalert-->
		<link rel="stylesheet" href="{!! asset('assets/sweetalert/sweetalert.css') !!}">
		<link href="{!! asset('assets/custom_style.css')!!}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="{!! asset('assets/media_print.css')!!}" media="print">
		<link rel="stylesheet" type="text/css" href="{!! asset('css/responsive.css') !!}">

        <!--lightbox-->
        <link rel="stylesheet" href="{!! asset('assets/lightbox/ekko-lightbox.css')!!}"/>

		<script type="text/javascript">
            var base_url = "{{ url('/').'/' }}";
            var current_url = "{{ url()->current() }}";
		</script>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body onLoad="activeMenu()" class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">

			<!-- BEGIN: Header -->
			<header id="m_header" class="m-grid__item m-header header-section-hide-print" m-minimize-offset="200" m-minimize-mobile-offset="200">
				<div class="m-container m-container--fluid m-container--full-height">
					<div class="m-stack m-stack--ver m-stack--desktop">

						<!-- BEGIN: Brand -->
						<div class="m-stack__item m-brand  m-brand--skin-light ">
							<div class="m-stack m-stack--ver m-stack--general">
								<div class="m-stack__item m-stack__item--middle m-brand__logo">
									<a href="{{ url('/') }}" class="m-brand__logo-wrapper">
										<img class="img img-responsive" style="width: 50px" alt="" src="{!! asset('assets/frontend/images/logo.png') !!}" />
									</a>
								</div>
								<div class="m-stack__item m-stack__item--middle m-brand__tools">

									<!-- BEGIN: Left Aside Minimize Toggle -->
									<a href="javascript:" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Responsive Aside Left Menu Toggler -->
									<a href="javascript:" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Responsive Header Menu Toggler -->
									<a id="m_aside_header_menu_mobile_toggle" href="javascript:" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
										<span></span>
									</a>

									<!-- END -->

									<!-- BEGIN: Topbar Toggler -->
									<a id="m_aside_header_topbar_mobile_toggle" href="javascript:" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
										<i class="flaticon-more"></i>
									</a>

									<!-- BEGIN: Topbar Toggler -->
								</div>
							</div>
						</div>

						<!-- END: Brand -->
						<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

							<!-- BEGIN: Horizontal Menu -->
							{{--<button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
							<div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
								<ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
									<li class="m-menu__item  m-menu__item--submenu m-menu__item--rel" m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link">
											<i class="m-menu__link-icon flaticon-add"></i><span class="m-menu__link-text">Quick Entry</span><i class="m-menu__hor-arrow la la-angle-down"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
										<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left"><span class="m-menu__arrow m-menu__arrow--adjust"></span>
											<ul class="m-menu__subnav">
												<li class="m-menu__item " aria-haspopup="true"><a href="javascript:void(0)" class="m-menu__link "><i class="m-menu__link-icon flaticon-file"></i><span class="m-menu__link-text">Create New Post</span></a></li>
												<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:void(0)" class="m-menu__link "><i class="m-menu__link-icon flaticon-diagram"></i><span class="m-menu__link-title"> <span class="m-menu__link-wrap">
																<span class="m-menu__link-text">Generate Reports</span> <span class="m-menu__link-badge"><span class="m-badge m-badge--success">2</span></span> </span></span></a></li>
												<li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:;" class="m-menu__link m-menu__toggle" title="Non functional dummy link"><i class="m-menu__link-icon flaticon-business"></i><span
														 class="m-menu__link-text">Manage Orders</span><i class="m-menu__hor-arrow la la-angle-right"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right"><span class="m-menu__arrow "></span>
														<ul class="m-menu__subnav">
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:void(0)" class="m-menu__link "><span class="m-menu__link-text">Latest Orders</span></a></li>
														</ul>
													</div>
												</li>
												<li class="m-menu__item  m-menu__item--submenu" m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true"><a href="#" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon flaticon-chat-1"></i><span class="m-menu__link-text">Customer
															Feedbacks</span><i class="m-menu__hor-arrow la la-angle-right"></i><i class="m-menu__ver-arrow la la-angle-right"></i></a>
													<div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right"><span class="m-menu__arrow "></span>
														<ul class="m-menu__subnav">
															<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:void(0)" class="m-menu__link "><span class="m-menu__link-text">xyz</span></a></li>
														</ul>
													</div>
												</li>
												<li class="m-menu__item " m-menu-link-redirect="1" aria-haspopup="true"><a href="javascript:void(0)" class="m-menu__link "><i class="m-menu__link-icon flaticon-users"></i><span class="m-menu__link-text">Register Member</span></a></li>
											</ul>
										</div>
									</li>


								</ul>
							</div>
--}}
							<!-- END: Horizontal Menu -->

							<!-- BEGIN: Topbar -->
							<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
								<div class="m-stack__item m-topbar__nav-wrapper">
									<ul class="m-topbar__nav m-nav m-nav--inline">
										<li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
										 m-dropdown-toggle="click">
											<a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="@if(Auth::user()->user_photo !=''){!! url('uploads/user_photo/'.Auth::user()->user_photo) !!} @else {{ url('assets/app/media/img/users/user4.jpg')}} @endif" class="m--img-rounded m--marginless" alt="User" style="width: 40px;height: 40px"/>
												</span>
												<span class="m-topbar__username m--hide">{!!  Auth::user()->user_name !!}</span>
											</a>
											<div class="m-dropdown__wrapper">
												<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
												<div class="m-dropdown__inner">
													<div class="m-dropdown__header m--align-center" style="background: url(../../../assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">

														<div class="m-card-user m-card-user--skin-dark">
															<div class="m-card-user__pic">
																<img  src="@if(Auth::user()->user_photo !=''){!! url('uploads/user_photo/'.Auth::user()->user_photo) !!} @else {{ url('assets/app/media/img/users/user4.jpg')}} @endif" class="m--img-rounded m--marginless" alt="User"  style="width: 80px;height: 80px"/>

																<!--
						<span class="m-type m-type--lg m--bg-danger"><span class="m--font-light">S<span><span>-->
															</div>
															<div class="m-card-user__details">
																<span class="m-card-user__name m--font-weight-500">{!!  Auth::user()->user_name !!}</span>
																<a href="javascript:void(0)" class="m-card-user__email m--font-weight-300 m-link">{!!  Auth::user()->email !!}</a>
															</div>
														</div>
													</div>
													<div class="m-dropdown__body">
														<div class="m-dropdown__content">
															<ul class="m-nav m-nav--skin-light">
																<li class="m-nav__section m--hide">
																	<span class="m-nav__section-text">Section</span>
																</li>
																<li class="m-nav__item">
																	<a href="javascript:void(0)" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-profile-1"></i>
																		<span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">My Profile</span>
																				<span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
																			</span>
																		</span>
																	</a>
																</li>
																<li class="m-nav__item">
																	<a href="javascript:void(0)" class="m-nav__link">
																		<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																		<span class="m-nav__link-text">Support</span>
																	</a>
																</li>
																<li class="m-nav__separator m-nav__separator--fit">
																</li>
																<li class="m-nav__item">
																	<a href="{{URL::to('logout')}}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>
										</li>

									</ul>
								</div>
							</div>

							<!-- END: Topbar -->
						</div>
					</div>
				</div>
			</header>

			<!-- END: Header -->

			<!-- begin::Body -->
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

				<!-- BEGIN: Left Aside -->
				<button class="m-aside-left-close  m-aside-left-close--skin-light " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
				<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light">

					<!-- BEGIN: Aside Menu -->
					<div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light " m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
						<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
							<li class="m-menu__item " aria-haspopup="true">
								<a href="{{ route('dashboard') }}" class="m-menu__link "><i class="m-menu__link-icon flaticon-line-graph"></i><span class="m-menu__link-title">
										<span class="m-menu__link-wrap"> <span class="m-menu__link-text">Dashboard</span> </span>
									   </span>
								</a>
							</li>

                            <?php
                            $sideMenu = showMenu();

                            $menuItem = '';
                            if($sideMenu){
                                foreach ($sideMenu as $key => $value) {
                                    $menuItem .= '<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">

                             						   <a href="javascript:;" class="m-menu__link m-menu__toggle"><i class="m-menu__link-icon '.$value['icon_class'].'"></i><span class="m-menu__link-text">'.$value['module_name'].'</span><i class="m-menu__ver-arrow la la-angle-right"></i></a>';

                                    if($value['sub_menu']){
                                        $menuItem .= '<div class="m-menu__submenu "><span class="m-menu__arrow"></span>';
                                        $menuItem .= '<ul class="m-menu__subnav">';

                                        foreach($value['sub_menu'] as $menu){
                                            if($menu['menu_url'] != '' || $menu['sub_menu']){
                                                $menuItem .= '<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
																	<a href="'.($menu['menu_url'] ? route($menu['menu_url']) : 'javascript:void(0)').'" class="m-menu__link m-menu__toggle"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
							class="m-menu__link-text">'.$menu['menu_name'].'</span>' .($menu['menu_url'] ? '' : '<i class="m-menu__ver-arrow la la-angle-right"></i>'). '</a>';

                                                if($menu['sub_menu']){
                                                    $menuItem .= '<div class="m-menu__submenu "><span class="m-menu__arrow"></span><ul class="m-menu__subnav">';
                                                    foreach($menu['sub_menu'] as $subMenu){
                                                        $menuItem .= '<li class="m-menu__item " aria-haspopup="true">';
														$menuItem .= '<a href="'.($subMenu['menu_url'] ? route($subMenu['menu_url']) : 'javascript:void(0)').'" class="m-menu__link"><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span class="m-menu__link-text">'.$subMenu['menu_name'].'</span></a>';
                                                        $menuItem .= '</li>';
                                                    }
                                                    $menuItem .= '</ul></div>';
                                                }
                                                $menuItem .= '</li>';
                                            }
                                        }
                                        $menuItem .= '</ul>';
                                        $menuItem .= '</div>';
                                    }
                                    $menuItem .= '</li>';
                                }
                            }
                            echo $menuItem;
                            ?>
						</ul>
					</div>

					<!-- END: Aside Menu -->
				</div>

				<!-- END: Left Aside -->
				<div class="m-grid__item m-grid__item--fluid m-wrapper">
					<!-- BEGIN: Middle Content -->

					@yield('content')


					<!-- END: Middle Content -->
				</div>
			</div>
			<!-- end:: Body -->

			<!-- begin::Footer -->
			<footer class="m-grid__item		m-footer ">
				<div class="m-container m-container--fluid m-container--full-height m-page__container">
					<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
						<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
							<span class="m-footer__copyright">
								<?php echo date('Y');?> &copy; iVenture ERP by <a href="http://iventurebd.com/" class="m-link">iVenture Limited</a>
							</span>
						</div>
						<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
							<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
								<li class="m-nav__item">
									<a href="#" class="m-nav__link">
										<span class="m-nav__link-text">About</span>
									</a>
								</li>
								<li class="m-nav__item">
									<a href="#" class="m-nav__link">
										<span class="m-nav__link-text">Privacy</span>
									</a>
								</li>
								<li class="m-nav__item">
									<a href="#" class="m-nav__link">
										<span class="m-nav__link-text">FAQ</span>
									</a>
								</li>
								<li class="m-nav__item m-nav__item">
									<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
										<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>

			<!-- end::Footer -->
		</div>

		<!-- end:: Page -->
		<!-- begin::Scroll Top -->
		<div id="m_scroll_top" class="m-scroll-top">
			<i class="la la-arrow-up"></i>
		</div>

		<!-- end::Scroll Top -->

		<!--begin::Global Theme Bundle -->
		<script src="{!! asset('assets/vendors/base/vendors.bundle.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/base/scripts.bundle.js') !!}" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->
		<!--begin::Page Scripts -->
		<script src="{!! asset('assets/demo/default/custom/crud/forms/widgets/select2.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-timepicker.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/custom/crud/forms/widgets/form-repeater.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js') !!}" type="text/javascript"></script>
		{{--<script src="{!! asset('assets/demo/default/custom/crud/metronic-datatable/scrolling/horizontal.js') !!}" type="text/javascript"></script>--}}
		<!--end::Global Theme Bundle -->
		<!--begin::Page Vendors -->
		<script src="{!! asset('assets/vendors/custom/datatables/datatables.bundle.js')!!}" type="text/javascript"></script>
		<!--end::Page Vendors -->
		<!--begin::Page Scripts -->
		{{--<script src="{!! asset('assets/demo/default/custom/crud/datatables/basic/paginations.js') !!}" type="text/javascript"></script>--}}
		<!--end::Page Scripts -->
		<!--begin::Page Scripts -->
		<script src="{!! asset('assets/app/js/dashboard.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/sweetalert/sweetalert-dev.js') !!}"></script>
		<!--end::Page Vendors -->
		<script src="{!! asset('assets/demo/default/custom/components/base/toastr.js') !!}" type="text/javascript"></script>
		<script src="{!! asset('assets/demo/default/custom/components/base/sweetalert2.js') !!}" type="text/javascript"></script>
		<!--end::Page Scripts -->
		<!--begin::wizard -->
		<script src="{!! asset('assets/demo/default/custom/crud/wizard/wizard.js') !!}" type="text/javascript"></script>
		<!--end::wizard-->

		<script type="text/javascript">
            function activeMenu(){
                $('a[href="' + current_url + '"]').parents('.m-menu__item').addClass('m-menu__item--open');
                $('a[href="' + current_url + '"]').parent('.m-menu__item').addClass('m-menu__item--active');
            }
		</script>

        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

        <!--lightbox-->
        <script src="{!! asset('assets/lightbox/ekko-lightbox.js') !!}"></script>
        <script src="{!! asset('assets/lightbox/ekko-lightbox.min.js') !!}"></script>

        <script>

            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-bottom-right",
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

                @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;

                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
            @endif

            $(document).on('click', '.delete', function () {
                var actionTo = $(this).attr('href');
                var token = $(this).attr('data-token');
                var id = $(this).attr('data-id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: actionTo,
                                type: 'post',
                                data: {_method: 'delete', _token: token},
                                success: function (data) {
                                    if (data == 'hasForeignKey') {
                                        swal({
                                            title: "Oops!",
                                            text: "This data is used anywhere",
                                            type: "error"
                                        });
                                    } else if (data == 'success') {
                                        swal({
                                                title: "Deleted!",
                                                text: "Your information delete successfully.",
                                                type: "success"
                                            },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    $('.' + id).fadeOut();
                                                }
                                            });
                                    } else {
                                        swal({
                                            title: "Deleted!",
                                            text: "Something Error Found !, Please try again.",
                                            type: "error"
                                        });
                                    }
                                }

                            });
                        } else {
                            swal("Cancelled", "Your data is safe .", "error");
                        }
                    });
                return false;
            });


			//////////////////Employee Permanent Alert/////////////////////////

            $(document).on('click', '.update_permanent', function () {
                var actionTo = $(this).attr('href');
                var token = $(this).attr('data-token');
                var id = $(this).attr('data-id');
                //alert('ase');
                swal({
                        title: "Are you sure want to approve?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, approve it!",
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: actionTo,
                                type: 'post',
                                data: {_method: 'get', _token: token},
                                //alert(actionTo);
                                success: function (data) {
                                    console.log(data.data);
                                    if (data == 'hasForeignKey') {
                                        swal({
                                            title: "Oops!",
                                            text: "This data is used anywhere",
                                            type: "error"
                                        });
                                    } else if (data == 'success') {
                                        swal({
                                                title: "Approved!",
                                                text: "Your information approved successfully.",
                                                type: "success"
                                            },
                                            function (isConfirm) {
                                                if (isConfirm) {
                                                    $('.' + id).fadeOut();
                                                }
                                            });
                                    } else {
                                        swal({
                                            title: "Error",
                                            text: "Some Error Found !, Please try again.",
                                            type: "error"
                                        });
                                    }
                                }

                            });
                        } else {
                            swal("Cancelled", "Your data is safe .", "error");
                        }
                    });
                return false;
            });

		</script>
		@stack('custom_scripts')
	</body>
	<!-- end::Body -->
</html>
