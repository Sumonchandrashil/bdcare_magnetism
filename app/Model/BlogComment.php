<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    public $timestamps = false;
    public $table = "blog_comments";
    protected $fillable = [
        'id',
        'comment',
        'blog_id',
        'parent_id',
        'created_by',
        'reply'
    ];
    protected $with = 'replies';

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->select('id', 'user_photo', 'user_name');
    }

}
