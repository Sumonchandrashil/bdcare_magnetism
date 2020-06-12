<template>
    <div>
        <!--begin::Form-->
        <form method="POST" enctype="multipart/form-data" v-on:submit.prevent="update(form.id)" id="editComponent" class="m-form m-form--fit m-form--label-align-right" >

            <div class="m-portlet__body">
                <div class="form-group m-form__group row">

                <label class="col-lg-2 col-form-label">Cover Image</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input type="file" class="custom-file-input m-input Image" id="cover_image"  autocomplete="off" @change="uploadCoverImage">
                        <label class="custom-file-label" for="cover_image">Choose file</label>
                    </div>
                    <img v-if="form.old_cover_image" :src="getImgUrl('public/uploads/hospital_cover_photo/thumb/', form.old_cover_image)" class="imageSize mt5" width="70px">
                </div>

                <label class="col-lg-2 col-form-label">Logo</label>
                <div class="col-lg-4">
                    <div class="input-group">
                        <input type="file" class="custom-file-input m-input Image" id="logo"  autocomplete="off" @change="uploadLogoImage">
                        <label class="custom-file-label" for="logo">Choose file</label>
                    </div>
                    <img v-if="form.old_logo" :src="getImgUrl('public/uploads/hospital_logo/thumb/', form.old_logo)" class="imageSize mt5" width="70px">
                </div>
                </div>
                <div class="form-group m-form__group row">
                    <label for="Hospital" class="col-lg-2 col-form-label">Hospital Name <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <input type="text" id="Hospital" v-model="form.hospital_name" class="form-control form-control-sm m-input" placeholder="Enter Hospital Name" autocomplete="off">
                        <div class="requiredField" v-if="(errors.hasOwnProperty('hospital_name'))">{{ (errors.hasOwnProperty('hospital_name')) ? errors.hospital_name[0] :'' }}</div>
                    </div>
                    <label for="area" class="col-lg-2 col-form-label">Area<span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <select id="area" class="form-control m-select2 select2  select-area"  data-index="area_name" v-model="form.area_name" >
                            <option v-for="(svalue,sindex) in area_lists" :value="svalue.id" > {{svalue.area_name}}</option>
                        </select>
                        <div class="requiredField" v-if="errors['area_name']">{{ errors['area_name'][0] }}</div>
                    </div>

                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-2 col-form-label" for="address">Address </label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.address"  id="address" rows="2"></textarea>
                    </div>
                    <label class="col-lg-2 col-form-label" for="city">City <span class="requiredField">*</span></label>
                    <div class="col-lg-4">
                        <div class="input-group date">
                            <select id="city" class="form-control m-select2 select2  select-city"  data-index="city_name" v-model="form.city_name" >
                                <option v-for="(svalue,sindex) in city_lists" :value="svalue.id" > {{svalue.city_name}}</option>
                            </select>
                            <div class="requiredField" v-if="errors['city_name']">{{ errors['city_name'][0] }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group m-form__group row">

                    <label class="col-lg-2 col-form-label" for="description">About Hospital </label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.description"  id="description" rows="2" placeholder="Details About Hospital"></textarea>
                    </div>

                    <label for="emergency_details" class="col-lg-2 col-form-label">Emergency Details </label>
                    <div class="col-lg-4">
                        <textarea type="text" id="emergency_details" v-model="form.emergency_details" class="form-control form-control-sm m-input" placeholder="Emergency Details"></textarea>
                    </div>

                </div>

                <div class="form-group m-form__group row">

                    <label for="type" class="col-lg-2 col-form-label"> Type of Hospital </label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" id="type" v-model="form.type" class="form-control form-control-sm m-input" placeholder="Hospital Type">
                    </div>

                    <label for="excellence_center" class="col-lg-2 col-form-label">Center of Excellence </label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" id="excellence_center" v-model="form.excellence_center" class="form-control form-control-sm m-input" placeholder="Enter Centers of Excellence">
                    </div>

                </div>

                <div class="form-group m-form__group row">

                    <label for="help_line" class="col-lg-2 col-form-label">Help Line </label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" id="help_line" v-model="form.help_line" class="form-control form-control-sm m-input" placeholder="Enter Contact Number">
                    </div>

                    <label for="web_address" class="col-lg-2 col-form-label">Web Link </label>
                    <div class="col-lg-4">
                        <input autocomplete="off" type="text" id="web_address" v-model="form.web_address" class="form-control form-control-sm m-input" placeholder="Website Address">
                    </div>

                </div>

                <div class="form-group m-form__group row">
                    <div class="col-lg-1"></div>

                    <div class="col-lg-5">
                        <div class="input-group">
                            <label>Gallery Files</label>
                            <input id="upload-file" type="file" multiple class="form-control" @change="uploadGalleryFiles">
                        </div>

                        <!-- gallery table -->
                        <div class ="table-responsive mt5">
                            <table class="table table-sm m-table table-bordered table-striped text-center">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th>SL.</th>
                                    <th>Gallery Image</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(gallery_img, index) in form.old_gallery_files">
                                    <td>{{++index}}</td>
                                    <td>
                                        <img :src="getImgUrl('public/uploads/hospital_gallery/thumb/', gallery_img.picture)" class="imageSize" width="120px">
                                    </td>
                                    <td>
                                        <a @click="removeImageItem(--index,gallery_img.id)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- //gallery table -->

                    </div>

                    <label class="col-lg-2 col-form-label" for="motto">Motto </label>
                    <div class="col-lg-4">
                        <textarea class="form-control m-input" v-model="form.motto"  id="motto" rows="2" placeholder="Hospital Motto"></textarea>
                    </div>                    
                </div>

                <br>
                <!--begin::Portlet-->
                <div class="form-group m-form__group row">
                    <div class="m-section__content col-lg-12">
                        <div class ="table-responsive">
                            <table class="table table-sm m-table table-bordered borderless">
                                <thead class="thead-inverse" >
                                <tr>
                                    <th></th>
                                    <th>Facility Name <span class="requiredField">*</span></th>
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
                                        <select class="form-control m-select2 select2 select-facility" v-bind:data-index="index" v-model="details.facility_id">
                                            <option v-for="(value,index) in product_lists" :value="value.id"> {{value.facility_name}}</option>
                                        </select>
                                        <div class="requiredField" v-if="errors['details.'+index+'.facility_id']">{{ errors['details.'+index+'.facility_id'][0] }}</div>
                                    </td>
                                    <td>
                                        <input type="text" v-model="details.remarks" class="form-control form-control-sm m-input" placeholder="">
                                    </td>
                                    <td>
                                        <a @click="removeItem(index,details.id)" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--pill m-btn--air" data-offset="-20px -20px" data-toggle="m-tooltip" data-placement="top" title="Delete"><i class="la la-trash-o"></i></a>
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
    import { EventBus } from '../../../vue-assets';

    export default {

        props:['product_lists','editId','permissions','area_lists','city_lists'],

        data:function(){
            return{
                data_list:false,
                add_form:true,
                edit_form:false,

                form:{
                    hospital_name: '',
                    area_name: '',
                    city_lists: '',
                    description: '',
                    motto: '',
                    old_cover_image: '',
                    cover_image: '',
                    old_logo: '',
                    logo: '',
                    help_line: '',
                    type: '',
                    excellence_center: '',
                    emergency_details: '',
                    web_address: '',
                    gallery_files: [],
                    details: [
                        {
                            facility_id: '',
                            remarks: '',
                        }
                    ],
                    old_gallery_files: [],                    
                    gallery_files_deleteID: [],                    
                },
                errors: {},
            };
        },

        methods:{

            getImgUrl(path,file_name){
                if (file_name) {
                    return base_url+path+file_name;
                }
                return;
            },

            duplicateCheck(){
                var no_index = this.form.details.length;
                var details = this.form.details;
                if (no_index > 1) {
                    for (let i = 0; i < no_index; i++) {
                        for (let j = i+1; j < no_index; j++) {
                            if(details[i].facility_id == details[j].facility_id) {
                                alert("Duplicate. Facility Already Selected");
                                details[j].facility_id = '';
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
                    facility_id: '',
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
                if(_this.form.details.length > 1){
                    _this.form.details.splice(index, 1);
                   if (deletedId) {
                        _this.form.deleteID.push(deletedId);
                    }
                    // _this.totalQtyAndPrice();
                }
            },

            removeImageItem(index,deletedId){
                var _this = this;
                if(_this.form.old_gallery_files.length > 1){
                    _this.form.old_gallery_files.splice(index, 1);
                   if (deletedId) {
                        _this.form.gallery_files_deleteID.push(deletedId);
                    }
                }
            },

            edit(id) {
                var _this = this;
                axios.get(base_url+'setup_hospital/'+id+'/edit')
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

                axios.put(base_url+'setup_hospital/'+id, this.form).then( (response) => {
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

            uploadCoverImage(e) {
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
                    this.form.cover_image =e.target.result;
                };
                reader.readAsDataURL(file);
            },

            uploadLogoImage(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createLogo(files[0]);
            },

            createLogo(file) {
                let reader = new FileReader();
                var _this = this;

                reader.onload = (e) => {
                    this.form.logo =e.target.result;
                };
                reader.readAsDataURL(file);
            },

            uploadGalleryFiles(e){

                let selectedFiles=e.target.files;

                if(!selectedFiles.length){
                    return false;
                }
                
                var _this = this;
                for(let i=0; i<selectedFiles.length; i++){

                    let reader = new FileReader();
                    reader.onload = (e) => {
                        _this.form.gallery_files[i] =e.target.result;
                    };
                    reader.readAsDataURL(selectedFiles[i]);                    
                }

            },            
        },

        mounted(){

            var _this = this;

            $('#editComponent').on('change', '.select-facility', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.details[dataIndex].facility_id = selectedItem.val();

                _this.duplicateCheck();
            });

            $('#editComponent').on('change', '.select-area', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');
                _this.form.area_name = selectedItem.val();
            });

            $('#editComponent').on('change', '.select-city', function (e) {
                var selectedItem = $(this),
                    curerntVal = !!selectedItem.val(),
                    dataIndex = $(e.currentTarget).attr('data-index');

                _this.form.city_name = selectedItem.val();
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
