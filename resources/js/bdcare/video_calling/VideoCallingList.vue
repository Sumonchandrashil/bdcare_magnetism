<template>
    <div>
        <div class="m-portlet__body" v-if="show_list">
            <div class="row">
                <div class="item-show-limit col-md-8">
                </div>
                <div class="col-md-4">
                    <form @submit.stop.prevent="doSearch" class="form-inline d-flex mx-1 justify-content-end">
                        <div class="input-group">
                            <input class="form-control" id="quickSearch" placeholder="Quick search" type="search"
                                   v-model="quickSearch">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="mdi mdi-magnify"/> Go
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--begin: Datatable -->
            <div class="table-responsive">
                <vdtnet-table :fields="fields" :id="tableId" :opts="options" @view="doView" ref="table">
                </vdtnet-table>
            </div>

        </div>

        <ViewVideoCalling :edit-id="edit_id"
                          v-else-if="view_form"
                          :permissions="permissions"
        ></ViewVideoCalling>

    </div>
</template>

<script>

    import {EventBus} from '../../vue-assets';

    import ViewVideoCalling from './ViewVideoCalling.vue';

    import VdtnetTable from 'vue-datatables-net';

    export default {
        components: {
            ViewVideoCalling,
            VdtnetTable
        },

        props: ['permissions'],

        data: function () {
            return {
                show_list: true,
                view_form: false,

                //VdtnetTable Options
                tableId: 'twilio_videos',
                options: {
                    ajax: {
                        url: base_url + "report-video-calls",
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
                    RoomStatus: {label: 'Room Status', sortable: true, searchable: true},
                    'twilio_videos.RoomName': {label: 'Room Name', template:"{{row.room_name}}", sortable: true, searchable: true},
                    'twilio_videos.callerUserId': {label: 'Caller User Id', template:"{{row.caller_name}}", sortable: true, searchable: true},
                    'twilio_videos.recipientUserId': {label: 'Recipient User Id', template:"{{row.recipient_name}}", sortable: true, searchable: true},
                    RoomDuration: {label: 'Room Duration', sortable: true, searchable: true},

                    actions: {
                        isLocal: true, sortable: false, searchable: false,
                        label: 'Actions',
                        render: (data, type, row, Meta) => {
                            var htmlButtons = '';
                            htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="view" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="View"><i class="la la-eye"></i></a>';
                            return htmlButtons;
                        }
                    }
                },
                quickSearch: '',
            };
        },

        methods: {

            viewData(id) {
                var _this = this;
                _this.show_list = false;
                _this.view_form = true;
                _this.edit_id = id;
                $('#listButton').show();
                console.log(87)
            },

            showMassage(data) {
                if (data.status === 'success') {
                    toastr.success(data.message, 'Success Alert', {timeOut: 5000});
                } else {
                    toastr.error(data.message, 'Error Alert', {timeOut: 5000});
                }
            },

            //VdtnetTable Methods
            doView(data) {
                this.viewData(data.id);
            },
            doSearch() {
                this.$refs.table.search(this.quickSearch)
            },
        },

        created() {
            var _this = this;

            $('body').on('click', '#viewButton', function () {
                _this.view_form = true;
                _this.show_list = false;
                $('#viewButton').hide();
                $('#listButton').show();
            });

            $('body').on('click', '#listButton', function () {
                _this.view_form = false;
                _this.show_list = true;
                $('#viewButton').show();
                $('#listButton').hide();
            });

            EventBus.$on('data-changed', (id) => {
                _this.view_form = false;
                _this.show_list = true;
                $('#viewButton').show();
                $('#listButton').hide();
            });

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

