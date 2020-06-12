<template>
    <div>
        <div class="m-portlet__body" v-if="data_list">
            <div class="row">
                <div class="item-show-limit col-md-8">
                </div>
                <div class="col-md-4">
                    <form class="form-inline d-flex mx-1 justify-content-end" @submit.stop.prevent="doSearch">
                        <div class="input-group">
                            <input v-model="quickSearch" id="quickSearch" type="search" placeholder="Quick search"
                                   class="form-control">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="mdi mdi-magnify"/> Go
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--begin: Datatable -->
            <div class="table-responsive">
                <vdtnet-table
                    :id="tableId"
                    ref="table"
                    :fields="fields"
                    :opts="options"
                    @edit="doAlertEdit"
                    @delete="doAlertDelete"

                >

                </vdtnet-table>
            </div>

            <!--<table class="table table-bordered table-hover table-responsive-lg table-scrollable" id="m_table_1">
                <thead>
                <tr>
                    <th>S/L</th>
                    <th>Doctors Name</th>
                    <th>Visiting Fees</th>
                    <th>Contact No</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Year of Experience</th>
                    <th class="width-100 text-center">Action</th>
                </tr>
                </thead>
                <tbody v-if="resultData.data !=''" id="myTable">
                <tr v-for="(value,index) in resultData.data">
                    <td>{{++index}}</td>
                    <td>{{value.doctor_name}}</td>
                    <td>{{value.visiting_fees}}</td>
                    <td>{{value.emergency_contact}}</td>
                    <td>{{value.gender}}</td>
                    <td>{{value.address}}</td>
                    <td>{{value.year_of_experience}}</td>
                    <td scope="row" class="width-100 text-center">
                        <a v-if="permissions.indexOf('doctors_profile.edit') != -1 && value.approval != 1" @click="editData(value.id)" class="btn btn-outline-success m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la la-edit"></i></a>
                        <a v-if="permissions.indexOf('doctors_profile.destroy') !=-1" @click="deleteData(value.id)" class="btn btn-outline-danger m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="8" class="text-center">No Data Available.</td>
                </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="text-center col-md-12" >
                    <pagination :resultData="resultData" @clicked="index" :mid-size="9"></pagination>
                </div>
            </div>-->
        </div>
        <!--:day_lists="day_lists"
        :degree_lists="degree_lists"
        :speciality_lists="speciality_lists"
        :hospital_lists="hospital_lists"-->
        <Add
            v-else-if="add_form"
        ></Add>

        <!--:day_lists="day_lists"
        :degree_lists="degree_lists"
        :speciality_lists="speciality_lists"
        :hospital_lists="hospital_lists"-->
        <Edit
            v-else-if="edit_form"
            :edit-id="edit_id"
            :permissions="permissions"
        ></Edit>
    </div>
</template>

<script>

    import {EventBus} from '../../vue-assets';
    import VdtnetTable from 'vue-datatables-net';
    import Add from './Add.vue';
    import Edit from './Edit.vue';

    export default {
        components: {
            Add,
            Edit,
            VdtnetTable
        },

        props: ['permissions'],

        data: function () {
            return {
                data_list: true,
                add_form: false,
                edit_form: false,
                edit_id: false,

                //VdtnetTable Options
                tableId: 'doctors_profile',
                options: {
                    ajax: {
                        url: base_url + "doctors_profile",
                        dataSrc: (json) => {
                            return json.data
                        }
                    },
                    responsive: false,
                    processing: true,
                    searching: true,
                    searchDelay: 1500,
                    destroy: true,
                    ordering: true,
                    lengthChange: true,
                    serverSide: true,
                    fixedHeader: true,
                    saveState: true,
                    stateSave: true
                },
                fields: {
                    id: {label: 'ID', sortable: false},
                    doctor_name: {label: 'Doctors Name', sortable: true, searchable: true, defaultOrder: 'asc'},
                    premium: {
                        label: 'Is Premium',
                        template: ' <div v-if="row.premium == 0"  class="badge badge-pill badge-danger" >Not Premium</div><div v-if="row.premium == 1"  class="badge badge-pill badge-success" >Premium</div>',
                        sortable: true,
                        searchable: true
                    },
                    status: {
                        label: 'Is Active',
                        template: ' <div v-if="row.status == 0"  class="badge badge-pill badge-danger" >Not Active</div><div v-if="row.status == 1"  class="badge badge-pill badge-success" >Active</div>',
                        sortable: true,
                        searchable: true
                    },
                    email: {label: 'Email', sortable: true, searchable: true},
                    bmdc_reg_no: {label: 'BMDC Reg No', sortable: false, searchable: false},
                    bmdc_reg_year: {label: 'BMDC Reg Year', sortable: false, searchable: false},
                    bmdc_doc: {
                        label: 'BMDC Doc',
                        render: (data, type, row) => {
                            return '<a href="' + base_url + '' + "uploads/" + '' + "doctor_bmdc_doc/" + '' + row.bmdc_doc + '" data-toggle="lightbox" data-title="BMDC Doc">\n' +
                                '<img alt="" class="imageSize" width="70px" src="' + base_url + '' + "uploads/" + '' + "doctor_bmdc_doc/" + '' + row.bmdc_doc + '" >\n' +
                                '</a>'
                        },
                        sortable: false,
                        searchable: false
                    },
                    passport_nid: {
                        label: 'Passport/NID',
                        render: (data, type, row) => {
                            return '<a href="' + base_url + '' + "uploads/" + '' + "doctor_passport_nid/" + '' + row.passport_nid + '" data-toggle="lightbox" data-title="Passport/NID">\n' +
                                '<img alt="" class="imageSize" width="70px" src="' + base_url + '' + "uploads/" + '' + "doctor_passport_nid/" + '' + row.passport_nid + '" >\n' +
                                '</a>'
                        },
                        sortable: false,
                        searchable: false
                    },
                    gender: {label: 'Gender', sortable: false, searchable: false},
                    age: {label: 'Age', sortable: false, searchable: false},
                    // visiting_fees: {label: 'Visiting Fees', sortable: false, searchable: false},
                    emergency_contact: {label: 'Contact No', sortable: true, searchable: true},
                    // address: {label: 'Address', sortable: false, searchable: false},
                    // year_of_experience: {label: 'Year of Experience', sortable: false, searchable: false},

                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        render: (data, type, row, meta) => {
                            var htmlButtons = '';

                            if (this.permissions.indexOf('doctors_profile.edit') != -1) {
                                htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="edit" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la   la-edit"></i></a>';
                            }
                            /*if (this.permissions.indexOf('doctors_profile.destroy') != -1) {
                                htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="delete" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>';
                            }*/
                            return htmlButtons;
                        }
                    }
                },
                quickSearch: '',
            };
        },

        methods: {
            getImgUrl(path, file_name) {
                if (file_name) {
                    return base_url + path + file_name;
                }
            },

            /*index(pageNo,perPage){
                if(pageNo){ pageNo = pageNo; }else{pageNo = this.resultData.current_page; }
                if(perPage){ perPage = perPage;}else{ perPage = this.perPage;}

                axios.get(base_url+"doctors_profile/?page="+pageNo+"&perPage="+perPage).then((response) => {
                   this.resultData = response.data;

                });
            },*/
            dateFormate(value) {
                if (value) {
                    return moment(String(value)).format('MM/DD/YYYY')
                }
            },

            editData(id) {
                var _this = this;
                _this.add_form = false;
                _this.data_list = false;
                _this.edit_form = true;
                _this.edit_id = id;
                $('#addButton').hide();
                $('#listButton').show();
            },

            viewData(id) {
                var _this = this;
                _this.add_form = false;
                _this.data_list = false;
                _this.edit_form = false;
                _this.view_form = true;
                _this.edit_id = id;
                $('#addButton').hide();
                $('#listButton').show();
            },

            deleteData(id, tr) {
                var _this = this;
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this information!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    },
                    function () {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                        axios.delete(base_url + 'doctors_profile/' + id).then((response) => {
                            //_this.index(1);
                            _this.showMassage(response.data);
                            tr.remove();
                        }).catch((error) => {
                            swal('Error:', 'Something Error Found !, Please try again', 'error');
                        });
                    });
            },

            showMassage(data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Success Alert', {timeOut: 5000});
                } else {
                    toastr.error(data.message, 'Error Alert', {timeOut: 5000});
                }
            },

            //VdtnetTable Methods
            doAlertEdit(data) {
                this.editData(data.id);
            },

            doAlertView(data) {
                this.viewData(data.id);
            },
            doAlertDelete(data, row, tr, target) {

                this.deleteData(data.id, tr);
            },
            doSearch() {
                this.$refs.table.search(this.quickSearch)
            },
            doExport(type) {
                const parms = this.$refs.table.getServerParams();
                parms.export = type;
                window.alert('GET /api/v1/export?' + jQuery.param(parms))
            }

            /*datatables(){
                $(document).ready(function(){
                    $("#myInput").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#myTable tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
                },*/
        },

        created() {

            var _this = this;
            $('body').on('click', '#addButton', function () {
                _this.add_form = true;
                _this.data_list = false;
                _this.edit_form = false;
                $('#addButton').hide();
                $('#listButton').show();
            });

            $('body').on('click', '#listButton', function () {
                _this.add_form = false;
                _this.data_list = true;
                _this.edit_form = false;
                $('#addButton').show();
                $('#listButton').hide();
            });

            $('body').on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });

            EventBus.$on('data-changed', (id) => {
                _this.add_form = false;
                _this.data_list = true;
                _this.edit_form = false;
                $('#addButton').show();
                $('#listButton').hide();
                //_this.index(1);
            });

            //_this.index(1);
            //_this.datatables();
            setTimeout(function () {
                const vdt_parms = _this.$refs.table.getServerParams();
                if (vdt_parms.search.value) {
                    _this.quickSearch = vdt_parms.search.value;
                    $('#quickSearch').focus();
                }
            }, 900);
        },
    }
</script>

