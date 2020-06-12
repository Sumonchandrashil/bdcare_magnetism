<template>
    <div>
        <!--begin::Form-->
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="store" id="addComponent" class="m-form m-form--fit m-form--label-align-right" >
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="doctor_name" class="col-lg-2 col-form-label">Doctors Name <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input type="text" id="doctor_name" v-model="form.doctor_name" class="form-control form-control-sm m-input" placeholder="Enter Doctor Name">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('doctor_name'))">{{ (errors.hasOwnProperty('doctor_name')) ? errors.doctor_name[0] :'' }}</div>
                        <!--<div class="requiredField" v-if="errors['doctor_name']">{{ errors['doctor_name'][0] }}</div>-->
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
                            <div class="requiredField" v-if="(errors.hasOwnProperty('gender'))">{{ (errors.hasOwnProperty('gender')) ? errors.gender[0] :'' }}</div>
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
                <br><br>
                <!--begin::Portlet-->

                <div class="form-group m-form__group row" style="display: none">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Degrees</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Degree Name <span class="requiredField">*</span></th>
                                    <th>Institute</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(degree_details, index) in form.degree_details">
                                    <th scope="row">
                                        <a href="javascript:void(0)"  @click="addNewItemDegree" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Add More">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <select style="width: 100%" class="form-control m-select2 select2 select-degree" v-bind:data-index="index" v-model="degree_details.degree_id">
                                            <option v-for="(value,index) in degree_lists" :value="value.id"> {{value.degree_name}}</option>
                                        </select>
                                        <div class="requiredField" v-if="errors['degree_details.'+index+'.degree_id']">{{ errors['degree_details.'+index+'.degree_id'][0] }}</div>
                                    </td>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="degree_details.institute" class="form-control form-control-sm m-input" placeholder="Name of the institute">
                                        <div class="requiredField" v-if="errors['degree_details.'+index+'.institute']">{{ errors['degree_details.'+index+'.institute'][0] }}</div>

                                    </td>
                                    <td>
                                        <a @click="removeItemDegree(index)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
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
                <div class="form-group m-form__group row" style="display: none">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Speciality</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Speciality Name <span class="requiredField">*</span></th>
                                    <th>Remarks</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(details, index) in form.details">
                                    <th scope="row">
                                        <a href="javascript:void(0)"  @click="addNewItem" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Add More">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <select style="width: 100%" class="form-control m-select2 select2 select-product" v-bind:data-index="index" v-model="details.speciality_id">
                                            <option v-for="(value,index) in speciality_lists" :value="value.id"> {{value.speciality_name}}</option>
                                        </select>
                                        <div class="requiredField" v-if="errors['details.'+index+'.speciality_id']">{{ errors['details.'+index+'.speciality_id'][0] }}</div>
                                    </td>
                                    <td>
                                        <input style="width: 100%" type="text" v-model="details.remarks" class="form-control form-control-sm m-input" placeholder="">
                                    </td>
                                    <td>
                                        <a @click="removeItem(index)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
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
                <div class="form-group m-form__group row" style="display: none">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Hospitals</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Hospitals Name <span class="requiredField">*</span></th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Day</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(hospital_details, index) in form.hospital_details">
                                    <th scope="row">
                                        <a href="javascript:void(0)"  @click="addNewItemHospital" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Add More">
                                            <i class="la la-plus"></i>
                                        </a>
                                    </th>
                                    <td>
                                        <select style="width: 100%" class="form-control m-select2 select2 select-hospital" v-bind:data-index="index" v-model="hospital_details.hospital_id">
                                            <option v-for="(value,index) in hospital_lists" :value="value.id"> {{value.hospital_name}}</option>
                                        </select>
                                        <div class="requiredField" v-if="errors['hospital_details.'+index+'.hospital_id']">{{ errors['hospital_details.'+index+'.hospital_id'][0] }}</div>
                                    </td>
                                    <td>

                                        <input style="width: 100%" id="f_time" type="text" v-model="hospital_details.f_time" class="form-control form-control-sm m-input" placeholder="">
                                        <div class="requiredField" v-if="errors['hospital_details.'+index+'.f_time']">{{ errors['hospital_details.'+index+'.f_time'][0] }}</div>
                                    </td>
                                    <td>
                                        <input style="width: 100%" type="text" id="s_time" v-model="hospital_details.s_time" class="form-control form-control-sm m-input" placeholder="">
                                        <div class="requiredField" v-if="errors['hospital_details.'+index+'.s_time']">{{ errors['hospital_details.'+index+'.s_time'][0] }}</div>
                                    </td>
                                    <td>
                                        <select style="width: 100%" class="form-control m-select2 select2 select-day" v-bind:data-index="index" v-model="hospital_details.day">
                                            <option value="Sat"> Sat </option>
                                            <option value="Sun"> Sun </option>
                                            <option value="Mon"> Mon </option>
                                            <option value="Wed"> Wed </option>
                                            <option value="Tue"> Tue </option>
                                            <option value="Wed"> Wed </option>
                                            <option value="Thu"> Thu </option>
                                            <option value="Fri"> Fri </option>
                                        </select>
                                        <div class="requiredField" v-if="errors['hospital_details.'+index+'.day']">{{ errors['hospital_details.'+index+'.day'][0] }}</div>
                                    </td>
                                    <td>
                                        <a @click="removeItemHospital(index)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-right"></td>
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
                            <button type="reset" class="btn btn-sm btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-success" ><i class="la la-check"></i> <span>Save and Go List</span></button>
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
    import moment from 'moment';

    export default {

        props:['degree_lists','speciality_lists','hospital_lists','day_lists'],

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
                    degree_details: [
                        {
                            degree_id: '',
                            institute: '',
                        }
                    ],
                    details: [
                        {
                            speciality_id: '',
                            remarks: '',
                        }
                    ],
                    hospital_details: [
                        {
                            hospital_id: '',
                            f_time: '',
                            s_time: '',
                            day: '',
                        }
                    ],
                },
                errors: {},
            };
        },

        methods:{

            duplicateCheck(){
                var no_index = this.form.details.length;
                var details = this.form.details;
                if (no_index > 1) {
                    for (let i = 0; i < no_index; i++) {
                        for (let j = i+1; j < no_index; j++) {
                            if(details[i].speciality_id == details[j].speciality_id) {
                                alert("Duplicate. Speciality Already Selected");
                                details[j].speciality_id = '';
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

            duplicateCheckDegree(){
                var no_index = this.form.degree_details.length;
                var details = this.form.degree_details;
                if (no_index > 1) {
                    for (let i = 0; i < no_index; i++) {
                        for (let j = i+1; j < no_index; j++) {
                            if(details[i].degree_id == details[j].degree_id) {
                                alert("Duplicate. Degree Already Selected");
                                details[j].degree_id = '';
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

            duplicateCheckHospital(){
                var no_index = this.form.hospital_details.length;
                var details = this.form.hospital_details;
                if (no_index > 1) {
                    for (let i = 0; i < no_index; i++) {
                        for (let j = i+1; j < no_index; j++) {
                            if(details[i].hospital_id == details[j].hospital_id) {
                                alert("Duplicate. Hospital Already Selected");
                                details[j].hospital_id = '';
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
                this.form.details.push({
                    speciality_id: '',
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

            addNewItemDegree(){
                this.form.degree_details.push({
                    degree_id: '',
                    institute: '',
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

            addNewItemHospital(){
                this.form.hospital_details.push({
                    hospital_id: '',
                    f_time: '',
                    s_time: '',
                    day: '',
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

            removeItem(index){
                var _this = this;
                if(_this.form.details.length > 1){
                    _this.form.details.splice(index, 1);
                }
            },

            removeItemDegree(index){
                var _this = this;
                if(_this.form.degree_details.length > 1){
                    _this.form.degree_details.splice(index, 1);
                }
            },

            removeItemHospital(index){
                var _this = this;
                if(_this.form.hospital_details.length > 1){
                    _this.form.hospital_details.splice(index, 1);
                }
            },

            store:function(){
                var _this = this;
                axios.post(base_url+'doctors_profile', this.form).then( (response) => {
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
            $('#addComponent').on('change', '.select-product', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.details[dataIndex].speciality_id = selectedItem.val();

                _this.duplicateCheck();
            });

            $('#addComponent').on('change', '.select-degree', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.degree_details[dataIndex].degree_id = selectedItem.val();

                _this.duplicateCheckDegree();
            });

            $('#addComponent').on('change', '.select-hospital', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.hospital_details[dataIndex].hospital_id = selectedItem.val();

                _this.duplicateCheckHospital();
            });

            $('#addComponent').on('change', '.select-day', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.hospital_details[dataIndex].day = selectedItem.val();

                _this.duplicateCheckDay();
            });

            $('#addComponent').on('change', '.select-gender', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.gender = selectedItem.val();
            });

            /*$(document).on("focus", "#f_time", function () {
                $(this).timepicker({
                    format: 'LT',
                    scrollDefault: 'now',
                }).on('click change', function () {
                    var timeField = $('#f_time').val();
                    _this.form.f_time = timeField;
                })
            });

            $(document).on("focus", "#s_time", function () {
                $(this).timepicker({
                    format: 'LT',
                    scrollDefault: 'now',
                }).on('click change', function () {
                    var timeField = $('#s_time').val();
                    _this.form.s_time = timeField;
                })
            });*/

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

        created() {
            var _this = this;
        }

    }
</script>
