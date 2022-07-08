<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class device extends Model
{
    use HasFactory;
    protected $table = 'devices';
    protected $fillable = ['id',    'deviceID',  'deviceName', 'serial', 'os_version', 'battery',  'created_at', 'state',   'updated_at'];

    public function zooms()
    {
        return $this->belongsToMany(Zoom::class, 'room_device', 'device_id', 'zoom_id')->withPivot('state');
    }
}
