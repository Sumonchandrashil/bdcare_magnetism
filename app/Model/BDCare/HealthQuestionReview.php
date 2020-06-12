<?php

namespace App\Model\BDCare;

use App\Model\PackageService\HelpCenter;
use App\User;
use Illuminate\Database\Eloquent\Model;

class HealthQuestionReview extends Model
{

    protected $table = "health_question_reviews";

    protected $fillable = [
        'id',
        'comment',
        'question_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    public function get_patient()
    {
        return $this->belongsTo(PatientData::class, 'created_by', 'created_by');
    }

    public function get_question()
    {
        return $this->belongsTo(HelpCenter::class, 'question_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->select('id', 'user_photo', 'user_name');
    }
}
