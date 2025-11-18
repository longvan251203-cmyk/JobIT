<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Quan hệ 1-1 với Applicant
    public function applicant()
    {
        return $this->hasOne(Applicant::class, 'user_id', 'id');
    }
    public function employer()
    {
        return $this->hasOne(Employer::class, 'user_id');
    }
}
