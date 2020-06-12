<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::get('CallSmsAPI', 'Api\APIRegisterController@TwoStepVarificaion');


Route::post('register', 'Api\APIRegisterController@register');
Route::post('ask-doctor', 'Api\APIRegisterController@askDoctor');
Route::post('TwoStepVarificaionMobile', 'Api\APIRegisterController@TwoStepVarificaionMobile');
Route::post('login', 'Api\APILoginController@login');
Route::post('forget_pass', 'Api\APILoginController@forget_pass');

Route::post('check_token', 'Api\APILoginController@check_token');

Route::group(['middleware' => 'jwt.auth'], function () {


    Route::post('logout', 'Api\APILoginController@logout');

    Route::get('questionList', 'Api\APIListController@questionList');
    Route::get('offerList', 'Api\APIListController@offerList');

    Route::get('degree', 'Api\APIListController@degreeList');
    Route::get('speciality', 'Api\APIListController@specialityList');
    Route::get('doctor_data', 'Api\APIListController@doctor_data');
    Route::post('doctor_single_data', 'Api\APIListController@doctor_single_data');
    Route::get('patient_data', 'Api\APIListController@patient_data');
    Route::get('hospitalList', 'Api\APIListController@hospitalList');
    Route::get('diseaseList', 'Api\APIListController@diseaseList');
    Route::get('facilityList', 'Api\APIListController@facilityList');
    Route::get('HealthPackage', 'Api\APIListController@HealthPackage');
    Route::get('serviceList', 'Api\APIListController@serviceList');

    Route::get('DoctorHospitalList', 'Api\APIListController@DoctorHospitalList');
    Route::post('DoctorDegreeList', 'Api\APIListController@DoctorDegreeList');
    Route::get('DoctorSpecialityList', 'Api\APIListController@DoctorSpecialityList');
    Route::get('HospitalFacilityList', 'Api\APIListController@HospitalFacilityList');

    Route::post('PatientDataInsert', 'Api\APIPatientController@PatientDataInsert');

    Route::post('DocDataUsingSpeciality', 'Api\APIDoctorController@DocDataUsingSpeciality');

    Route::post('insert_off_days', 'Api\APIDoctorController@insert_off_days');
    Route::post('update_off_days', 'Api\APIDoctorController@update_off_days');
    Route::post('editDoctorOffDays', 'Api\APIDoctorController@editDoctorOffDays');

    Route::get('cityList', 'Api\APIListController@cityList');
    Route::get('medicineList', 'Api\APIListController@medicineList');
    Route::post('medicineListNew', 'Api\APIListController@medicineListNew');
    Route::post('AreaList', 'Api\APIListController@AreaList');

    Route::post('PassReset', 'Api\APILoginController@PassReset');

    Route::post('PatientMedicationInsert', 'Api\APIPatientController@PatientMedicationInsert');
    Route::post('PatientWiseMedication', 'Api\APIPatientController@PatientWiseMedication');
    Route::post('PatientWiseMedicationDelete', 'Api\APIPatientController@PatientWiseMedicationDelete');
    Route::post('PatientWiseMedicationUpdate', 'Api\APIPatientController@PatientWiseMedicationUpdate');

    Route::get('PatientMedicalRecords', 'Api\APIPatientController@PatientMedicalRecords');
    Route::post('PatientMedicalRecordInsert', 'Api\APIPatientController@PatientMedicalRecordInsert');
    Route::post('PatientWiseMedicalRecord', 'Api\APIPatientController@PatientWiseMedicalRecord');
    Route::post('PatientWiseMedicalRecordDelete', 'Api\APIPatientController@PatientWiseMedicalRecordDelete');
    Route::post('PatientWiseMedicalRecordUpdate', 'Api\APIPatientController@PatientWiseMedicalRecordUpdate');

    Route::any('DoctorInformation', 'Api\APIDoctorController@DoctorInformation');
    Route::post('DoctorData', 'Api\APIDoctorController@DoctorData');

    Route::any('DoctorDoc', 'Api\APIDoctorController@DoctorDoc');

    Route::post('DoctorDegreeAdd', 'Api\APIDoctorController@DoctorDegreeAdd');
    Route::post('DoctorDegreeEdit', 'Api\APIDoctorController@DoctorDegreeEdit');
    Route::post('DoctorWiseDegree', 'Api\APIDoctorController@DoctorWiseDegree');
    Route::post('DoctorDegreeDelete', 'Api\APIDoctorController@DoctorDegreeDelete');

    Route::post('DoctorSpecialityAdd', 'Api\APIDoctorController@DoctorSpecialityAdd');
    Route::post('DoctorSpecialityEdit', 'Api\APIDoctorController@DoctorSpecialityEdit');
    Route::post('DoctorWiseSpeciality', 'Api\APIDoctorController@DoctorWiseSpeciality');
    Route::post('DoctorSpecialityDelete', 'Api\APIDoctorController@DoctorSpecialityDelete');

    Route::post('DoctorHospitalAdd', 'Api\APIDoctorController@DoctorHospitalAdd');
    Route::post('DoctorHospitalEdit', 'Api\APIDoctorController@DoctorHospitalEdit');
    Route::post('DoctorWiseHospital', 'Api\APIDoctorController@DoctorWiseHospital');
    Route::post('DoctorWiseClinic', 'Api\APIDoctorController@DoctorWiseClinic');
    Route::post('DoctorHospitalDelete', 'Api\APIDoctorController@DoctorHospitalDelete');

    Route::post('SinglePatientData', 'Api\APIPatientController@SinglePatientData');
    Route::post('SinglePatientDataById', 'Api\APIPatientController@SinglePatientDataById');

    Route::post('AppointmentBooking', 'Api\APIPatientController@AppointmentBooking');
    Route::post('AppointmentData', 'Api\APIPatientController@AppointmentData');
    Route::post('AppointmentDataEdit', 'Api\APIPatientController@AppointmentDataEdit');
    Route::post('UpdateAppointmentData', 'Api\APIPatientController@UpdateAppointmentData');

    Route::post('HospitalListByCityArea', 'Api\APIListController@HospitalListByCityArea');

    Route::post('DoctorListByHospital', 'Api\APIListController@DoctorListByHospital');
    Route::post('DayListByDocHospital', 'Api\APIListController@DayListByDocHospital');
    Route::post('ScheduleListByDocHospitalDay', 'Api\APIListController@ScheduleListByDocHospitalDay');
    Route::post('ScheduleListByDocClinicDate', 'Api\APIListController@ScheduleListByDocClinicDate');

    Route::post('PatientAppointmentDelete', 'Api\APIPatientController@PatientAppointmentDelete');

    Route::post('ClinicList', 'Api\APIDoctorController@ClinicList');
    Route::post('ClinicAdd', 'Api\APIDoctorController@ClinicAdd');
    Route::post('ClinicEdit', 'Api\APIDoctorController@ClinicEdit');
    Route::post('ClinicDelete', 'Api\APIDoctorController@ClinicDelete');

    Route::post('ConfirmBooking', 'Api\APIDoctorController@ConfirmBooking');
    Route::post('PrescriptionAdd', 'Api\APIDoctorController@PrescriptionAdd');
    Route::post('EditPrescriptionData', 'Api\APIDoctorController@EditPrescriptionData');
    Route::post('UpdatePrescriptionData', 'Api\APIDoctorController@UpdatePrescriptionData');
    Route::post('ViewPrescriptionData', 'Api\APIDoctorController@ViewPrescriptionData');

    Route::post('ViewPrescriptionDataFromPatient', 'Api\APIPatientController@ViewPrescriptionDataFromPatient');


    Route::get('HealthArticleList', 'Api\APIDoctorController@HealthArticleList');
    Route::post('HealthArticleListDocWise', 'Api\APIDoctorController@HealthArticleListDocWise');
    Route::post('HealthArticleAdd', 'Api\APIDoctorController@HealthArticleAdd');
    Route::post('HealthArticleEdit', 'Api\APIDoctorController@HealthArticleEdit');
    Route::post('HealthArticleDelete', 'Api\APIDoctorController@HealthArticleDelete');

    Route::post('AddHospitalNew', 'Api\APIDoctorController@HospitalNew');
    Route::post('EditHospitalNew', 'Api\APIDoctorController@HospitalEditNew');
    Route::post('DoctorWiseHospitalNew', 'Api\APIDoctorController@DoctorWiseHospitalNew');

    Route::post('AddClinicNew', 'Api\APIDoctorController@AddClinicNew');
    Route::post('EditClinicNew', 'Api\APIDoctorController@EditClinicNew');
    Route::post('DoctorWiseClinicNew', 'Api\APIDoctorController@DoctorWiseClinicNew');
    Route::post('PackageOrderList', 'Api\APIPatientController@OrderList');
    Route::post('ServiceOrderList', 'Api\APIPatientController@ServiceList');

    Route::post('CommentList-HealthArticle', 'Api\APIPatientController@CommentList');
    Route::post('AddComment-HealthArticle', 'Api\APIPatientController@AddComment');

    Route::post('Rate-Prescription', 'Api\APIPatientController@AddRating');
    Route::post('Rate-HealthQuestion', 'Api\APIPatientController@AddRatingToHealthQuestion');


    Route::post('AddComment-Prescription', 'Api\APIPatientController@AddCommentPrescription');
    Route::post('GetPrescriptionCommentList', 'Api\APIDoctorController@GetPrescriptionCommentList');

    Route::post('ask-doc-comment', 'Api\APIDoctorController@ask_doc_comment');
    Route::post('ask_doc_comment_list', 'Api\APIDoctorController@ask_doc_comment_list');

    Route::post('patientCommentList', 'Api\APIPatientController@patientCommentList');


    Route::post('notification_list', 'Api\APIListController@notification_list');
    Route::post('token_update', 'Api\APILoginController@token_update');

    Route::post('DocDateDataUsingHospital', 'Api\APIPatientController@DocDateDataUsingHospital');
    Route::post('DocDateDataUsingClinic', 'Api\APIPatientController@DocDateDataUsingClinic');

    Route::post('UpdateNotificationStatus', 'Api\APIListController@update_notification_status');

    Route::post('view_prescription_pdf', 'Backend\PatientController@view_prescription_pdf');

    Route::post('HospitalDetails', 'Api\APIListController@HospitalDetails');

    Route::get('doc_online_list', 'Api\APIDoctorController@doc_online_list');
    Route::post('change_online_status', 'Api\APIDoctorController@change_online_status');

    Route::post('referral_data', 'Api\APIPatientController@referral_data');

    Route::post('reportDoctor', 'Api\APIDoctorController@reportDoctor');
    Route::post('reportPatient', 'Api\APIPatientController@reportPatient');

    Route::post('package_booked', 'Api\APIListController@package_booked');
    Route::post('package_delete', 'Api\APIListController@package_delete');
    Route::post('service_booked', 'Api\APIListController@service_booked');
    Route::post('service_delete', 'Api\APIListController@service_delete');

    Route::post('get_doctor_about', 'Api\APIDoctorController@get_doctor_about');
});

Route::get('foreignHospitals', 'Api\APIPatientController@foreignHospitals');

Route::get('referral_country', 'Api\APIPatientController@referral_country');
Route::get('referral_hospital', 'Api\APIPatientController@referral_hospital');

Route::post('push_notification', 'Api\APIListController@push_notification');
Route::post('HelpCenterDataInsert', 'Api\APIListController@HelpCenterDataInsert');
Route::get('/noti', 'Api\APIListController@Noti');//Final


//Twilio Video Calling
Route::group(['prefix' => 'v1'], function () {
    Route::post('/webhook/twilio/video', 'Api\V1\WebhookTwilioController@videoRespond');
});

Route::group(['prefix' => 'v1', 'middleware' => 'jwt.auth'], function () {
    Route::post('/room/create', 'Api\V1\TwilioController@createRoom'); // expected doctor_id
    Route::post('/room/join', 'Api\V1\TwilioController@joinRoom'); // expected doctor_id
    Route::post('/room/reject', 'Api\V1\TwilioController@rejectRoom'); // expected room_name, caller_user_id
});



