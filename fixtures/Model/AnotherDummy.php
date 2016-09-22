<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fidry\EloquentSerializer\Model;

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
