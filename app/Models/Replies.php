<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReplytoReply;

class Replies extends Model
{
    use HasFactory;
    protected $table = 'replies';
    protected $fillable = ['id', 'body', 'best_answer', 'body_in_markdown', 'conversation_id', 'is_inital', 'replie_id',  'user_id', 'created_at', 'updated_at'];
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function replies()
    {
        return $this->hasMany(Replies::class,   'replie_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class,  'replie_user', 'replie_id', 'user_id');
    }

    public function activities()
    {
        return $this->morphMany(Activities::class, 'activitiesable');
    }

    public function user_reply()
    {
        return $this->belongsTo(User::class, 'replie_user');
    }
   
   
}
