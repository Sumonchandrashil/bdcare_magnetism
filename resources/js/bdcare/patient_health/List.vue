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
                    <th>Title</th>
                    <th>Image</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody v-if="resultData.data !==''" id="myTable">
                <tr v-for="(value,index) in resultData.data">
                    <td>{{++index}}</td>
                    <td>{{value.title}}</td>
                    <td>
                        <img :src="getImgUrl('public/uploads/medical_records/', value.image)" class="imageSize"
                             width="70px">
                    </td>
                    <td>
                        <div v-if="value.status === 1" class="m-demo__preview m-demo__preview&#45;&#45;badge">
                            <span
                                class="m-badge m-badge&#45;&#45;success m-badge&#45;&#45;wide m-badge&#45;&#45;rounded"> <i
                                class="la la-check-circle"></i> Active </span>
                        </div>
                        <div v-if="value.status === 0" class="m-demo__preview m-demo__preview&#45;&#45;badge">
                            <span
                                class="m-badge m-badge&#45;&#45;danger m-badge&#45;&#45;wide m-badge&#45;&#45;rounded"> <i
                                class="la la-ban"></i> Inactive</span>
                        </div>
                    </td>
                </tr>
                </tbody>
                <tbody v-else>
                <tr>
                    <td colspan="4" class="text-center">No Data Available.</td>
                </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="text-center col-md-12">
                    <pagination :resultData="resultData" @clicked="index" :mid-size="9"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Pagination from '../../components/Pagination.vue';

    export default {
        components: {
            Pagination,
        },

        props: ['permissions', 'patient_health'],

        data: function () {
            return {
                data_list: true,
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

                axios.get(base_url + "health_record/?page=" + pageNo + "&perPage=" + perPage).then((response) => {
                    this.resultData = response.data;

                });
            },

            getImgUrl(path, file_name) {
                if (file_name) {
                    return base_url + path + file_name;
                }

            },

            changePerPage() {
                var vm = this;
                vm.index(1, vm.perPage);
            },
        },

        created() {
            var _this = this;
            _this.index(1);
        },
    }
</script>

