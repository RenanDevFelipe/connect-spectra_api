<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    protected $fillable = ['name', 'email', 'password',  'remember_token'];
    protected $hidden = ['password', 'remember_token'];

    protected $rememberTokenName = 'remember_token';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function setPasswordAttribute($value)
    {
        if (!Str::startsWith($value, '$2y$')) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
