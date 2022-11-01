<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    // use HasApiTokens, HasFactory, Notifiable, HasRoles;
    use Notifiable;
    protected $connection = 'mysql2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    
    }

    public function replies()
    {
        return $this->setConnection('mysql')->belongsToMany(Replies::class, 'replie_user', 'user_id', 'replie_id');
    }
    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function ($pr) {
            return [$pr['name'] => true];
        });
    }

    public function activities()
    {
        return $this->hasMany(Activities::class, 'user_id');
    }

    public function reply_user()
    {
        return $this->hasMany(Replies::class,'replie_user');
       
    }

    public function zooms()
    {
        return $this->hasMany(Zoom::class,   'user_id');
        
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'users_id');
      
    }

    public function roles(){
        return $this->belongsTo(Roles::class,'role_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'users.'.$this->id;
    }
}
