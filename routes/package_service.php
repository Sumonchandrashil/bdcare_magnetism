<?php

Route::group(['middleware' => ['preventbackbutton','auth']], function(){

    Route::resource('services','PackageService\ServiceController');
    Route::resource('book-package','PackageService\BookPackageController');
    Route::resource('book-service','PackageService\BookServiceController');
    Route::resource('referral-hospital','PackageService\ReferralController');
    Route::resource('help-center','PackageService\HelpCenterController');

});

Route::get('getForeignHospitals', 'FrontEnd\FrontEndController@getForeignHospitals');
