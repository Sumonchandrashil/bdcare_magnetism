<template>
    <div>
        <div class="m-portlet__body" v-if="data_list">
            <div class="row">
                <div class="item-show-limit col-md-8">
                    <span>Show</span>
                    <select name="per_page" class="per_page" @change="changePerPage" v-model="perPage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                    </select>
                    <span>Entries</span>
                </div>
                <div class="col-md-4">
                    <div class="m-input-icon m-input-icon--left">
                        <input type="text" class="form-control m-input" placeholder="Search..." id="myInput">
                        <span class="m-input-icon__icon m-input-icon__icon--left">
                        <span><i class="la la-search"></i></span>
                    </span>
                    </div>
                </div>
            </div>
            <br><br>
            <!--begin: Datatable -->
            <table class="table table-bordered table-hover table-responsive-lg table-scrollable" id="m_table_1">
                <thead>
                <tr>
                    <th>S/L</th>
                    <th>Patient Name</th>
                    <th>Gender</th>
                    <th>Doctor Name</th>

                    <th>Schedule</th>
                    <th>Day</th>
                    <th>Date</th>
                    <!--<th class="width-100 text-center">Action</th>-->
                </tr>
                </thead>
                <tbody v-if="resultData.data !=''" id="myTable">
                <tr v-for="(value,index) in resultData.data">
                    <td>{{++index}}</td>
                    <td>{{value.get_patient ? value.get_patient.patient_name : ''}}</td>
                    <td>{{value.get_patient ? value.get_patient.gender : ''}}</td>
                    <td>{{value.get_doctor ? value.get_doctor.doctor_name : ''}}</td>
                    <td>{{value.schedule}}</td>
                    <td>{{value.day}}</td>
                    <td>{{dateFormate(value.created_at)}}</td>
                    <!--<td scope="row" class="width-100 text-center">
                        <a v-if="permissions.indexOf('appointment_booked.edit') != -1 && value.approval != 1" @click="editData(value.id)" class="btn btn-outline-success m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la la-edit"></i></a>
                        <a v-if="permissions.indexOf('appointment_booked.destroy') !=-1" @click="deleteData(value.id)" class="btn btn-outline-danger m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                    </td>-->
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
            </div>
        </div>
        <Add
                v-else-if="add_form"
        ></Add>
        <Edit
                v-else-if="edit_form"
                :edit-id="edit_id"
                :permissions="permissions"
        ></Edit>
    </div>
</template>

<script>

    import { EventBus } from '../../vue-assets';
    import Pagination from  '../../components/Pagination.vue';
    import Add from './Add.vue';
    import Edit from './Edit.vue';

    export default {
        components: {
            Add,
            Edit,
            Pagination
        },

        props:['degree_lists','permissions','speciality_lists','hospital_lists','day_lists'],

        data: function(){
            return {
                data_list:true,
                add_form:false,
                edit_form:false,
                edit_id:false,
                resultData: {},
                perPage: 10
            };
        },

        methods: {
                index(pageNo,perPage){
                    if(pageNo){ pageNo = pageNo; }else{pageNo = this.resultData.current_page; }
                    if(perPage){ perPage = perPage;}else{ perPage = this.perPage;}

                    axios.get(base_url+"appointment_booked/?page="+pageNo+"&perPage="+perPage).then((response) => {
                       this.resultData = response.data;

                    });
                },
               dateFormate(value){
                    if (value) {
                        return moment(String(value)).format('DD/MM/YYYY')
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
                deleteData(id){
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
                            axios.delete(base_url+'appointment_booked/'+id).then((response) => {
                                _this.index(1);
                                _this.showMassage(response.data);
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

                openUpdateModal(id){
                    EventBus.$emit('update-button-clicked', id);
                },

                changePerPage(){
                    var vm = this;
                    vm.index(1,vm.perPage);
                },

            datatables(){
                $(document).ready(function(){
                    $("#myInput").on("keyup", function() {
                        var value = $(this).val().toLowerCase();
                        $("#myTable tr").filter(function() {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
                },
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
                _this.index(1);
            });

            _this.index(1);
            _this.datatables();
        },
    }
</script>

