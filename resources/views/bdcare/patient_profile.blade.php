@extends('master')
@section('title','Manage Patient')
@section('content')
    <!-- BEGIN: Subheader -->
    <div class="diran-erp-main-content" id="erp-app">
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{ url('dashboard') }}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="javascript:void(0)" class="m-nav__link">
                                <span class="m-nav__link-text">Patient Setup</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="javascript:void(0)" class="m-nav__link">
                                <span class="m-nav__link-text">Section</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">-</li>
                        <li class="m-nav__item">
                            <a href="javascript:void(0)" class="m-nav__link">
                                <span class="m-nav__link-text">@yield('title')</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        @php
      //      $permissionCheck =  permissionCheck();
        @endphp

        <div class="br-for-mobile-break m--visible-mobile-inline-block">
            <br>
        </div>

        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon m--visible-desktop-inline-block">
                                        <i class="fa fa-plus-square"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        @yield('title')
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                {{--<a href="javascript:history.back();" class="btn btn-sm btn-secondary m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m--visible-desktop-inline-block">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>Back</span>
                                    </span>
                                </a>--}}
                                @if (in_array('patient_profile.store',permissionCheck()))
                                    <?php
/*                                    $user_id = Auth::user()->id;
                                    $row_count = DB::table('patient_datas')->where('created_by',$user_id)->count();
                                    if($row_count == 0){
                                    */?>
                                    {{--<a href="javascript:void(0)"  class="btn btn-sm btn-brand m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m-btn--air" id="addButton">
                                        <span>
                                            <i class="fa fa-list"></i>
                                            <span>Add Patient</span>
                                        </span>
                                    </a>--}}
                                    <?php /*}*/?>
                                @endif
                                <a href="javascript:void(0)" class="btn btn-sm btn-brand m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m-btn--air" style="display: none" id="listButton">
                                    <span>
                                        <i class="fa fa-list"></i>
                                        <span>Manage Patient</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <list
                                :permissions="{{ json_encode(permissionCheck()) }}"
                                :disease_lists="{{json_encode($DiseaseList)}}"
                        ></list>
                        <!--begin::Form-->
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>
@stop

@push('custom_scripts')
<script type="text/javascript" src="{!! asset('js/bdcare/patient_profile.js') !!}"></script>
@endpush
