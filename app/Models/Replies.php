<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    use HasFactory;
    protected $table = 'replies';
    protected $fillable = ['id', 'body', 'best_answer', 'body_in_markdown', 'conversation_id',    'user_id', 'created_at', 'updated_at'];
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id');
    }
}
