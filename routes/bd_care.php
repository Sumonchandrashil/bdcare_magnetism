<?php

Route::group(['middleware' => ['preventbackbutton', 'auth']], function () {

    Route::resource('setup_area', 'BDCare\Setup\AreaController');
    Route::resource('setup_city', 'BDCare\Setup\CityController');
    Route::resource('setup_disease', 'BDCare\Setup\DiseaseController');
    Route::resource('setup_degree', 'BDCare\Setup\DegreeController');
    Route::resource('setup_medicine', 'BDCare\Setup\MedicineController');
    Route::resource('setup_facilities', 'BDCare\Setup\FacilitiesController');
    Route::resource('setup_speciality', 'BDCare\Setup\SpecialityController');
    Route::resource('setup_hospital', 'BDCare\Setup\HospitalController');

    Route::resource('doctors_profile', 'BDCare\DoctorsProfileController');
    Route::resource('doctors_profile-backend', 'Backend\DoctorsProfileController');
    Route::get('about', 'Backend\DoctorsProfileController@about');
    Route::post('doctors_profile/store', 'Backend\DoctorsProfileController@store');
    Route::post('prescription_data', 'Backend\DoctorsProfileController@prescription_data_insert');
    Route::post('prescription_data_update', 'Backend\DoctorsProfileController@prescription_data_update');

    Route::get('create-prescription', 'Backend\DoctorsProfileController@getCreatePrescription');


    Route::post('patient_profile/store', 'Backend\PatientController@store');
    Route::post('add_medication', 'Backend\PatientController@add_medication');
    Route::post('add_booking', 'Backend\PatientController@bookAppointment');
    //Route::resource('doctors_profile','BDCare\DoctorsProfileController');
    Route::resource('appointment_booked', 'BDCare\DoctorAppointmentBookedController');
    Route::get('appointment-booked', 'Backend\DoctorsProfileController@appointment_booked');
    Route::get('DoctorDegree', 'Backend\DoctorsProfileController@DoctorDegree');
    Route::get('DoctorSpeciality', 'Backend\DoctorsProfileController@DoctorSpeciality');

    Route::get('DoctorHospitalDetail', 'Backend\DoctorsProfileController@DoctorHospitalDetail');
    Route::get('DoctorClinicDetail', 'Backend\DoctorsProfileController@DoctorClinicDetail');
    Route::post('AddDegree', 'Backend\DoctorsProfileController@AddDegree');
    Route::post('AddSpeciality', 'Backend\DoctorsProfileController@AddSpeciality');

    Route::get('doctor-off-days', 'Backend\DoctorsProfileController@getDoctorOffDays');
    Route::get('doctor-feedback', 'Backend\DoctorsProfileController@getDoctorFeedback');
    Route::post('add-doctor-off-days', 'Backend\DoctorsProfileController@AddDoctorOffDays');
    Route::get('editDoctorOffDays', 'Backend\DoctorsProfileController@editDoctorOffDays');
    Route::post('update-doctor-off-days', 'Backend\DoctorsProfileController@UpdateDoctorOffDays');
    Route::get('delete-doctor-off-days/{id}', 'Backend\DoctorsProfileController@deleteDoctorOffDays');
    Route::get('report-patient', 'Backend\PatientController@reportPatient');
    Route::get('report-doctor', 'Backend\DoctorsProfileController@reportDoctor');
    Route::get('package-order-patient', 'Backend\PatientController@packageOrderPatient');
    Route::get('service-order-patient', 'Backend\PatientController@serviceOrderPatient');

    Route::post('AddHospitalData', 'Backend\DoctorsProfileController@AddHospitalData');
    Route::post('AddClinicData', 'Backend\DoctorsProfileController@AddClinicData');

    Route::get('add-health-article', 'Backend\DoctorsProfileController@AddHealthArticle');
    Route::post('AddHealthArticle', 'Backend\DoctorsProfileController@StoreArticle');

    Route::post('AddMedicalRecord', 'Backend\PatientController@AddMedicalRecord');
    Route::post('EditMedicalRecord', 'Backend\PatientController@EditMedicalRecord');
    Route::get('DeleteMedicalRecord/{id}', 'Backend\PatientController@DeleteMedicalRecord');

    Route::get('patient_info', 'Backend\PatientController@patient_info');
    Route::get('regular-medication', 'Backend\PatientController@regular_medication');
    Route::get('medical-records', 'Backend\PatientController@medical_records');
    Route::get('appointment-booking', 'Backend\PatientController@AppointBooking');

    Route::get('appointment-online', 'Backend\PatientController@OnlineAppointment');
    Route::get('getDocDataUsingSpeciality', 'Backend\PatientController@doc_data_using_speciality');

    Route::get('patient_booking_status_update/{id}', 'Backend\DoctorsProfileController@patient_booking_status_update');

    Route::get('UserProfile', 'Backend\PatientController@UserProfile');
    Route::post('UserProfileStore', 'Backend\PatientController@UserProfileStore');
    Route::get('view-prescription/{id}', 'Backend\PatientController@ViewPrescription');

    Route::get('getDataSpeciality', 'Backend\DoctorsProfileController@getDataSpeciality');
    Route::get('getDataHealthArticle', 'Backend\DoctorsProfileController@getDataHealthArticle');
    Route::get('getDataMedicalRecords', 'Backend\DoctorsProfileController@getDataHealthArticle');

    Route::get('getDataMedicalRecord', 'Backend\PatientController@getDataMedicalRecord');

    Route::post('EditSpeciality', 'Backend\DoctorsProfileController@EditSpeciality');
    Route::post('EditHealthArticle', 'Backend\DoctorsProfileController@EditHealthArticle');

    Route::get('getDataDegree', 'Backend\DoctorsProfileController@getDataDegree');
    Route::post('EditDegree', 'Backend\DoctorsProfileController@EditDegree');

    Route::get('getDataHospital', 'Backend\DoctorsProfileController@getDataHospital');
    Route::get('getDataClinic', 'Backend\DoctorsProfileController@getDataClinic');
    Route::post('EditHospitalData', 'Backend\DoctorsProfileController@EditHospital');
    Route::post('EditClinicData', 'Backend\DoctorsProfileController@EditClinic');

    Route::get('getData', 'Backend\DoctorsProfileController@getData');
    Route::get('getDataForEditPrescription', 'Backend\DoctorsProfileController@getDataForEditPrescription');
    Route::get('getMedication', 'Backend\PatientController@getMedication');
    Route::get('GetDocData', 'Backend\PatientController@GetDocData');
    Route::get('GetDocData2', 'Backend\PatientController@GetDocData2');
    Route::get('GetDocData3', 'Backend\PatientController@GetDocData3');
    Route::get('GetDocSchedule', 'Backend\PatientController@GetDocSchedule');
    Route::get('GetDocDay', 'Backend\PatientController@GetDocDay');

    Route::post('update_medication', 'Backend\PatientController@UpdateMedication');
    Route::get('DeleteMedication/{id}', 'Backend\PatientController@DeleteMedication');
    Route::get('DeleteAppointment/{id}', 'Backend\PatientController@DeleteAppointment');

    Route::get('DeleteDegree/{id}', 'Backend\DoctorsProfileController@DeleteDegree');
    Route::get('DeleteSpeciality/{id}', 'Backend\DoctorsProfileController@DeleteSpeciality');
    Route::get('DeleteHealthArticle/{id}', 'Backend\DoctorsProfileController@DeleteHealthArticle');

    Route::get('DeleteHospitalDetails/{id}', 'Backend\DoctorsProfileController@DeleteHospitalDetails');
    Route::get('DeleteClinicDetails/{id}', 'Backend\DoctorsProfileController@DeleteClinicDetails');


    Route::resource('patient_profile', 'BDCare\PatientProfileController');
    Route::resource('health_record', 'BDCare\PatientHealthController');
    Route::resource('medication', 'BDCare\PatientMedicationController');
    Route::resource('appointment_booking', 'BDCare\PatientAppointmentController');
    Route::resource('report-video-calls', 'BDCare\VideoCallingController');

    Route::get('appointment_booking/{id}/{id2}/get-hospital', 'BDCare\PatientAppointmentController@get_hospital', ['parameters' => ['city_id' => 'id', 'area_id' => 'id2']]);
    Route::get('appointment_booking/{id}/get-doctor', 'BDCare\PatientAppointmentController@get_doctor', ['parameters' => ['hospital_id' => 'id']]);

    Route::get('appointment_booking/{id}/get-doctor-data', 'BDCare\PatientAppointmentController@get_doctor_data', ['parameters' => ['doctor_id' => 'id']]);

    Route::resource('health_package', 'BDCare\Setup\HealthPackageController');

    Route::get('OnlineConsult', 'Backend\DoctorsProfileController@OnlineConsult');
    Route::post('ReplyOnlineConsult', 'Backend\DoctorsProfileController@ReplyOnlineConsult');

    Route::post('AddPrescriptionComment', 'Backend\PatientController@AddPrescriptionComment')->name('AddPrescriptionComment');

    Route::get('notifications', 'Backend\PatientController@notifications');
    Route::post('read-unread', 'Backend\PatientController@readUnreadUpdate')->name('read-unread');


});
