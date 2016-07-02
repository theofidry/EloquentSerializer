<?php

namespace Fidry\EloquentSerializer\Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @property int                id
 * @property string             name
 * @property string             email
 * @property \DateTimeInterface created_at
 * @property string             password
 * @property string             remember_token
 * @property AnotherDummy       anotherDummy
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class Dummy extends EloquentModel
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'created_at',
    ];

    /**
     * @inheritdoc
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @inheritdoc
     */
    public $timestamps = false;

    public function anotherDummy()
    {
        return $this->belongsTo(AnotherDummy::class);
    }
}
