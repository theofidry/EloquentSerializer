<?php

namespace Fidry\LaravelSerializerSymfony\Model;

use Illuminate\Database\Eloquent\Model as EloquentModel;

/**
 * @property int    id
 * @property string address
 *
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class AnotherDummy extends EloquentModel
{
    /**
     * @inheritdoc
     */
    protected $fillable = [
        'id',
        'address',
    ];
    
    /**
     * @inheritdoc
     */
    public $timestamps = false;
}
