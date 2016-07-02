<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int    id
 * @property string address
 */
class Address extends Model
{
    protected $fillable = [
        'id', 'address',
    ];
    public $timestamps = false;
}
