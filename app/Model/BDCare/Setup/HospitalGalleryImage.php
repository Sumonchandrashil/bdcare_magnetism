<?php

namespace App\Model\BDCare\Setup;

use Illuminate\Database\Eloquent\Model;

class HospitalGalleryImage extends Model
{
    protected $table = "hospital_gallery_images";

    protected $fillable = [
        'id',
        'hospital_id',
        'picture'
    ];

    function get_hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

}
