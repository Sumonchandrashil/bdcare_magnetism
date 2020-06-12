@extends('master')
@section('title','Add Role')
@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="javascript:void(0)" class="m-nav__link">
                            <span class="m-nav__link-text">Administration</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="javascript:void(0)" class="m-nav__link">
                            <span class="m-nav__link-text">User</span>
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
                                    Add Role
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="javascript:history.back();" class="btn btn-sm btn-secondary m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m--visible-desktop-inline-block">
                                    <span>
                                        <i class="la la-arrow-left"></i>
                                        <span>Back</span>
                                    </span>
                            </a>
                            <a href="{{ URL::to('role') }}"  class="btn btn-sm btn-brand m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m-btn--air">
                                <span>
                                    <i class="fa fa-list"></i>
                                    <span>Manage Role</span>
                                </span>
                            </a>
                        </div>
                    </div>

                    <!--begin::Form-->
                    @if(isset($editModeData))
                        {{ Form::model($editModeData, array('route' => array('role.update', $editModeData->id),'enctype'=>'multipart/form-data', 'method' => 'PUT','files' => 'true','id' => 'role','class'=>'m-form m-form--fit m-form--label-align-right')) }}
                    @else
                        {{ Form::open(array('route' => 'role.store','enctype'=>'multipart/form-data','id'=>'userInfo','class'=>'m-form m-form--fit m-form--label-align-right')) }}
                    @endif
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="role_name" class="col-lg-3 col-form-label">Role Name </label>
                                <div class="col-lg-6">
                                    {!! Form::text('role_name', Input::old('role_name'), $attributes = array('class'=>'form-control form-control-sm m-input','id'=>'role_name','placeholder'=>'Enter role name','autocomplete'=>'off')) !!}
                                    @if($errors->has('role_name')) <span class="validation_msg"> <strong> {{ $errors->first('role_name') }} </strong> </span> @endif
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions--solid">
                                <div class="row">
                                    <div class="col-lg-9 m--align-right">
                                        <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                        <button type="submit" class="btn btn-sm btn-success" ><i class="la la-check"></i> <span>Save</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                      {{ Form::close() }}
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@stop


@push('custom_scripts')
<script type="text/javascript" src="{!! asset('js/role.js') !!}"></script>
@endpush
