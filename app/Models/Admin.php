<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['name', 'password'];
    public $timestamps = false;

    public function messages1()
    {
        return $this->hasMany(Message1::class);
    }

    public function messages2()
    {
        return $this->hasMany(Message2::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
