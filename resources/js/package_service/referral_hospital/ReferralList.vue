<style scoped>
    .imageSize {
        width: 70px;
        height: 70px;
    }
</style>
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
                    <th>Patient Age</th>
                    <th>Care Giver Name</th>
                    <th>Care Giver Age</th>
                    <th>Passport No</th>
                    <th>Wheel Chair</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                    <th>Date of Travel</th>
                    <th>Hospital Name</th>
                    <th>Medical Report</th>
                </tr>
                </thead>
                <tbody v-if="resultData.data !==''" id="myTable">
                <tr v-for="(value,index) in resultData.data">
                    <td>{{++index}}</td>
                    <td>{{value.patient_name}}</td>
                    <td>{{value.patient_age}}</td>
                    <td>{{value.care_giver_name}}</td>
                    <td>{{value.care_giver_age}}</td>
                    <td>{{value.passport_no}}</td>
                    <td>{{value.wheel_chair==="1"?"Yes":"No"}}</td>
                    <td>{{value.address}}</td>
                    <td>{{value.mobile_number}}</td>
                    <td>{{value.email}}</td>
                    <td>{{value.date_of_travel}}</td>
                    <td>{{value.hospital_name}}</td>
                    <td><img :src="'http://bd.care/public/medical_report/'+value.medical_report" class="imageSize"></td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="8" class="text-center">No Data Available.</td>
                </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="text-center col-md-12">
                    <pagination :resultData="resultData" @clicked="index" :mid-size="14"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import {EventBus} from '../../vue-assets';
    import Pagination from '../../components/Pagination.vue';

    export default {
        components: {
            Pagination
        },

        props: ['permissions'],

        data: function () {
            return {
                data_list: true,
                add_form: false,
                edit_form: false,
                edit_id: false,
                resultData: {},
                perPage: 10
            };
        },

        methods: {
            index(pageNo, perPage) {
                if (pageNo) {
                    pageNo = pageNo;
                } else {
                    pageNo = this.resultData.current_page;
                }
                if (perPage) {
                    perPage = perPage;
                } else {
                    perPage = this.perPage;
                }
                axios.get(base_url + "referral-hospital/?page=" + pageNo + "&perPage=" + perPage).then((response) => {
                    this.resultData = response.data;

                });
            },
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
                _this.edit_id = id;
                $('#addButton').hide();
                $('#listButton').show();
            },

            showMassage(data) {
                if (data.status == 'success') {
                    toastr.success(data.message, 'Success Alert', {timeOut: 5000});
                } else {
                    toastr.error(data.message, 'Error Alert', {timeOut: 5000});
                }
            },

            openUpdateModal(id) {
                EventBus.$emit('update-button-clicked', id);
            },

            changePerPage() {
                var vm = this;
                vm.index(1, vm.perPage);
            },

            datatables() {
                $(document).ready(function () {
                    $("#myInput").on("keyup", function () {
                        var value = $(this).val().toLowerCase();
                        $("#myTable tr").filter(function () {
                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                        });
                    });
                });
            },
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

