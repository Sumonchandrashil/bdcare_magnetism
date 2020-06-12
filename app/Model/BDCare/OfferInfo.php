<?php

namespace App\Model\BDCare;

use Illuminate\Database\Eloquent\Model;

class OfferInfo extends Model
{
    protected $table = "offer_infos";

    protected $fillable = [
        'id',
        'title',
        'detail',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
