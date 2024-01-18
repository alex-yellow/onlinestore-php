<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'password'];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function messages1()
    {
        return $this->hasMany(Message1::class);
    }

    public function messages2()
    {
        return $this->hasMany(Message2::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
