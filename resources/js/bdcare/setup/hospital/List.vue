<template>
    <div>
        <div class="m-portlet__body table-responsive" v-if="data_list">
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
                    <th>Logo</th>
                    <th>Hospital Name</th>
                    <th>Help Line</th>
                    <th>Area</th>
                    <th>City</th>
                    <th>Type</th>
                    <th>Emergency Details</th>
                    <th>Web Link</th>
                    <th class="width-100 text-center">Action</th>
                </tr>
                </thead>
                <tbody v-if="resultData.data !=''" id="myTable">
                <tr v-for="(value,index) in resultData.data">
                    <td>{{++index}}</td>
                    <td>
                        <img :src="getImgUrl('public/uploads/hospital_logo/thumb/', value.logo)" class="imageSize" width="70px">
                    </td>
                    <td>{{value.hospital_name}}</td>
                    <td>Help Line</td>
                    <td>{{value.get_areas ? value.get_areas.area_name : ''}}</td>
                    <td>{{value.get_cities ? value.get_cities.city_name : ''}}</td>
                    <td>{{value.type}}</td>
                    <td>{{value.emergency_details}}</td>
                    <td>
                        <a v-if="value.web_address" :href="value.web_address" target="_blank" class="btn btn-outline-info m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" :title="value.web_address"><i class="la la-link"></i></a>
                    </td>

                    <td scope="row" class="width-100 text-center">
                        <!--<a @click="viewData(value.id)" class="btn btn-outline-success m-btn m-btn&#45;&#45;icon m-btn&#45;&#45;icon-only m-btn&#45;&#45;pill m-btn&#45;&#45;air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="View"><i class="la la-eye"></i></a>-->
                        <a v-if="permissions.indexOf('setup_hospital.edit') != -1 && value.approval != 1" @click="editData(value.id)" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la la-edit"></i></a>
                        <a v-if="permissions.indexOf('setup_hospital.destroy') !=-1" @click="deleteData(value.id)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="14" class="text-center">No Data Available.</td>
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
                :product_lists="product_lists"
                :area_lists="area_lists"
                :city_lists="city_lists"
        ></Add>
        <Edit
                v-else-if="edit_form"
                :edit-id="edit_id"
                :product_lists="product_lists"
                :area_lists="area_lists"
                :city_lists="city_lists"
                :permissions="permissions"
        ></Edit>
    </div>
</template>

<script>

    import { EventBus } from '../../../vue-assets';
    import Pagination from  '../../../components/Pagination.vue';
    import Add from './Add.vue';
    import Edit from './Edit.vue';

    export default {
        components: {
            Add,
            Edit,
            Pagination
        },

        props:['product_lists','permissions','area_lists','city_lists'],

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

                    axios.get(base_url+"setup_hospital/?page="+pageNo+"&perPage="+perPage).then((response) => {
                       this.resultData = response.data;

                    });
                },

                getImgUrl(path,file_name){
                    if (file_name) {
                        return base_url+path+file_name;
                    }
                    return;
                },

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
                            axios.delete(base_url+'setup_hospital/'+id).then((response) => {
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

