<template>
    <div>
        <!--begin::Form-->
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="store" id="addComponent" class="m-form m-form--fit m-form--label-align-right" >
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label" for="city">City <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <select id="city" class="form-control m-select2 select2 select-city" data-index="city" v-model="form.city">
                                <option v-for="(value,index) in city_lists" :value="value.id"> {{value.city_name}}</option>
                            </select>
                            <div class="requiredField" v-if="(errors.hasOwnProperty('city'))">{{ (errors.hasOwnProperty('city')) ? errors.city[0] :'' }}</div>
                        </div>
                    </div>
                    <label class="col-lg-2 col-form-label" for="area">Area </label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <select id="area" class="form-control m-select2 select2 select-area" data-index="area" v-model="form.area">
                                <option v-for="(value,index) in area_lists" :value="value.id"> {{value.area_name}}</option>
                            </select>
                            <div class="requiredField" v-if="(errors.hasOwnProperty('area'))">{{ (errors.hasOwnProperty('area')) ? errors.area[0] :'' }}</div>
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="hospital">Hospital <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <select id="hospital" class="form-control m-select2 select2 select-hospital_for_doc" data-index="hospital" v-model="form.hospital">
                                <option v-for="(value,index) in HospitalList" :value="value.id"> {{value.hospital_name}}</option>
                            </select>
                            <div class="requiredField" v-if="(errors.hasOwnProperty('hospital'))">{{ (errors.hasOwnProperty('hospital')) ? errors.hospital[0] :'' }}</div>
                        </div>
                    </div>
                    <label for="doctor_name" class="col-lg-2 col-form-label">Doctors Name <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <select class="form-control m-select2 select2 select-doctor" data-index="doctor" v-model="form.doctor" id="doctor_name">
                            <option v-for="(value,index) in DocList"
                                    :value="value.id"
                                    :visiting_fees="value.visiting_fees"
                                    :emergency_contact="value.emergency_contact"
                                    :email="value.email"
                                    :gender="value.gender"
                                    :address="value.address"
                                    :year_of_experience="value.year_of_experience"

                            > {{value.doctor_name}}</option>
                        </select>
                        <div class="requiredField" v-if="(errors.hasOwnProperty('doctor'))">{{ (errors.hasOwnProperty('doctor')) ? errors.doctor[0] :'' }}</div>
                    </div>

                </div>

                <div class="form-group m-form__group row">

                    <label for="Visit" class="col-lg-2 col-form-label">Visit fees<span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input disabled type="text" id="Visit" v-model="form.visiting_fees" class="form-control form-control-sm m-input" placeholder="Enter Visiting fees">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('visiting_fees'))">{{ (errors.hasOwnProperty('visiting_fees')) ? errors.visiting_fees[0] :'' }}</div>
                    </div>

                    <label for="email" class="col-lg-2 col-form-label">Email<span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input disabled type="text" id="email" v-model="form.email" class="form-control form-control-sm m-input" placeholder="Enter Email">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('email'))">{{ (errors.hasOwnProperty('email')) ? errors.email[0] :'' }}</div>
                    </div>

                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label" for="contact">Contact<span class="requiredField">*</span> </label>
                    <div class="col-lg-4">
                        <input disabled type="number" step="any" id="contact" v-model="form.contact" class="form-control form-control-sm m-input" placeholder="Enter Visit fees">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('contact'))">{{ (errors.hasOwnProperty('contact')) ? errors.contact[0] :'' }}</div>
                    </div>

                    <label class="col-lg-2 col-form-label" for="gender">Gender <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <input disabled type="text" id="gender" v-model="form.gender" class="form-control form-control-sm m-input" placeholder="Enter gender">
                            <div class="requiredField" v-if="(errors.hasOwnProperty('gender'))">{{ (errors.hasOwnProperty('gender')) ? errors.gender[0] :'' }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label" for="experience"> Experience </label>
                    <div class="col-lg-4">
                        <input disabled type="number" step="any" id="experience" v-model="form.experience" class="form-control form-control-sm m-input" placeholder="Enter year Experience">
                        <div class="requiredField" v-if="errors['experience']">{{ errors['experience'][0] }}</div>
                    </div>
                    <label class="col-lg-2 col-form-label" for="address">Address</label>
                    <div class="col-lg-4">
                        <textarea disabled class="form-control m-input" v-model="form.address"  id="address" rows="2"></textarea>
                    </div>
                    <label class="col-lg-2 col-form-label" for="summary">Summary of Booking</label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.summary"  id="summary" rows="2"></textarea>
                    </div>
                </div>
                <br><br>
                <!--begin::Portlet-->

                <div class="form-group m-form__group row">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Degrees</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th>Degree Name <span class="requiredField">*</span></th>
                                    <th>Institute</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(degree_details, index) in DegreeList">
                                    <td style="width: 50%">
                                        <span style="font-weight: bold">{{degree_details.get_degree ? degree_details.get_degree.degree_name : ''}}</span>
                                        <!--<input disabled type="text" v-model="degree_details.get_degree ? degree_details.get_degree.degree_name : ''" class="form-control form-control-sm m-input">-->
                                    </td>

                                    <td style="width: 50%">
                                        <span style="font-weight: bold">{{degree_details.institute}}</span>
                                        <!--<input disabled type="text" id="gender" v-model="degree_details.institute" class="form-control form-control-sm m-input" placeholder="Enter gender">-->
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
                        <h3 align="center">Speciality</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th>Speciality Name <span class="requiredField">*</span></th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(speciality_details, index) in SpecialityList">
                                    <td style="width: 50%">
                                        <span style="font-weight: bold">{{speciality_details.get_speciality ? speciality_details.get_speciality.speciality_name : ''}}</span>
                                        <!--<input disabled type="text" v-model="degree_details.get_degree ? degree_details.get_degree.degree_name : ''" class="form-control form-control-sm m-input">-->
                                    </td>

                                    <td style="width: 50%">
                                        <span style="font-weight: bold">{{speciality_details.remarks}}</span>
                                        <!--<input disabled type="text" id="gender" v-model="degree_details.institute" class="form-control form-control-sm m-input" placeholder="Enter gender">-->
                                    </td>

                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br><br>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="m-section__content col-lg-12">
                        <h3 align="center">Hospitals</h3>
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th>Hospitals Name <span class="requiredField">*</span></th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Day</th>
                                    <th align="center">Select Your Appointment Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(hospital_details, index) in HospiList">

                                    <td>
                                        <span>{{hospital_details.get_hospital ? hospital_details.get_hospital.hospital_name : ''}}</span>
                                    </td>
                                    <td>


                                        <span>{{ hospital_details.f_time }}</span>
                                    </td>
                                    <td>
                                        <span>{{hospital_details.s_time}}</span>
                                    </td>
                                    <td>
                                        <span>{{hospital_details.day}}</span>
                                    </td>
                                    <td>
                                        <div class="m-checkbox-list">

                                            <label class="m-checkbox m-checkbox&#45;&#45;check-bold m-checkbox&#45;&#45;state-success">

                                                <!--<div v-for="(counter,index_time) in loop_counter">
                                                    <input type="checkbox" v-if="index == index_time" id="booking" v-model="counter.book"> Book
                                                </div>-->

                                                <div v-for="(counter,index_time) in loop_counter">
                                                    <br><input class="form-control" type="checkbox" v-if="index == index_time" v-for="n in counter " v-bind:data-index="index_time" :key="n" @click="push_schedule(n);"
                                                               :day="hospital_details.day"
                                                               :f_time="hospital_details.f_time"
                                                               :hospital="hospital_details.hospital_id" >
                                                </div>

                                            </label>

                                        </div>
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

        props:['degree_lists','speciality_lists','hospital_lists','day_lists','city_lists','area_lists'],

        data:function(){
            return{

                data_list:false,
                add_form:true,
                edit_form:false,

                HospitalList: [],
                DocList: {},
                DegreeList: {},
                SpecialityList: {},
                HospiList: {},
                Hours: {},

                form:{

                    summary:'',
                    schedule: '',
                    day: '',


                },
                errors: {},
            };
        },

        methods:{

            store:function(){
                var _this = this;
                axios.post(base_url+'appointment_booking', this.form).then( (response) => {
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

            push_schedule(time_id)
            {
                var _this = this;

                _this.form.schedule= time_id;

                var day = $(this).attr('day');

                _this.form.day = day;

                alert(day);
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

            load_hospital(){

                var _this = this;
                var id= this.form.city;
                var id2= this.form.area;

                axios.get(base_url+"appointment_booking/"+id+"/"+id2+"/get-hospital").then((response) => {

                    if(response.data.length > 0){
                        this.HospitalList = response.data;

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
                    } else {
                        alert('Hospital is not found.')
                    }
                });
            },

            load_doctor(){

                var _this = this;
                var id= this.form.hospital;

                axios.get(base_url+"appointment_booking/"+id+"/get-doctor").then((response) => {

                    if(response.data.length > 0){
                        this.DocList = response.data;

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
                    } else {
                        alert('Doctor is not found.')
                    }
                });
            },

            load_doctor_data(){

                var _this = this;
                var id= this.form.doctor;

                axios.get(base_url+"appointment_booking/"+id+"/get-doctor-data").then((response) => {

                    if(response.data.status = "success"){
                       //alert(response.data.status);
                        this.DegreeList = response.data.DoctorsDegreeDetails;
                        this.SpecialityList = response.data.DoctorsSpecialityDetails;
                        this.HospiList = response.data.DoctorsHospitalDetails;
                        this.loop_counter = response.data.Hours;

                        //console.log(response.data.DoctorsHospitalDetails[0].hospital_id);

                        var count = response.data.DoctorsHospitalDetails.length;

                       /* for (var i = 0; i < count; i++)
                        {
                           var f_time = response.data.DoctorsHospitalDetails[i].f_time;
                           var s_time = response.data.DoctorsHospitalDetails[i].s_time;

                            var startTime = f_time;
                            var endTime = s_time;

                            var startDate = new Date("January 1, 1970 " + startTime);
                            var endDate = new Date("January 1, 1970 " + endTime);
                            var timeDiff = Math.abs(startDate - endDate);

                            var hh = Math.floor(timeDiff / 1000 / 60 / 60);
                            if(hh < 10) {
                                hh = '0' + hh;
                            }
                            timeDiff -= hh * 1000 * 60 * 60;
                            var mm = Math.floor(timeDiff / 1000 / 60);
                            if(mm < 10) {
                                mm = '0' + mm;
                            }
                            timeDiff -= mm * 1000 * 60;
                            var ss = Math.floor(timeDiff / 1000);
                            if(ss < 10) {
                                ss = '0' + ss;
                            }

                            var hour_diff = hh;

                            var loop_counter = (hour_diff*2) + 1;


                            this.loop_counter[i] = loop_counter;
                        }*/

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
                    } else {
                        alert('Doctor Data is not found.')
                    }
                });
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

            $('#addComponent').on('change', '.select-city', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.city = selectedItem.val();

                _this.load_hospital();
            });

            $('#addComponent').on('change', '.select-area', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.area = selectedItem.val();

                _this.load_hospital();
            });

            $('#addComponent').on('change', '.select-hospital_for_doc', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.hospital = selectedItem.val();

                _this.load_doctor();
            });

            $('#addComponent').on('change', '.select-doctor', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.doctor = selectedItem.val();

                _this.form.visiting_fees = $('option:selected', this).attr('visiting_fees');
                _this.form.contact = $('option:selected', this).attr('emergency_contact');
                _this.form.email = $('option:selected', this).attr('email');

                _this.form.gender  = $('option:selected', this).attr('gender');
                _this.form.address = $('option:selected', this).attr('address');
                _this.form.experience = $('option:selected', this).attr('year_of_experience');

                _this.load_doctor_data();
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

        created() {
            var _this = this;
        }

    }
</script>
