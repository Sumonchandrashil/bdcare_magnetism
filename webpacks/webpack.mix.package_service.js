const mix = require('laravel-mix');

mix.js('resources/js/package_service/services/services.js', 'public/js/services')
    .js('resources/js/package_service/help_center/help-center.js', 'public/js/help-center')
    .js('resources/js/package_service/book_services/book-services.js', 'public/js/book_services')
    .js('resources/js/package_service/book_packages/book-packages.js', 'public/js/book_packages')
    .js('resources/js/package_service/referral_hospital/referral-hospital.js', 'public/js/referral_hospital');






