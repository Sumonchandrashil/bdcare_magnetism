@extends('master')
@section('title','Add User')
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
                                    @yield('title')
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <a href="javascript:history.back();"
                               class="btn btn-sm btn-secondary m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m--visible-desktop-inline-block">
                                <span>
                                    <i class="la la-arrow-left"></i>
                                    <span>Back</span>
                                </span>
                            </a>
                            <a href="{{ URL::to('user') }}"
                               class="btn btn-sm btn-brand m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m-btn--air">
                                <span>
                                    <i class="fa fa-list"></i>
                                    <span>Manage User</span>
                                </span>
                            </a>
                        </div>
                    </div>
                    <!--begin::Form-->
                    @if(isset($editModeData))
                        {{ Form::model($editModeData, array('route' => array('user.update', $editModeData->id),'enctype'=>'multipart/form-data', 'method' => 'PUT','files' => 'true','id' => 'userInfo','class'=>'m-form m-form--fit m-form--label-align-right')) }}
                    @else
                        {{ Form::open(array('route' => 'user.store','enctype'=>'multipart/form-data','id'=>'userInfo','class'=>'m-form m-form--fit m-form--label-align-right')) }}
                    @endif
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
                            <label for="user_name" class="col-lg-3 col-form-label">User Name </label>
                            <div class="col-lg-6">
                                {!! Form::text('user_name', Input::old('user_name'), $attributes = array('class'=>'form-control form-control-sm m-input','id'=>'user_name','placeholder'=>'Enter user name','autocomplete'=>'off')) !!}
                                @if($errors->has('user_name')) <span
                                    class="validation_msg"> <strong> {{ $errors->first('user_name') }} </strong> </span> @endif
                            </div>

                        </div>
                        <div class="form-group m-form__group row">
                            <label for="email" class="col-lg-3 col-form-label">Email </label>
                            <div class="col-lg-6">
                                {!! Form::text('email', Input::old('email'), $attributes = array('class'=>'form-control form-control-sm m-input','id'=>'email','placeholder'=>'Enter user email','autocomplete'=>'off')) !!}
                                @if($errors->has('email')) <span
                                    class="validation_msg"> <strong> {{ $errors->first('email') }} </strong> </span> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="password" class="col-lg-3 col-form-label">Password </label>
                            <div class="col-lg-6">
                                {!! Form::password('password', $attributes = array('class'=>'form-control form-control-sm m-input','id'=>'password','placeholder'=>'Enter password','autocomplete'=>'off')) !!}
                                @if($errors->has('password')) <span
                                    class="validation_msg"> <strong> {{ $errors->first('password') }} </strong> </span> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label for="password_confirmation" class="col-lg-3 col-form-label">Confirm Password </label>
                            <div class="col-lg-6">
                                {!! Form::password('password_confirmation', $attributes = array('class'=>'form-control form-control-sm m-input','id'=>'password_confirmation','placeholder'=>'Enter confirm password','autocomplete'=>'off')) !!}
                                @if($errors->has('password_confirmation'))<span
                                    class="validation_msg"> <strong> {{ $errors->first('password_confirmation') }} </strong> </span>@endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label" for="m_select2_7">Role </label>
                            <div class="col-lg-6">
                                <?php
                                $role_id = Auth::user()->role_id;
                                if($role_id == 1){?>
                                {{ Form::select('role_id', $roleList,  Input::old('role_id'), array('class' => 'form-control select-mini m-select2','id'=>'m_select2_7')) }}
                                <?php }else{ ?>
                                {{ Form::select('role_id', $roleList,  Input::old('role_id'), array('class' => 'form-control select-mini m-select2','id'=>'m_select2_7','disabled'=>'disabled')) }}
                                <?php } ?>
                                @if($errors->has('role_id')) <span
                                    class="validation_msg"> <strong> {{ $errors->first('role_id') }} </strong> </span> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label" for="user_photo">Photo </label>
                            <div class="col-lg-6">
                                {!! Form::file('user_photo', Input::old('user_photo'), $attributes = array('class'=>'form-control form-control-sm m-input','id'=>'user_photo')) !!}
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 " for="status">Status </label>
                            <div class="col-lg-6">
                                <span class="m-switch m-switch--icon">
                                     <label>
                                     {!! Form::checkbox('status', Input::old('status', 1), $attributes = array('class'=>'form-control form-control-sm m-input','type'=>'checkbox', 'checked'=>$editModeData->status == 1 ?'1':'0')) !!}
                                <span></span>
                                     </label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-9 m--align-right">
                                    <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                                    <button type="submit" class="btn btn-sm btn-success"><i class="la la-check"></i>
                                        <span>Save</span></button>
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
