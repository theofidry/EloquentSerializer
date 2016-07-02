<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int                id
 * @property string             name
 * @property string             email
 * @property \DateTimeInterface created_at
 * @property string             password
 * @property string             remember_token
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password', 'created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = false;
    
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
