<template>
    <div>
        <div class="m-portlet__body table-responsive">
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

        </div>
          <Add
           :location="location"
          ></Add>
    </div>
</template>

<script>

    import { EventBus } from '../../../vue-assets';
    import Add from './Add.vue';
    import VdtnetTable from 'vue-datatables-net';

    export default {
        components: {
            Add,
            VdtnetTable
        },

        props:['permissions','location'],

        data: function(){
            return {
                //VdtnetTable Options
                tableId: 'health_package',
                options: {
                    ajax: {
                        url: base_url+"health_package",
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
                    package_name: { label: 'Package Name', sortable: true, searchable: true, defaultOrder: 'DESC'  },
                    'cities.city_name': { label: 'Location', template:"{{ row.city_name}}", sortable: true, searchable: true  },
                    age_group: { label: 'Age Group', sortable: false, searchable: false  },
                    //photo: { label: 'Photo',  sortable: false, searchable: false  },
                    no_of_tests: { label: 'No of Tests', sortable: false, searchable: false  },
                    description: { label: 'Description', sortable: false, searchable: false  },
                    price: { label: 'Price', sortable: false, searchable: false  },
                    discount: { label: 'Discount', sortable: false, searchable: false  },

                    status: {
                        label: 'Status',sortable: false, searchable: false,
                        render: (data) => {
                            if (data==1) {
                                return '<div class="m-demo__preview m-demo__preview--badge"> <span class="m-badge m-badge--success m-badge--wide m-badge--rounded"> <i class="la la-check-circle"></i> Active </span></div>';
                            } else {
                                return '<div class="m-demo__preview m-demo__preview--badge"> <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded"> <i class="la la-ban"></i> Inactive</span></div>';
                            }
                        }
                    },
                    actions: {
                        isLocal: true,
                        label: 'Actions',
                        render: (data,type,row,meta) => {
                            var htmlButtons = '';

                            htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="edit" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Edit"><i class="la   la-edit"></i></a>';

                            htmlButtons = htmlButtons + ' <a href="javascript:void(0);" data-action="delete" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>';

                            return htmlButtons;
                        }
                    }
                },
                quickSearch: '',
            };
        },

        methods: {


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
                            axios.delete(base_url+'health_package/'+id).then((response) => {
                               // _this.index(1);
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

                openUpdateModal(id){
                    EventBus.$emit('update-button-clicked', id);
                },

            //VdtnetTable Methods
            doAlertEdit(data) {
                this.openUpdateModal(data.id);
            },
            doAlertDelete(data, row, tr, target) {

                this.deleteData(data.id,tr);
            },
            doSearch() {
                this.$refs.table.search(this.quickSearch)
            },
            doExport(type) {
                const parms = this.$refs.table.getServerParams()
                parms.export = type
                window.alert('GET /api/v1/export?' + jQuery.param(parms))
            },
            doReload() {
                const table = this.$refs.table
                setTimeout(() => {
                    // simulate extra long running ajax
                    table.reload()
                }, 500)
            },

            /*makeImge(path){
                if(path){
                    return base_url+"uploads/health_package_photo/"+path;
                }else{
                    return base_url+"uploads/vendor_category_image/demo.png";
                }
            },*/


        },

            created() {
               var _this = this;
              // _this.index(1);
                EventBus.$on('new-data-created', function () {
                    _this.doReload();
                });

                setTimeout(function () {
                    const vdt_parms = _this.$refs.table.getServerParams();
                    if (vdt_parms.search.value) {
                        _this.quickSearch = vdt_parms.search.value;
                        $('#quickSearch').focus();
                    }
                },900);
            }

    }
</script>

