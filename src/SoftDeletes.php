<?php

namespace ApolloPY\Eloquent;

use Illuminate\Database\Eloquent\SoftDeletes as BaseSoftDeletes;

/**
 * SoftDeletes trait
 *
 * @author ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Eloquent
 */
trait SoftDeletes
{
    use BaseSoftDeletes;

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function runSoftDelete()
    {
        $query = $this->newQueryWithoutScopes()->where($this->getKeyName(), $this->getKey());

        $this->{$this->getDeletedAtColumn()} = $time = $this->freshTimestamp();

        $this->affectedRows = $query->update([$this->getDeletedAtColumn() => $this->fromDateTime($time)]);
    }
}
