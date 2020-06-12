<template>
    <div>
        <!--begin:: Add Modal-->
        <div class="modal fade" id="addModel" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Add Health Package</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form method="POST"  enctype="multipart/form-data" v-on:submit.prevent="store" class="m-form m-form--fit m-form--label-align-right">
                        <div class="modal-body">
                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('package_name'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Package Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.package_name" placeholder="Enter Package Name" />
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('package_name'))">{{ (errors.hasOwnProperty('package_name')) ? errors.package_name[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('location'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">City Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <select style="width: 100%" class="form-control m-select2 select2"  data-index="location" v-model="form.location" >
                                        <option v-for="(svalue,sindex) in location" :value="svalue.id" > {{svalue.city_name}}</option>
                                    </select>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('location'))">{{ (errors.hasOwnProperty('location')) ? errors.location[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Age Group</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.age_group" placeholder="Enter Age Group" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">No of Tests</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.no_of_tests" placeholder="Enter No of Teests" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Price</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.price" placeholder="Enter Price" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Discount</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.discount" placeholder="Enter Discount" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Description</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <textarea v-model="form.description" class="form-control" placeholder="Enter Description"></textarea>
                                </div>
                            </div>

                            <div class="form-group m-form__group row m--margin-top-20">
                                <label for="photo" class="col-form-label col-lg-4 col-sm-12">Photo </label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="file" class="form-control editImage" id="photo" @change="onFileChange">
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
                        <h5 class="modal-title">Edit Package Name</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="la la-remove"></span>
                        </button>
                    </div>
                    <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" class="m-form m-form--fit m-form--label-align-right">
                        <div class="modal-body">
                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('package_name'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">Package Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.package_name" placeholder="Enter City name" />
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('package_name'))">{{ (errors.hasOwnProperty('package_name')) ? errors.package_name[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20" :class="{'has-danger': (errors.hasOwnProperty('location'))}">
                                <label class="col-form-label col-lg-4 col-sm-12">City Name <span class="requiredField">*</span></label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <select style="width: 100%" class="form-control m-select2 select2"  data-index="location" v-model="form.location" >
                                        <option v-for="(svalue,sindex) in location" :value="svalue.id" > {{svalue.city_name}}</option>
                                    </select>
                                    <div class="requiredField" v-if="(errors.hasOwnProperty('location'))">{{ (errors.hasOwnProperty('location')) ? errors.location[0] :'' }}</div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Age Group</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.age_group" placeholder="Enter Age Group" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">No of Tests</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.no_of_tests" placeholder="Enter No of Teests" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Price</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.price" placeholder="Enter Price" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Discount</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" v-model="form.discount" placeholder="Enter Discount" />
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label class="col-form-label col-lg-4 col-sm-12">Description</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <textarea v-model="form.description" class="form-control" placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                            <div class="form-group m-form__group row m--margin-top-20">
                                <label for="photos" class="col-form-label col-lg-4 col-sm-12">Photo </label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="file" class="form-control editImage" id="photos" @change="onFileChangeEdit">
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

        props:['location'],

        data:function(){
            return{
                form:{
                    package_name: '',
                    location: '',
                    age_group: '',
                    no_of_tests: '',
                    description: '',
                    price: '',
                    discount: '',
                    photo: '',
                    status:'1'
                },
                errors: {},
            };
        },

        methods:{
            store:function(){
                axios.post(base_url+'health_package', this.form).then( (response) => {
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
                axios.put(base_url+'health_package/'+id, this.form).then( (response) => {
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

            onFileChange(e) {

                let files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                let reader = new FileReader();

                let vm = this;
                reader.onload = (e) => {
                    vm.form.photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },


            onFileChangeEdit(e) {

                let files = e.target.files || e.dataTransfer.files;

                if (!files.length)
                    return;
                this.createImageEdit(files[0]);
            },

            createImageEdit(file) {
                let reader = new FileReader();

                let vm = this;
                reader.onload = (e) => {
                    vm.form.package_photo = e.target.result;
                };
                reader.readAsDataURL(file);
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


            $('#addModel,#editModel').on('change', '.select2', function (e) {

                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');
                  _this.form.location = selectedItem.val();

            });


           $('#addModel,#editModel').on('hidden.bs.modal', function(){
               _this.errors = {};
               _this.form = {'package_name':'','location':'','description':'','status':'1'};
           });

            EventBus.$on('update-button-clicked', (id) => {
                _this.errors = {};
                axios.get(base_url+'health_package/'+id+'/edit').then((response) => {
                    _this.form = response.data;
                    $('#editModel').modal("show");

                    setTimeout(function () {
                        var Select2= {init:function() {$(".select2").select2( {placeholder: "Please select an option"})}};
                        jQuery(document).ready(function() {Select2.init()});
                    },100);
                });
            });

        },

        created(){

        }

    }
</script>
