<template>
    <div>
        <!--begin::Form-->
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" id="editComponent" class="m-form m-form--fit m-form--label-align-right" >
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="patient_name" class="col-lg-2 col-form-label">Patient Name <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input type="text" id="patient_name" v-model="form.patient_name" class="form-control form-control-sm m-input" placeholder="Enter Patient Name">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('patient_name'))">{{ (errors.hasOwnProperty('patient_name')) ? errors.patient_name[0] :'' }}</div>
                    </div>
                    <label for="Visit" class="col-lg-2 col-form-label">Email<span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input type="email" id="Visit" v-model="form.email" class="form-control form-control-sm m-input" placeholder="Enter Email Address">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('email'))">{{ (errors.hasOwnProperty('email')) ? errors.email[0] :'' }}</div>
                    </div>

                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label" for="contact">Contact<span class="requiredField">*</span> </label>
                    <div class="col-lg-4">
                        <input type="number" step="any" id="contact" v-model="form.contact" class="form-control form-control-sm m-input" placeholder="Enter Visit fees">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('contact'))">{{ (errors.hasOwnProperty('contact')) ? errors.contact[0] :'' }}</div>
                    </div>
                    <label class="col-lg-2 col-form-label" for="gender">Gender <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <select id="gender" class="form-control m-select2 select2 select-gender" data-index="gender" v-model="form.gender">
                                <option value="M" > Male </option>
                                <option value="F" > FeMale </option>
                            </select>
                            <div class="requiredField" v-if="(errors.hasOwnProperty('gender'))">{{ (errors.hasOwnProperty('gender')) ? errors.gender[0] :'' }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="address">Address</label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.address"  id="address" rows="2"></textarea>
                    </div>

                    <label class="col-lg-2 col-form-label" for="detail">Details</label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.details"  id="detail" rows="2"></textarea>
                    </div>
                </div>
                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="occupation">Occupation</label>
                    <div class="col-lg-4">
                        <input type="text" id="occupation" v-model="form.occupation" class="form-control form-control-sm m-input" placeholder="Enter occupation">
                    </div>

                    <label class="col-lg-2 col-form-label">Status <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div :class="{'has-danger': (errors.hasOwnProperty('status'))}">
                            <span class="m-switch m-switch--icon">
                                <label>
                                    <input type="checkbox" checked="checked" v-model="form.status">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                </div>
                <br><br>
                <!--begin::Portlet-->

                <div class="form-group m-form__group row">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Diseases</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Disease Name <span class="requiredField">*</span></th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(disease_details, index) in form.disease_details">
                                    <th scope="row">
                                        <a href="javascript:void(0)"  @click="addNewItem" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Add More">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <select style="width: 100%" class="form-control m-select2 select2 select-disease" v-bind:data-index="index" v-model="disease_details.disease_id">
                                            <option v-for="(value,index) in disease_lists" :value="value.id"> {{value.disease_name}}</option>
                                        </select>
                                        <div class="requiredField" v-if="errors['disease_details.'+index+'.disease_id']">{{ errors['disease_details.'+index+'.disease_id'][0] }}</div>
                                    </td>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="disease_details.remarks" class="form-control form-control-sm m-input" placeholder="">
                                    </td>
                                    <td>
                                        <a @click="removeItem(index,disease_details.disease_id)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Surgery Info</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Surgery Name <span class="requiredField">*</span></th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(surgery_details, index) in form.surgery_details">
                                    <th scope="row">
                                        <a href="javascript:void(0)"  @click="addNewItemSurgery" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Add More">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="surgery_details.surgery_name" class="form-control form-control-sm m-input" placeholder="">
                                        <div class="requiredField" v-if="errors['surgery_details.'+index+'.surgery_name']">{{ errors['surgery_details.'+index+'.surgery_name'][0] }}</div>
                                    </td>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="surgery_details.remarks" class="form-control form-control-sm m-input" placeholder="">
                                    </td>
                                    <td>
                                        <a @click="removeItemSurgery(index,surgery_details.id)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Allergy</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Allergy Name <span class="requiredField">*</span></th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(allergy_details, index) in form.allergy_details">
                                    <th scope="row">
                                        <a href="javascript:void(0)"  @click="addNewItemAllergy" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Add More">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="allergy_details.allergy_name" class="form-control form-control-sm m-input" placeholder="">
                                        <div class="requiredField" v-if="errors['allergy_details.'+index+'.allergy_name']">{{ errors['allergy_details.'+index+'.allergy_name'][0] }}</div>
                                    </td>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="allergy_details.remarks" class="form-control form-control-sm m-input" placeholder="">
                                    </td>
                                    <td>
                                        <a @click="removeItemAllergy(index,allergy_details.id)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>
            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                <div class="m-form__actions m-form__actions--solid">
                    <div class="row">
                        <div class="col-lg-12 m--align-right">
                            <button type="submit" class="btn btn-sm btn-success" ><i class="la la-check"></i> <span>Update and Go List</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--end::Form-->
    </div>
</template>
<script>
    import { EventBus } from '../../vue-assets';
    export default {

        props:['editId','permissions','disease_lists'],
        data:function(){
            return{
                data_list:false,
                add_form:true,
                edit_form:false,
                form:{
                    patient_name: '',
                    email: '',
                    contact: '',
                    gender:'',
                    address: '',
                    details:'',
                    occupation:'',
                    status:'',
                    disease_details: [
                        {
                            disease_id: '',
                            remarks: '',
                        }
                    ],
                    surgery_details: [
                        {
                            surgery_name: '',
                            remarks: '',
                        }
                    ],
                    allergy_details: [
                        {
                            allergy_name: '',
                            remarks: '',
                        }
                    ],
                },
                errors: {},
            };
        },

        methods:{

            duplicateCheck(){
                var no_index = this.form.disease_details.length;
                var details = this.form.disease_details;
                if (no_index > 1) {
                    for (let i = 0; i < no_index; i++) {
                        for (let j = i+1; j < no_index; j++) {
                            if(details[i].disease_id == details[j].disease_id) {
                                alert("Duplicate. Disease Already Selected");
                                details[j].disease_id = '';
                                var Select2 = {
                                    init: function () {
                                        $(".select2").select2({
                                            placeholder: "Please select an option"
                                        })
                                    }
                                };
                                jQuery(document).ready(function () {
                                    Select2.init()
                                });
                            }
                        }
                    }
                }
            },

            addNewItem(){
                this.form.disease_details.push({
                    disease_id: '',
                    remarks: '',
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

            removeItem(index,deletedId){
                var _this = this;
                if(_this.form.disease_details.length > 1){
                    _this.form.disease_details.splice(index, 1);
                    if (deletedId) {
                        _this.form.deleteIDDisease.push(deletedId);
                    }
                }
            },

            addNewItemSurgery(){
                this.form.surgery_details.push({
                    surgery_name: '',
                    remarks: '',
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

            removeItemSurgery(index,deleteID){

                var _this = this;
                if(_this.form.surgery_details.length > 1){
                    _this.form.surgery_details.splice(index, 1);
                    if (deletedId) {
                        _this.form.deleteIDSurgery.push(deletedId);
                    }
                }
            },

            addNewItemAllergy(){
                this.form.allergy_details.push({
                    allergy_name: '',
                    remarks: '',
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

            removeItemAllergy(index,deleteID){

                var _this = this;
                if(_this.form.allergy_details.length > 1){
                    _this.form.allergy_details.splice(index, 1);

                        _this.form.deleteIDAllergy.push(deletedId);

                }
            },

            edit(id) {
                var _this = this;
                axios.get(base_url+'patient_profile/'+id+'/edit')
                    .then( (response) => {
                        _this.form  = response.data.data;
                        setTimeout(function () {
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
                        },100);
                    });
            },

            update(id){

                axios.put(base_url+'patient_profile/'+id, this.form).then( (response) => {
                    this.showMassage(response.data);
                    EventBus.$emit('data-changed');
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
                    toastr.success(data.message, 'Success Alert');
                }else if(data.status == 'error'){
                    toastr.error(data.message, 'Error Alert');
                }else{
                    toastr.error(data.message, 'Error Alert');
                }
            },
        },

        mounted(){

            var _this = this;

            $('#editComponent').on('change', '.select-gender', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.gender = selectedItem.val();
            });

            $('#editComponent').on('change', '.select-disease', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.disease_details[dataIndex].disease_id = selectedItem.val();

                _this.duplicateCheck();
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
            var _this = this;
            _this.edit(_this.editId);
        }

    }
</script>
