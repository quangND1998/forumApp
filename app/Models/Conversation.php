<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;
    protected $table = 'conversation';
    protected $fillable = ['id',    'title',  'slug',  'body', 'solved', 'is_inital',   'body_in_markdown',    'chanel_id',    'user_id',    'view',    'created_at',    'updated_at'];

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

    public function initalReplies()
    {
        return $this->all_replies()->where('is_inital', 1);
    }


    public function lastReplie()
    {
        return $this->hasOne(Replies::class)->latest();
    }
}
