<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zoom extends Model
{
    use HasFactory;
    protected $table = 'zoom';
    protected $fillable = ['id', 'code', 'created_at', 'user_id', 'updated_at'];

    public function devices()
    {
        return $this->belongsToMany(device::class, 'room_device', 'zoom_id', 'device_id')->withPivot('state');
    }

    public function hasDevice($device_id)
    {
        foreach ($this->devices as $device) {
            if ($device->id == $device_id) {
                return true;
            }
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
