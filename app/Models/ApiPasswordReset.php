<?php

namespace App\Models;

class ApiPasswordReset extends BaseModel
{
    protected $table = 'api_password_resets';
    protected $fillable = [
        'email', 'token', 'username'
    ];
}
