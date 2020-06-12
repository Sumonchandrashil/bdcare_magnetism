<template>
    <div>
        <!--begin:: Add Modal-->
        <div class="modal fade" id="addModel" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Add Help Center</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form method="POST"  enctype="multipart/form-data" v-on:submit.prevent="store" class="m-form m-form--fit m-form--label-align-right">
                        <div class="modal-body">
                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('title'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Title <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.title" placeholder="Enter Complain Title Name" />
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('title'))">{{ (errors.hasOwnProperty('title')) ? errors.title[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('entry_date'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Date <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" id="date" class="form-control form-control-sm m-input datepicker" v-model="form.entry_date" data-dateField="entry_date" placeholder="Select date from picker"  />
                                        <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('entry_date'))">{{ (errors.hasOwnProperty('entry_date')) ? errors.entry_date[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('terms_condition'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Terms and Condition <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <textarea v-model="form.terms_condition" class="form-control form-control-sm" placeholder="Terms and Condition"></textarea>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('terms_condition'))">{{ (errors.hasOwnProperty('terms_condition')) ? errors.terms_condition[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row" :class="{'has-danger': (errors.hasOwnProperty('status'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Status <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <span class="m-switch m-switch--icon">
                                        <label>
                                            <input type="checkbox" checked="checked" v-model="form.status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-success" ><i class="la la-check"></i> <span>Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->
        <!--begin:: Add Modal-->
        <div class="modal fade" id="editModel" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Help Center</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" class="m-form m-form--fit m-form--label-align-right">
                        <div class="modal-body">
                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('title'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Title <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.title" placeholder="Enter Complain Title Name" />
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('title'))">{{ (errors.hasOwnProperty('title')) ? errors.title[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('entry_date'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Date <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" id="date2" class="form-control form-control-sm m-input datepicker" v-model="form.entry_date" data-dateField="entry_date" placeholder="Select date from picker"  />
                                        <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="la la-calendar-check-o"></i>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('entry_date'))">{{ (errors.hasOwnProperty('entry_date')) ? errors.entry_date[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('terms_condition'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Terms and Condition <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <textarea v-model="form.terms_condition" class="form-control form-control-sm" placeholder="Terms and Condition"></textarea>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('terms_condition'))">{{ (errors.hasOwnProperty('terms_condition')) ? errors.terms_condition[0] :'' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-success" ><i class="la la-check"></i> <span>Update</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Modal-->
    </div>
</template>

<script>
    import { EventBus } from '../../vue-assets';

    export default {

        data:function(){
            return{
                form:{
                    title: '',
                    entry_date: '',
                    terms_condition: '',
                    status:'1'
                },
                errors: {},
            };
        },

        methods:{
            store:function(){
                axios.post(base_url+'help-center', this.form).then( (response) => {
                    $('#addModel').modal('hide');
                    this.showMassage(response.data);
                    EventBus.$emit('new-data-created');
                })
                .catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }else{
                        this.showMassage(error);
                    }
                });
            },

            update:function (id) {
                axios.put(base_url+'help-center/'+id, this.form).then( (response) => {
                    $('#editModel').modal('hide');
                    this.showMassage(response.data);
                    EventBus.$emit('new-data-created');
                })
                .catch(error => {
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors;
                    }else{
                        this.showMassage(error);
                    }
                });
            },

            showMassage(data){
                if(data.status == 'success'){
                    toastr.success(data.message, 'Success');
                }else if(data.status == 'error'){
                    toastr.error(data.message, 'Error');
                }else{
                    toastr.error(data.message, 'Error');
                }
            },
        },

        mounted(){
           var _this = this;
           $('#addModel,#editModel').on('hidden.bs.modal', function(){
               _this.errors = {};
               _this.form = {
                   'title':'',
                   'entry_date':'',
                   'terms_condition':'',
                   'status':'1'
               };
           });

            $(document).on("focus", ".datepicker", function () {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    //startDate: new Date(),
                    //startDate: '-10d',
                }).on('changeDate', function (ev) {

                    $(this).datepicker('hide');
                    if(ev.date == undefined){
                        _this.form.entry_date = '';

                    }else {
                        _this.form.entry_date = moment(ev.date).format('DD/MM/YYYY');

                    }

                });
            });

            EventBus.$on('update-button-clicked', (id) => {
                _this.errors = {};
                axios.get(base_url+'help-center/'+id+'/edit').then((response) => {
                    _this.form = response.data;
                    $('#editModel').modal("show");
                });
            });

        },

        created(){

        }

    }
</script>
