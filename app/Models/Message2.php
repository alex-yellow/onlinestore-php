<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message2 extends Model
{
    protected $table = 'messages2';
    protected $fillable = ['admin_id', 'user_id', 'message_text'];
    public $timestamps = false;

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
