<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'subject';
    protected $fillable = ['id',    'title',    'body',    'path',    'type',   'activities_id', 'created_at',    'updated_at'];
    public function activitie()
    {
        return $this->belongsTo(Activities::class);
    }
}
