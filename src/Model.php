<?php

namespace ApolloPY\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Model class
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Eloquent
 */
abstract class Model extends BaseModel
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \ApolloPY\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

}
