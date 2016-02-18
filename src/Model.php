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
     * Create a new Eloquent Collection instance.
     *
     * @param array $models
     * @return \ApolloPY\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new Collection($models);
    }
}
