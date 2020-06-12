<?php

Auth::routes();
/*Route::get('404', ['as' => '404'], function () {
    return View::make("404");
});*/

Route::get('myUrl', 'PushNotificationController@url')->name('myUrl');
Route::get('aNotice', 'PushNotificationController@notice')->name('aNotice');
Route::get('fcmNotice', 'PushNotificationController@fcmNotice')->name('fcmNotice'); //Testing for video call
Route::get('fcmPushNotice', 'PushNotificationController@fcmPushNotice')->name('fcmPushNotice');

Route::get('/getShedule', 'FrontEnd\FrontEndController@getShedule')->name('getShedule');
Route::get('/getSheduleClinic', 'FrontEnd\FrontEndController@getSheduleClinic')->name('getSheduleClinic');
Route::get('/', 'FrontEnd\FrontEndController@index');
Route::get('admin-login', 'Auth\LoginController@index')->name('admin-login');
Route::post('login', 'Auth\LoginController@Auth');
Route::post('signup', 'Auth\RegisterController@signup');
Route::get('contact-us', 'FrontEnd\FrontEndController@contact_us');
Route::get('about-us', 'FrontEnd\FrontEndController@about_us');
Route::get('ask-doctor', 'FrontEnd\FrontEndController@ask_docor');
Route::get('terms-condition', 'FrontEnd\FrontEndController@terms_condition');
Route::get('privacy-policy', 'FrontEnd\FrontEndController@privacy_policy');
Route::get('package_booking/{id}', 'FrontEnd\FrontEndController@package_booking');

//Route::get('language_switcher/{id}', 'FrontEnd\FrontEndController@language_switcher');
Route::get('language_switcher/{lang}', function ($lang){
    session()->put('language',$lang);
    return redirect()->back();
});

Route::get('package_details/{id}', 'FrontEnd\FrontEndController@package_details');
Route::get('foreign-hospitals', 'FrontEnd\FrontEndController@foreignHospitals');
Route::get('online-consult', 'FrontEnd\FrontEndController@onlineConsult');
Route::get('patient-referral', 'FrontEnd\FrontEndController@patientReferral');
Route::post('referral_data', 'FrontEnd\FrontEndController@referral_data');

Route::post('submit_package', 'FrontEnd\FrontEndController@submit_package');
Route::get('book-appointment', 'FrontEnd\FrontEndController@book_appointment');
Route::get('blog', 'FrontEnd\FrontEndController@blogs');
Route::get('blog_single/{id}', 'FrontEnd\FrontEndController@blog_single');
Route::get('blog-filtering', 'FrontEnd\FrontEndController@blogFiltering')->name('blog-filtering');
Route::post('blog-comment', 'FrontEnd\FrontEndController@addBlogComment');
Route::post('reply-blog-comment', 'FrontEnd\FrontEndController@replyBlogComment');
Route::get('blog-comments-list', 'FrontEnd\FrontEndController@getBlogComment');


Route::any('otp_login', 'FrontEnd\FrontEndController@otp_login');
Route::any('forget_pass', 'FrontEnd\FrontEndController@forget_pass');
Route::post('forget-pass', 'FrontEnd\FrontEndController@password_forgeting');

Route::post('search-doc-for-appointment', 'FrontEnd\FrontEndController@search_doc_for_appointment');
Route::get('search-data', 'FrontEnd\FrontEndController@search_appointment_data');
Route::get('search-data-doctor-usingid/{id}', 'FrontEnd\FrontEndController@searchDataDoctorUsingId');
Route::get('filter-doctor-data/{id}/{id1}/{id2}', 'FrontEnd\FrontEndController@FilterDoctorDataForAppointment');
Route::get('app-booking/{id}/{id1}/{id2}/{id3}/{id4}/{id5}/{id6}', 'FrontEnd\FrontEndController@app_booking');
Route::get('clinic-app-booking/{id}/{id1}/{id2}/{id3}/{id4}/{id5}/{id6}', 'FrontEnd\FrontEndController@clinic_app_booking');

Route::post('ask_doctor', 'FrontEnd\FrontEndController@ask_doctor');

Route::get('get_areas', 'FrontEnd\FrontEndController@get_areas');
Route::get('get_hospital_list', 'FrontEnd\FrontEndController@get_hospital_list');

Route::get('booking/{id}', 'FrontEnd\FrontEndController@booking');
Route::get('more-packages', 'FrontEnd\FrontEndController@more_packages');
Route::get('emergency-health-service', 'FrontEnd\FrontEndController@emergency_health_service');
Route::get('hospitals-list/{id}', 'FrontEnd\FrontEndController@hospitalList');

Route::get('service_details/{id}', 'FrontEnd\FrontEndController@service_details');
//Route::get('service_details','FrontEnd\FrontEndController@patientDetailsInService');
Route::post('submit_service', 'FrontEnd\FrontEndController@submit_service');

Route::get('register', 'Auth\LoginController@register');
Route::get('otp', 'Auth\LoginController@otp');
Route::post('validatingsignup', 'Auth\LoginController@validatingsignup');

Route::group(['middleware' => ['preventbackbutton', 'auth']], function () {

    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('logout', 'Auth\LoginController@logout');

    Route::resource('user', 'UserAccessControl\UserController', ['parameters' => ['user' => 'id']]);
    Route::resource('role', 'UserAccessControl\RoleController', ['parameters' => ['role' => 'id']]);
    Route::group(['prefix' => 'user-role-permissoin'], function () {
        Route::get('/', ['as' => 'user-role-permissoin.index', 'uses' => 'UserAccessControl\PermissionController@index']);
        Route::post('/store', ['as' => 'user-role-permissoin.store', 'uses' => 'UserAccessControl\PermissionController@store']);
    });

    Route::post('user-role-permission-get_all_menus', 'UserAccessControl\PermissionController@getAllMenus');

});

Route::get('GetDocNames', 'FrontEnd\FrontEndController@GetDocNames');
Route::post('/autocomplete/fetch', 'FrontEnd\FrontEndController@GetDocNames')->name('autocomplete.fetch');

