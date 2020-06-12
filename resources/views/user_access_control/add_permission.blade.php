
@extends('master')
@section('title','Add User Role Permission')
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
                    </div>
                    <!--begin::Form-->
                        {{ Form::open(array('route' => 'user-role-permissoin.store','id'=>'role_permission','class'=>'m-form m-form--fit m-form--label-align-right')) }}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group row">
                                <label for="role_id" class="col-lg-3 col-form-label">Role </label>
                                <div class="col-lg-6">
                                    {{ Form::select('role_id', $roleList,  Input::old('role_id'), array('class' => 'form-control select-mini m-select2 role_id','id'=>'m_select2_7','onchange'=>'getRoleWiseMenuList(this)')) }}
                                    @if($errors->has('role_id')) <span class="validation_msg"> <strong> {{ $errors->first('role_id') }} </strong> </span> @endif
                                </div>
                            </div>
                            <div class="m-form__group form-group row">
                                <label class="col-3 col-form-label"></label>
                                <div class="col-9">
                                    <div class="menuLoad">

                                    </div>
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
<script type="text/javascript">

    $(document).on('change','[data-menu]',function(event){
        if(this.checked==false){
            var getMenuId = $(this).attr('data-menu');
            $('[data-formenu="'+getMenuId+'"]').prop('checked',false);
        }else{
            var getMenuId = $(this).attr('data-menu');
            $('[data-formenu="'+getMenuId+'"]').prop('checked',true);
        }
    });

    $(document).on('change','[data-formenu]',function(event){
        if(this.checked==true){
            var getMenuId = $(this).attr('data-formenu');
            $('[data-menu="'+getMenuId+'"]').prop('checked',true);
        }
    });

    $(document).on("click", '.checkAll', function (event) {
        if (this.checked) {
            $('.inputCheckbox').each(function () {
                this.checked = true;
            });
        } else {
            $('.inputCheckbox').each(function () {
                this.checked = false;
            });
        }
    });


    function getRoleWiseMenuList(select){

        var role_id=$('.role_id').val();

        if(role_id != '' ){
            $('body').find('#submitForm').attr('disabled', false);
        }else{
            $('.inputCheckbox').each(function(){
                this.checked = false;
            });

            $('body').find('#submitForm').attr('disabled', true);
        }
        var action = "{{ URL::to('user-role-permission-get_all_menus') }}";
        $.ajax({
            type:'POST',
            url: action,
            data: {role_id:role_id, '_token': $('input[name=_token]').val()},

            success:function(result){

                var subMenus,checkedValue;
                var dataFormat = '<span class="m-section__sub text-center">Pages permission</span>';
                dataFormat += '<div id="area_select" class="" style="margin-top: 20px">';
                dataFormat += '<div class="checkbox checkbox-info" style="">';
                dataFormat += '<div class="">';
                dataFormat += '<label class="m-checkbox m-checkbox--success m-checkbox--bold ">';
                dataFormat += '<input type="checkbox" class=" inputCheckbox checkAll" id="inlineCheckbox">Select All <span></span>';
                dataFormat += '</label>';
                dataFormat += '</div>';

                var sl=1;
                $.each(result.arrayFormat, function (key, value) {

                    dataFormat += '<span class="m-section__sub text-center module-name">' + key + ' </span>';
                    $.each(value, function (key1, value1) {
                        sl++;
                        checkedValue = '';
                        if (value1['hasPermission'] == 'yes') {
                            checkedValue = 'checked';
                        }
                        dataFormat += '<div class="m-checkbox-list"> ';
                        dataFormat += '<label class="m-checkbox m-checkbox--brand m-checkbox--bold"> ';
                        dataFormat += '<input class="inputCheckbox" data-menu="' + value1['id'] + '" type="checkbox" id="inlineCheckbox1'+sl+'" ' + checkedValue + ' name="menu_id[]" value="' + value1['id'] + '"> '+ value1['menu_name'];
                        dataFormat += '<span></span></label></div>';
                        dataFormat += '</label>';
                        dataFormat += '</div>';

                        //  console.log(result.subMenu[value1['id']]);
                        if(result.subMenu[value1['id']] !== undefined){
                            subMenus = result.subMenu[value1['id']];
                            var i=1;
                            dataFormat += '<div class="m-checkbox-list">';
                            dataFormat += '<div class="m-checkbox-inline">';
                            for(var subMenuIndex in subMenus){
                                checkedValue='';
                                if(subMenus[subMenuIndex].hasPermission=='yes'){
                                    checkedValue='checked';
                                }
                               // var subMenuCss = 'margin-bottom: 12px';
                                if(i==1){
                                //    subMenuCss = "margin-bottom: 12px;margin-left: 24px";
                                }
                                i++;

                                dataFormat += '<label class="m-checkbox m-checkbox--bold" >';
                                dataFormat += '<input type="checkbox" class="inputCheckbox" id="inlineCheckbox'+subMenus[subMenuIndex].id+'" value="' + subMenus[subMenuIndex].id + '" data-formenu="' + value1['id'] + '" '+checkedValue+' name="menu_id[]" value="'+subMenus[subMenuIndex].id+'">'+subMenus[subMenuIndex].menu_name;
                                dataFormat += '<span></span>';
                                dataFormat += '</label>';
                            }
                            dataFormat += '</div>';
                            dataFormat += '</div>';
                            i=1;
                        }
                    })
                });
                $('.menuLoad').html(dataFormat);
            }
        });
    }
</script>
@endpush
