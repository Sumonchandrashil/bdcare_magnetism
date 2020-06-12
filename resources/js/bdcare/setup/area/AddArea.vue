<template>
    <div>
        <!--begin:: Add Modal-->
        <div class="modal fade" id="addModel" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Add Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form method="POST" id="addComponent"  enctype="multipart/form-data" v-on:submit.prevent="store" class="m-form m-form--fit m-form--label-align-right">
                        <div class="modal-body">

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('city'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">City Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <select style="width: 100%" id="city" class="form-control m-select2 select2"  data-index="city" v-model="form.city" >
                                        <option v-for="(svalue,sindex) in city" :value="svalue.id" > {{svalue.city_name}}</option>
                                    </select>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('city'))">{{ (errors.hasOwnProperty('city')) ? errors.city[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('area_name'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Area Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.area_name" placeholder="Enter Area name" />
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('area_name'))">{{ (errors.hasOwnProperty('area_name')) ? errors.area_name[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Description</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <textarea v-model="form.description" class="form-control" placeholder="Enter Description"></textarea>
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
                        <h5 class="modal-title">Edit Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form method="POST" id="editComponent" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" class="m-form m-form--fit m-form--label-align-right">
                        <div class="modal-body">

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('city'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">City Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <select style="width: 100%" class="form-control m-select2 select2"  data-index="city" v-model="form.city" >
                                        <option v-for="(svalue,sindex) in city" :value="svalue.id" > {{svalue.city_name}}</option>
                                    </select>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('city'))">{{ (errors.hasOwnProperty('city')) ? errors.city[0] :'' }}</div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('area_name'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Area Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.area_name" placeholder="Enter Area name" />
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('area_name'))">{{ (errors.hasOwnProperty('area_name')) ? errors.area_name[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Description</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <textarea v-model="form.description" class="form-control" placeholder="Enter Description"></textarea>
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
    import { EventBus } from '../../../vue-assets';

    export default {

        data:function(){
            return{
                form:{
                    city: '',
                    area_name: '',
                    description: '',
                    status:'1'
                },
                errors: {},
            };
        },

        props:['city'],

        methods:{
            store:function(){
                axios.post(base_url+'setup_area', this.form).then( (response) => {
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
                axios.put(base_url+'setup_area/'+id, this.form).then( (response) => {
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
               _this.form = {'area_name':'','description':'','status':'1'};
           });

            EventBus.$on('update-button-clicked', (id) => {
                _this.errors = {};
                axios.get(base_url+'setup_area/'+id+'/edit').then((response) => {
                    _this.form = response.data;
                    $('#editModel').modal("show");
                    var Select2= {
                        init:function() {
                            $(".select2").select2( {
                                    placeholder: "Please select an option"
                                }
                            )
                        }
                    };
                    jQuery(document).ready(function() {
                            Select2.init()
                        }
                    );
                });
            });


            $('#addComponent,#editComponent').on('change', '.select2', function (e) {

                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.city = selectedItem.val();
            });

            var Select2= {
                init:function() {
                    $(".select2").select2( {
                            placeholder: "Please select an option"
                        }
                    )
                }
            };
            jQuery(document).ready(function() {
                    Select2.init()
                }
            );

        },



        created(){

        }

    }
</script>
