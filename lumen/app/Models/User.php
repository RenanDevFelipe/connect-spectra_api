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

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'email', 'password',  'remember_token', 'role'];
    protected $hidden = ['password', 'remember_token'];

    protected $rememberTokenName = 'remember_token';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

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
