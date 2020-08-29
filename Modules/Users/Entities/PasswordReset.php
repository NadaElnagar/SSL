<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = "password_resets";
    protected $primary_key = 'id';
    public $incrementing = false;
    public $timestamps= false;
    protected $fillable = [
        'email', 'token'
    ];
}
