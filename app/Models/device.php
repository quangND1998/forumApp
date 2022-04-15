<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $fillable = ['id',    'deviceID',  'deviceName',   'created_at',    'updated_at'];
}
