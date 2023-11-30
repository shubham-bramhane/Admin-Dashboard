<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    protected $fillable = ['ip_address', 'login_time', 'logout_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
