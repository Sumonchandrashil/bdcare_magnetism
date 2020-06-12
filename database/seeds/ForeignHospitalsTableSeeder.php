<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ForeignHospitalsTableSeeder extends Seeder
{
    public function run()
    {
        $time = Carbon::now();
        DB::table('foreign_hospitals')->truncate();
        DB::table('foreign_hospitals')->insert(
            $foreign_hospitals = array(
                array(
                    "id" => 1,
                    "country_id" => 99,
                    "hospital_name" => "Medanta Hospital",
                    "address" => "Delhi",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 2,
                    "country_id" => 99,
                    "hospital_name" => "Kokilaben Hospital",
                    "address" => "Mumbai ",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 3,
                    "country_id" => 99,
                    "hospital_name" => "BLK Super Speciality Hospital",
                    "address" => "Delhi",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 4,
                    "country_id" => 99,
                    "hospital_name" => "Fortis Hospital",
                    "address" => "Bannerghata Road, Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 5,
                    "country_id" => 99,
                    "hospital_name" => "Max Super Speciality Hospital",
                    "address" => "Saket, New Delhi",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 6,
                    "country_id" => 99,
                    "hospital_name" => "Apollo Hospital",
                    "address" => "Bannerghata Road, Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 7,
                    "country_id" => 99,
                    "hospital_name" => "Fortis Malar Hospital",
                    "address" => "Chennai",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 8,
                    "country_id" => 99,
                    "hospital_name" => "Columbia Asia Referral Hospital",
                    "address" => "Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 9,
                    "country_id" => 99,
                    "hospital_name" => "Apollo Hospital",
                    "address" => "Jubilee Hills, Hyderabad, Telangana",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 10,
                    "country_id" => 99,
                    "hospital_name" => "Sri Ramchandra Medical Center",
                    "address" => "Chennai",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 11,
                    "country_id" => 99,
                    "hospital_name" => "Apollo Gleneagles Hospital",
                    "address" => "Kolkata",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 12,
                    "country_id" => 99,
                    "hospital_name" => "Aditya Birla Memorial Hospital",
                    "address" => "Pune",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 13,
                    "country_id" => 99,
                    "hospital_name" => "Fortis Memorial Research Institute",
                    "address" => "Gurgaon",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 14,
                    "country_id" => 99,
                    "hospital_name" => "Artemis Hospital",
                    "address" => "Gurgaon",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 15,
                    "country_id" => 99,
                    "hospital_name" => "Gleneagles Global Hospitals",
                    "address" => "Chennai",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 16,
                    "country_id" => 99,
                    "hospital_name" => "Fortis Escorts Heart Institute",
                    "address" => "New Delhi",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 17,
                    "country_id" => 99,
                    "hospital_name" => "Manipal Hospital",
                    "address" => "Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 18,
                    "country_id" => 99,
                    "hospital_name" => "BGS Gleneagles Global Hospitals",
                    "address" => "Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 19,
                    "country_id" => 99,
                    "hospital_name" => "Aster Medcity Kochi",
                    "address" => "",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 20,
                    "country_id" => 99,
                    "hospital_name" => "Fortis Hospital",
                    "address" => "Mulund, Mumbai",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 21,
                    "country_id" => 99,
                    "hospital_name" => "Saifee Hospital",
                    "address" => "Mumbai",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 22,
                    "country_id" => 99,
                    "hospital_name" => "Fortis Hospital",
                    "address" => "Kolkata ",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 23,
                    "country_id" => 99,
                    "hospital_name" => "Sri Ramakrishna Super specialty Hospital",
                    "address" => "Coimbatore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 24,
                    "country_id" => 99,
                    "hospital_name" => "Aster RV Hospital",
                    "address" => "Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 25,
                    "country_id" => 99,
                    "hospital_name" => "Aster CMI Hospital",
                    "address" => "Bangalore",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 26,
                    "country_id" => 133,
                    "hospital_name" => "Sunway Medical Center",
                    "address" => "Kuala Lumpur",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 27,
                    "country_id" => 133,
                    "hospital_name" => "Beacon Hospital",
                    "address" => "Selangor",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 28,
                    "country_id" => 133,
                    "hospital_name" => "Putra Medical Center",
                    "address" => "Kedah",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 29,
                    "country_id" => 133,
                    "hospital_name" => "Gleneagles Kuala Lumpur",
                    "address" => "",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 30,
                    "country_id" => 133,
                    "hospital_name" => "Prince Court Medical Center",
                    "address" => "",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 31,
                    "country_id" => 216,
                    "hospital_name" => "Bumrungrad Intl. Hospital",
                    "address" => "Bangkok",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 32,
                    "country_id" => 216,
                    "hospital_name" => "Bangkok Hospital",
                    "address" => "Bangkok",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 33,
                    "country_id" => 216,
                    "hospital_name" => "Samitivej Hospital",
                    "address" => "Bangkok",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 34,
                    "country_id" => 216,
                    "hospital_name" => "Vejthani Hospital",
                    "address" => "Bangkok",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 35,
                    "country_id" => 195,
                    "hospital_name" => "Raffles Hospitals",
                    "address" => "",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 36,
                    "country_id" => 195,
                    "hospital_name" => "Farrer Park Hospital",
                    "address" => "",
                    "status" => 1,
                    "created_at" => $time,
                ),
                array(
                    "id" => 37,
                    "country_id" => 195,
                    "hospital_name" => "Gleneagles Hospitals",
                    "address" => "",
                    "status" => 1,
                    "created_at" => $time,
                ),
            )
        );
    }
}
