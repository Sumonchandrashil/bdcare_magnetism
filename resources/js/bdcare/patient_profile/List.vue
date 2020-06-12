<template>
    <div>
        <div class="m-portlet__body" v-if="data_list">
            <div class="row">
                <div class="item-show-limit col-md-8">
                </div>
                <div class="col-md-4">
                    <form class="form-inline d-flex mx-1 justify-content-end" @submit.stop.prevent="doSearch">
                        <div class="input-group">
                            <input  v-model="quickSearch"  id="quickSearch" type="search" placeholder="Quick search" class="form-control">
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
                    <th>Patient Name</th>
                    <th>Email</th>
                    <th>Contact No</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Detail</th>
                    <th class="width-100 text-center">Action</th>
                </tr>
                </thead>
                <tbody v-if="resultData.data !=''" id="myTable">
                <tr v-for="(value,index) in resultData.data">
                    <td>{{++index}}</td>
                    <td>{{value.patient_name}}</td>
                    <td>{{value.email}}</td>
                    <td>{{value.contact}}</td>
                    <td>{{value.gender}}</td>
                    <td>{{value.address}}</td>
                    <td>{{value.details}}</td>
                    <td scope="row" class="width-100 text-center">
                        <a v-if="permissions.indexOf('patient_profile.edit') != -1 && value.approval != 1" @click="editData(value.id)" class="btn btn-outline-success m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la la-edit"></i></a>
                        <a v-if="permissions.indexOf('patient_profile.destroy') !=-1" @click="deleteData(value.id)" class="btn btn-outline-danger m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
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
        <Add
                v-else-if="add_form"
                :disease_lists="disease_lists"
        ></Add>
        <Edit
                v-else-if="edit_form"
                :edit-id="edit_id"
                :permissions="permissions"
                :disease_lists="disease_lists"
        ></Edit>
    </div>
</template>

<script>

    import { EventBus } from '../../vue-assets';
    import VdtnetTable from 'vue-datatables-net';
    import Add from './Add.vue';
    import Edit from './Edit.vue';

    export default {
        components: {
            Add,
            Edit,
            VdtnetTable
        },

        props:['permissions','disease_lists'],

        data: function(){
            return {
                data_list:true,
                add_form:false,
                edit_form:false,
                edit_id:false,
                //VdtnetTable Options
                tableId: 'patient_profile',
                options: {
                    ajax: {
                        url: base_url+"patient_profile",
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
                    id: { label: 'ID', sortable: false },
                    patient_name: { label: 'Patient Name', sortable: true, searchable: true, defaultOrder: 'asc'  },
                    email: { label: 'Email', sortable: false, searchable: false  },
                    contact: { label: 'Contact No', sortable: true, searchable: true   },
                    gender: { label: 'Gender', sortable: false, searchable: false  },
                    address: { label: 'Address', sortable: false, searchable: false  },
                    details: { label: 'Detail', sortable: false, searchable: false  },

                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        render: (data,type,row,meta) => {
                            var htmlButtons = '';

                            /*if (this.permissions.indexOf('patient_profile.edit') != -1 && row.approval !=1) {
                                htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="edit" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la   la-edit"></i></a>';
                            }*/
                            if (this.permissions.indexOf('patient_profile.destroy') != -1) {
                                htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="delete" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>';
                            }
                            return htmlButtons;
                        }
                    }
                },
                quickSearch: '',
            };
        },

        methods: {
               /* index(pageNo,perPage){
                    if(pageNo){ pageNo = pageNo; }else{pageNo = this.resultData.current_page; }
                    if(perPage){ perPage = perPage;}else{ perPage = this.perPage;}

                    axios.get(base_url+"patient_profile/?page="+pageNo+"&perPage="+perPage).then((response) => {
                       this.resultData = response.data;
                        //alert(this.resultData.data);
                    });
                },*/
               dateFormate(value){
                    if (value) {
                        return moment(String(value)).format('MM/DD/YYYY')
                    }
                },

                editData(id){
                    var _this = this;
                    _this.add_form = false;
                    _this.data_list = false;
                    _this.edit_form = true;
                    _this.edit_id = id;
                    $('#addButton').hide();
                    $('#listButton').show();
                },

            viewData(id){
                var _this = this;
                _this.add_form = false;
                _this.data_list = false;
                _this.edit_form = false;
                _this.view_form = true;
                _this.edit_id = id;
                $('#addButton').hide();
                $('#listButton').show();
            },


                deleteData(id,tr){
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
                        function(){
                            swal("Deleted!", "Your imaginary file has been deleted.", "success");
                            axios.delete(base_url+'patient_profile/'+id).then((response) => {
                                //_this.index(1);
                                _this.showMassage(response.data);
                                tr.remove();
                            }).catch((error)=>{
                                swal('Error:','Something Error Found !, Please try again','error');
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

                this.deleteData(data.id,tr);
            },
            doSearch() {
                this.$refs.table.search(this.quickSearch)
            },
            doExport(type) {
                const parms = this.$refs.table.getServerParams();
                parms.export = type;
                window.alert('GET /api/v1/export?' + jQuery.param(parms))
            }

           /* datatables(){
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

        created(){

            var _this = this;
            $('body').on('click', '#addButton', function() {
                _this.add_form = true;
                _this.data_list = false;
                _this.edit_form = false;
                $('#addButton').hide();
                $('#listButton').show();
            });

            $('body').on('click', '#listButton', function() {
                _this.add_form = false;
                _this.data_list = true;
                _this.edit_form = false;
                $('#addButton').show();
                $('#listButton').hide();
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
            },900);
        },
    }
</script>

