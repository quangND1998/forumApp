<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Conversation extends Model
{
    use HasFactory;
    protected $table = 'conversation';
    protected $fillable = ['id',    'title',  'slug',  'body', 'solved', 'is_inital', 'active',  'body_in_markdown', 'lock_comment',   'chanel_id',    'user_id',    'view',    'created_at',    'updated_at'];

    public function user()
    {
         return $this->belongsTo(User::class, 'user_id');
   
    }
    public function chanel()
    {
        return $this->belongsTo(Chanels::class, 'chanel_id');
    }
    public function all_replies()
    {
        return $this->hasMany(Replies::class, 'conversation_id');
    }

    // public function activities()
    // {
    //     return $this->hasMany(Activities::class, 'conversation_id');
    // }

    public function activities()
    {
        return $this->morphMany(Activities::class, 'activitiesable');
    }

    public function initalReplies()
    {
        return $this->all_replies()->where('is_inital', 1);
    }


    public function lastReplie()
    {
        return $this->hasOne(Replies::class)->latest();
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $model->user_id = auth()->user()->id;
        });
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
