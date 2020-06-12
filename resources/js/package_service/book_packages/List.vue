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
                >
                </vdtnet-table>
            </div>
        </div>
    </div>
</template>

<script>

    import VdtnetTable from 'vue-datatables-net';

    export default {
        components: {
            VdtnetTable
        },

        props: [],

        data: function () {
            return {
                data_list: true,

                //VdtnetTable Options
                tableId: 'book-package',
                options: {
                    ajax: {
                        url: base_url + "book-package",
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
                    name: {label: 'Name', sortable: true, searchable: true, defaultOrder: 'asc'},
                    email: {label: 'Email', sortable: true, searchable: true, defaultOrder: 'asc'},
                    number: {label: 'Number', sortable: true, searchable: true, defaultOrder: 'asc'},

                    address: {label: 'Address', sortable: false, searchable: false},
                    'booked_packages.package_id': {
                        label: 'Package',
                        template: '{{ row.package_name }}',
                        sortable: false,
                        searchable: false
                    },
                },
                quickSearch: '',
            };
        },

        methods: {
            //VdtnetTable Methods
            doSearch() {
                this.$refs.table.search(this.quickSearch)
            },
        },

        created() {
            var _this = this;
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

