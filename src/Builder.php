<?php

namespace ApolloPY\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

/**
 * Builder class
 *
 * @see     该类暂时没被调用,只是为 _ide_helper.php 准备
 * @author  ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Eloquent
 */
class Builder extends BaseBuilder
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \ApolloPY\Eloquent\Model|\ApolloPY\Eloquent\Collection|null
     */
    public function find($id, $columns = ['*'])
    {
        return parent::find($id, $columns);
    }
}
