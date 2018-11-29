<?php

namespace ApolloPY\Eloquent\Traits;

use ApolloPY\Eloquent\Builder;

/**
 * UseXEloquentBuilder trait.
 *
 * @author ApolloPY <ApolloPY@Gmail.com>
 */
trait UseXEloquentBuilder
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
