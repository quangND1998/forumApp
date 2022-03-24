<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{
    use HasFactory;
    protected $table = 'activities';
    protected $fillable = ['id',    'date',    'heading',    'icon',    'pointsEarned',  'type', 'user_id', 'created_at',    'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function subject()
    {
        return $this->hasOne(Subject::class, 'scene_id');
    }
}
