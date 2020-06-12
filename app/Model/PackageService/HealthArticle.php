<?php

namespace App\Model\PackageService;

use App\Model\BDCare\DoctorsData;
use App\Model\BlogComment;
use Illuminate\Database\Eloquent\Model;

class HealthArticle extends Model
{
    /*use SoftDeletes;
    protected $softDelet = true;
    protected $dates = ['deleted_at'];*/

    public $table = 'health_articles';

    protected $fillable = [
        'id',
        'title',
        'description',
        'image',
        'date',
        'like',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by'
    ];

    function get_doctor()
    {
        return $this->belongsTo(DoctorsData::class, 'created_by', 'created_by')->with('get_speciality', 'get_degree');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class)->whereNull('parent_id');
    }


}
