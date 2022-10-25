<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';
    protected $fillable = ['id', 'name', 'video', 'videoable_id','videoable_type', 'created_at', 'updated_at'];
    public function videoable()
    {
        return $this->morphTo();
    }
}
