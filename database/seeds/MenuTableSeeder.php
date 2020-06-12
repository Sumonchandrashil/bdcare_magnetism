<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time = Carbon::now();
        DB::table('acl_menus')->truncate();
        DB::table('acl_menus')->insert(
            [
                //User Section
                array('id' => 1, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Users', 'menu_url' => 'user.index', 'module_id' => '1', 'created_at' => $time),
                array('id' => 2, 'parent_id' => 1, 'action' => 1, 'menu_name' => 'Add', 'menu_url' => 'user.create', 'module_id' => '1', 'created_at' => $time),
                array('id' => 3, 'parent_id' => 1, 'action' => 1, 'menu_name' => 'Edit', 'menu_url' => 'user.edit', 'module_id' => '1', 'created_at' => $time),
                array('id' => 4, 'parent_id' => 1, 'action' => 1, 'menu_name' => 'Delete', 'menu_url' => 'user.destroy', 'module_id' => '1', 'created_at' => $time),

                //Role Section
                array('id' => 5, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Roles', 'menu_url' => 'role.index', 'module_id' => '1', 'created_at' => $time),
                array('id' => 6, 'parent_id' => 5, 'action' => 5, 'menu_name' => 'Add', 'menu_url' => 'role.create', 'module_id' => '1', 'created_at' => $time),
                array('id' => 7, 'parent_id' => 5, 'action' => 5, 'menu_name' => 'Edit', 'menu_url' => 'role.edit', 'module_id' => '1', 'created_at' => $time),
                array('id' => 8, 'parent_id' => 5, 'action' => 5, 'menu_name' => 'Delete', 'menu_url' => 'role.destroy', 'module_id' => '1', 'created_at' => $time),
                array('id' => 9, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'User Role Permission', 'menu_url' => 'user-role-permissoin.index', 'module_id' => '1', 'created_at' => $time),
                //BDCARE
                array('id' => 10, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Area', 'menu_url' => 'setup_area.create', 'module_id' => '2', 'created_at' => $time),
                array('id' => 11, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'City', 'menu_url' => 'setup_city.create', 'module_id' => '2', 'created_at' => $time),
                array('id' => 12, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Degree', 'menu_url' => 'setup_degree.create', 'module_id' => '2', 'created_at' => $time),
                array('id' => 13, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Disease', 'menu_url' => 'setup_disease.create', 'module_id' => '2', 'created_at' => $time),
                array('id' => 14, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Facility', 'menu_url' => 'setup_facilities.create', 'module_id' => '2', 'created_at' => $time),
                array('id' => 15, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Speciality', 'menu_url' => 'setup_speciality.create', 'module_id' => '2', 'created_at' => $time),

                array('id' => 19, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Hospital', 'menu_url' => 'setup_hospital.index', 'module_id' => '2', 'created_at' => $time),
                array('id' => 20, 'parent_id' => 19, 'action' => 19, 'menu_name' => 'Store', 'menu_url' => 'setup_hospital.store', 'module_id' => '2', 'created_at' => $time),
                array('id' => 21, 'parent_id' => 19, 'action' => 19, 'menu_name' => 'Edit', 'menu_url' => 'setup_hospital.edit', 'module_id' => '2', 'created_at' => $time),
                array('id' => 22, 'parent_id' => 19, 'action' => 19, 'menu_name' => 'Delete', 'menu_url' => 'setup_hospital.destroy', 'module_id' => '2', 'created_at' => $time),

                array('id' => 23, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Doctors Info', 'menu_url' => 'doctors_profile.index', 'module_id' => '3', 'created_at' => $time),
                array('id' => 24, 'parent_id' => 23, 'action' => 23, 'menu_name' => 'Store', 'menu_url' => 'doctors_profile.store', 'module_id' => '3', 'created_at' => $time),
                array('id' => 25, 'parent_id' => 23, 'action' => 23, 'menu_name' => 'Edit', 'menu_url' => 'doctors_profile.edit', 'module_id' => '3', 'created_at' => $time),
                array('id' => 26, 'parent_id' => 23, 'action' => 23, 'menu_name' => 'Delete', 'menu_url' => 'doctors_profile.destroy', 'module_id' => '3', 'created_at' => $time),

                array('id' => 27, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Patient Info', 'menu_url' => 'patient_profile.index', 'module_id' => '4', 'created_at' => $time),
                array('id' => 28, 'parent_id' => 27, 'action' => 27, 'menu_name' => 'Store', 'menu_url' => 'patient_profile.store', 'module_id' => '4', 'created_at' => $time),
                array('id' => 29, 'parent_id' => 27, 'action' => 27, 'menu_name' => 'Edit', 'menu_url' => 'patient_profile.edit', 'module_id' => '4', 'created_at' => $time),
                array('id' => 30, 'parent_id' => 27, 'action' => 27, 'menu_name' => 'Delete', 'menu_url' => 'patient_profile.destroy', 'module_id' => '4', 'created_at' => $time),

                array('id' => 31, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Health Record', 'menu_url' => 'health_record.index', 'module_id' => '4', 'created_at' => $time),
                array('id' => 32, 'parent_id' => 31, 'action' => 31, 'menu_name' => 'Store', 'menu_url' => 'health_record.store', 'module_id' => '4', 'created_at' => $time),
                array('id' => 33, 'parent_id' => 31, 'action' => 31, 'menu_name' => 'Edit', 'menu_url' => 'health_record.edit', 'module_id' => '4', 'created_at' => $time),
                array('id' => 34, 'parent_id' => 31, 'action' => 31, 'menu_name' => 'Delete', 'menu_url' => 'health_record.destroy', 'module_id' => '4', 'created_at' => $time),

                array('id' => 35, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Medication', 'menu_url' => 'medication.create', 'module_id' => '4', 'created_at' => $time),
                array('id' => 36, 'parent_id' => 35, 'action' => 35, 'menu_name' => 'Store', 'menu_url' => 'medication.store', 'module_id' => '4', 'created_at' => $time),
                array('id' => 37, 'parent_id' => 35, 'action' => 35, 'menu_name' => 'Edit', 'menu_url' => 'medication.edit', 'module_id' => '4', 'created_at' => $time),
                array('id' => 38, 'parent_id' => 35, 'action' => 35, 'menu_name' => 'Delete', 'menu_url' => 'medication.destroy', 'module_id' => '4', 'created_at' => $time),

                array('id' => 39, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Health Package', 'menu_url' => 'health_package.create', 'module_id' => '2', 'created_at' => $time),

                array('id' => 40, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Appointment Booking', 'menu_url' => 'appointment_booking.index', 'module_id' => '4', 'created_at' => $time),
                array('id' => 41, 'parent_id' => 40, 'action' => 40, 'menu_name' => 'Store', 'menu_url' => 'appointment_booking.store', 'module_id' => '4', 'created_at' => $time),
                array('id' => 42, 'parent_id' => 40, 'action' => 40, 'menu_name' => 'Edit', 'menu_url' => 'appointment_booking.edit', 'module_id' => '4', 'created_at' => $time),
                array('id' => 43, 'parent_id' => 40, 'action' => 40, 'menu_name' => 'Delete', 'menu_url' => 'appointment_booking.destroy', 'module_id' => '4', 'created_at' => $time),

                array('id' => 44, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Booked Appointment', 'menu_url' => 'appointment_booked.index', 'module_id' => '3', 'created_at' => $time),
                array('id' => 45, 'parent_id' => 44, 'action' => 44, 'menu_name' => 'Store', 'menu_url' => 'appointment_booked.store', 'module_id' => '3', 'created_at' => $time),
                array('id' => 46, 'parent_id' => 44, 'action' => 44, 'menu_name' => 'Edit', 'menu_url' => 'appointment_booked.edit', 'module_id' => '3', 'created_at' => $time),
                array('id' => 47, 'parent_id' => 44, 'action' => 44, 'menu_name' => 'Delete', 'menu_url' => 'appointment_booked.destroy', 'module_id' => '3', 'created_at' => $time),


                // Service and Static
                /*array('id'=>150,'parent_id' => 0,'action'=> NULL,'menu_name'  => 'Health Checkup Package', 'menu_url'  => 'health-checkup.index', 'module_id'  => '5','created_at' => $time),
                array('id'=>151,'parent_id' => 150,'action'=> 150,'menu_name'  => 'Store', 'menu_url'  => 'health-checkup.store', 'module_id'  => '5','created_at' => $time),
                array('id'=>152,'parent_id' => 150,'action'=> 150,'menu_name'  => 'Edit', 'menu_url'  => 'health-checkup.edit', 'module_id'  => '5','created_at' => $time),
                array('id'=>153,'parent_id' => 150,'action'=> 150,'menu_name'  => 'Delete', 'menu_url'  => 'health-checkup.destroy', 'module_id'  => '5','created_at' => $time),*/


                array('id' => 150, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Service', 'menu_url' => 'services.index', 'module_id' => '5', 'created_at' => $time),
                array('id' => 151, 'parent_id' => 150, 'action' => 150, 'menu_name' => 'Store', 'menu_url' => 'services.store', 'module_id' => '5', 'created_at' => $time),
                array('id' => 152, 'parent_id' => 150, 'action' => 150, 'menu_name' => 'Edit', 'menu_url' => 'services.edit', 'module_id' => '5', 'created_at' => $time),
                array('id' => 153, 'parent_id' => 150, 'action' => 150, 'menu_name' => 'Delete', 'menu_url' => 'services.destroy', 'module_id' => '5', 'created_at' => $time),

                array('id' => 160, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Booked Service', 'menu_url' => 'book-service.index', 'module_id' => '5', 'created_at' => $time),
                array('id' => 161, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Booked Package', 'menu_url' => 'book-packages.index', 'module_id' => '5', 'created_at' => $time),
                array('id' => 162, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Referral Hospital', 'menu_url' => 'referral-hospital.index', 'module_id' => '5', 'created_at' => $time),

                array('id' => 170, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Help Canter', 'menu_url' => 'help-center.index', 'module_id' => '5', 'created_at' => $time),
                array('id' => 171, 'parent_id' => 170, 'action' => 170, 'menu_name' => 'Store', 'menu_url' => 'help-center.store', 'module_id' => '5', 'created_at' => $time),
                array('id' => 172, 'parent_id' => 170, 'action' => 170, 'menu_name' => 'Edit', 'menu_url' => 'help-center.edit', 'module_id' => '5', 'created_at' => $time),
                array('id' => 173, 'parent_id' => 170, 'action' => 170, 'menu_name' => 'Delete', 'menu_url' => 'help-center.destroy', 'module_id' => '5', 'created_at' => $time),

                array('id' => 180, 'parent_id' => 0, 'action' => NULL, 'menu_name' => 'Video Calls', 'menu_url' => 'report-video-calls.index', 'module_id' => '6', 'created_at' => $time),
            ]
        );
    }
}
