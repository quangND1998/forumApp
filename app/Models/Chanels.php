<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chanels extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'chanels';
    protected $fillable = ['id',    'title',  'description',  'slug',    'color',    'path',    'created_at',    'updated_at'];
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'chanel_id');
    }

    public function lastConversation()
    {
        return $this->hasOne(Conversation::class,'chanel_id')->latest();
    }
}
