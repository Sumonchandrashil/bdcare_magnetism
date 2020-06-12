@extends('master')
@section('title','Manage Role')
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
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            @yield('title')
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <a href="{{ URL::to('role/create') }}"  class="btn btn-sm btn-brand m-btn--icon m-btn--wide m-btn--sm m--margin-right-10 m-btn--air">
                        <span>
                            <i class="fa fa-list"></i>
                            <span>Add Role</span>
                        </span>
                    </a>
                </div>
            </div>
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover " id="m_table_1">
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Role Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($role) && count($role))
                        @foreach($role as $key=>$row)
                            <tr class="{{$row->id}}">
                                <td>{{ ($key+1) }}</td>
                                <td>{{ $row->role_name }}</td>
                                <td>
                                    @if($row->status == 1)
                                        <div class="m-demo__preview m-demo__preview--badge">
                                            <span class="m-badge m-badge--success m-badge--wide m-badge--rounded"> <i class="la la-check-circle"></i> Active </span>
                                        </div>
                                    @else
                                        <div v-if="value.status == 0" class="m-demo__preview m-demo__preview--badge">
                                            <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded"> <i class="la la-ban"></i> Inactive</span>
                                        </div>
                                    @endif
                                <td>
                                    <a href="{{ URL::to('role/' . $row->id . '/edit') }}" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la la-edit"></i></a>
                                    <a href="{!!route('role.destroy',$row->id )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $row->id !!}" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air deleteBtn" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@stop
@push('custom_scripts')
<script>
    $(document).on('click', '.deleteBtn', function () {
        var actionTo=$(this).attr('href');
        var token=$(this).attr('data-token');
        var id=$(this).attr('data-id');

        swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "success",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url:actionTo,
                        type: 'post',
                        data: {_method: 'delete',_token:token},
                        success: function (data) {

                            if (data == 'hasForeignKey') {
                                swal({
                                    title: "Oops!",
                                    text: "This data is used anywhere",
                                    type: "error"
                                });
                            } else if(data == 'success'){
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
                            }else{
                                swal({
                                    title: "Fail to Delete!",
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
</script>
@endpush
