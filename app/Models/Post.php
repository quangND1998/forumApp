<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'posts';
    protected $fillable = ['id', 'name', 'active',   'created_at', 'user_id',  'updated_at'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $model->user_id = auth()->user()->id;
        });
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
