const mix = require('laravel-mix');

mix.js('resources/js/bdcare/setup/area/area.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/city/city.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/degree/degree.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/medicine/medicine.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/disease/disease.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/facility/facility.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/speciality/speciality.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/hospital/hospital.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/setup/health_package/health_package.js', 'public/js/bdcare/setup')
    .js('resources/js/bdcare/doctors_profile/doctors_profile.js', 'public/js/bdcare')
    .js('resources/js/bdcare/patient_profile/patient_profile.js', 'public/js/bdcare')
    .js('resources/js/bdcare/patient_appointment/patient_appointment.js', 'public/js/bdcare')
    .js('resources/js/bdcare/patient_medication/patient_medication.js', 'public/js/bdcare')
    .js('resources/js/bdcare/patient_health/patient_health.js', 'public/js/bdcare')
    .js('resources/js/bdcare/appointment_booked/appointment_booked.js', 'public/js/bdcare')
    .js('resources/js/bdcare/video_calling/video_calling.js', 'public/js/bdcare');






