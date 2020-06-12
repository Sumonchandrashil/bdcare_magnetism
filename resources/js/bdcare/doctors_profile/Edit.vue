<template>
    <div>
        <!--begin::Form-->
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" id="editComponent" class="m-form m-form--fit m-form--label-align-right" >
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="requisition_no" class="col-lg-2 col-form-label">Doctors Name </label>
                    <div class="col-lg-4">
                        <input type="text" id="requisition_no" v-model="form.doctor_name" class="form-control form-control-sm m-input" placeholder="Enter Hospital Name">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('doctor_name'))">{{ (errors.hasOwnProperty('doctor_name')) ? errors.doctor_name[0] :'' }}</div>

                    </div>
                    <label for="Visit" class="col-lg-2 col-form-label">Visit fees<span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input type="text" id="Visit" v-model="form.visiting_fees" class="form-control form-control-sm m-input" placeholder="Enter Visiting fees">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('visiting_fees'))">{{ (errors.hasOwnProperty('visiting_fees')) ? errors.visiting_fees[0] :'' }}</div>
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
                            <div class="requiredField" v-if="errors['gender']">{{ errors['gender'][0] }}</div>

                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="address">Address</label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.address"  id="address" rows="2"></textarea>
                    </div>

                    <label class="col-lg-2 col-form-label" for="experience"> Experience </label>
                    <div class="col-lg-4">
                        <input type="number" step="any" id="experience" v-model="form.experience" class="form-control form-control-sm m-input" placeholder="Enter year Experience">
                        <div class="requiredField" v-if="errors['experience']">{{ errors['experience'][0] }}</div>
                    </div>
                </div>
                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="summary"> Summary </label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.summary"  id="summary" rows="2"></textarea>
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

                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label">Premium <span class="requiredField"></span></label>
                    <div class="col-lg-4">
                        <div class="m-checkbox-list">
                            <label class="m-checkbox">
                                <input type="checkbox" v-model="form.premium"> yes/no ?
                                <span></span>
                            </label>
                        </div>
                        <div class="requiredField" v-if="(errors.hasOwnProperty('premium'))">{{ (errors.hasOwnProperty('premium')) ? errors.premium[0] :'' }}</div>
                    </div>

                </div>
                <br><br>
                <!--begin::Portlet-->

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

        /*props:['degree_lists','editId','permissions','speciality_lists','hospital_lists','day_lists'],*/
        props:['editId','permissions'],
        data:function(){
            return{
                data_list:false,
                add_form:true,
                edit_form:false,
                form:{
                    doctor_name: '',
                    visiting_fees: '',
                    contact: '',
                    gender:'',
                    address: '',
                    experience:'',
                    summary:'',
                    premium:'',

                },
                errors: {},
            };
        },

        methods:{

            edit(id) {
                var _this = this;
                axios.get(base_url+'doctors_profile/'+id+'/edit')
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

                axios.put(base_url+'doctors_profile/'+id, this.form).then( (response) => {
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
