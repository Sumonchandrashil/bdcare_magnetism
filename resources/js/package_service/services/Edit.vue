<template>
    <div>
        <!--begin::Form-->
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" id="editComponent" class="m-form m-form--fit m-form--label-align-right" >
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <label for="name" class="col-lg-2 col-form-label">Name <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input type="text" id="name" v-model="form.name" class="form-control form-control-sm m-input" placeholder="Enter Name">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('name'))">{{ (errors.hasOwnProperty('name')) ? errors.name [0] :'' }}</div>
                    </div>
                    <label class="col-lg-2 col-form-label"> Date <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <input type="text" id="date" class="form-control form-control-sm m-input datepicker" v-model="form.service_date" data-dateField="service_date" placeholder="Select date from picker"  />
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                        </div>
                        <div class="requiredField" v-if="(errors.hasOwnProperty('service_date'))">{{ (errors.hasOwnProperty('service_date')) ? errors.service_date[0] :'' }}</div>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label" for="contact">Hot Line Number<span class="requiredField">*</span> </label>
                    <div class="col-lg-4">
                        <input type="text"  id="contact" v-model="form.hot_line_number" class="form-control form-control-sm m-input" placeholder="Enter Hotline Number">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('hot_line_number'))">{{ (errors.hasOwnProperty('hot_line_number')) ? errors.hot_line_number[0] :'' }}</div>
                    </div>
                    <label class="col-lg-2 col-form-label" for="terms"> Terms <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <textarea class="form-control m-input" v-model="form.terms"  id="terms" rows="2"></textarea>
                            <div class="requiredField" v-if="(errors.hasOwnProperty('terms'))">{{ (errors.hasOwnProperty('terms')) ? errors.terms[0] :'' }}</div>
                        </div>
                    </div>
                </div>

                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="details"> Details </label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.details"  id="details" rows="2"></textarea>
                    </div>

                    <label class="col-lg-2 col-form-label">Picture</label>
                    <div class="col-lg-4">
                        <div class="input-group">
                            <input type="file" class="custom-file-input m-input Image" id="image"  autocomplete="off" @change="onFileChange">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                        <div class="requiredField" v-if="(errors.hasOwnProperty('image'))">{{ (errors.hasOwnProperty('image')) ? errors.image[0] :'' }}</div>
                    </div>
                </div>

                    <div class="form-group m-form__group row">
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

        props:['editId','permissions'],
        data:function(){
            return{
                data_list:false,
                add_form:true,
                edit_form:false,
                form:{
                    name: '',
                    terms: '',
                    conditions: '',
                    details: '',
                    service_date: '',
                    hot_line_number: '',
                    simage: '',
                    status: '',
                },
                errors: {},
            };
        },

        methods:{
            edit(id) {
                var _this = this;
                axios.get(base_url+'services/'+id+'/edit')
                    .then( (response) => {
                        _this.form  = response.data.data;
                    });
            },

            update(id){
                axios.put(base_url+'services/'+id, this.form).then( (response) => {
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

            onFileChange(e) {
                //alert(e.target.files || e.dataTransfer.files);
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },

            createImage(file) {
                let reader = new FileReader();
                var _this = this;

                reader.onload = (e) => {
                    this.form.simage =e.target.result;
                };
                reader.readAsDataURL(file);
            },
        },

        mounted(){
            var _this = this;
            $(document).on("focus", ".datepicker", function () {
                $(this).datepicker({
                    format: 'dd/mm/yyyy',
                    todayHighlight: true,
                    clearBtn: true,
                    //startDate: new Date(),
                    startDate: '-2d',
                }).on('changeDate', function (ev) {

                    $(this).datepicker('hide');
                    if(ev.date == undefined){
                        _this.form.service_date = '';

                    }else {
                        _this.form.service_date = moment(ev.date).format('DD/MM/YYYY');

                    }

                });
            });

        },

        created(){
            var _this = this;
            _this.edit(_this.editId);
        }

    }
</script>
