<?php

namespace ApolloPY\Eloquent;

use Illuminate\Database\Eloquent\Builder as BaseBuilder;

/**
 * Builder class.
 *
 * @author ApolloPY <ApolloPY@Gmail.com>
 */
class Builder extends BaseBuilder
{
    /**
     * Chunk the results of a query by time.
     *
     * @param integer $time_interval
     * @param callable $callback
     * @param string $column
     * @return bool
     */
    public function chunkByTime($time_interval, callable $callback, $column = 'created_at')
    {
        $clone = clone $this;
        $result = $clone->orderBy($column)->first([$column]);
        if (is_null($result)) {
            return true;
        }
        $start_time = strtotime($this->getModel()->fromDateTime($result->$column));

        $clone = clone $this;
        $result = $clone->orderBy($column, 'desc')->first([$column]);
        $end_time = strtotime($this->getModel()->fromDateTime($result->$column));

        for ($min_time = $start_time; $min_time <= $end_time; $min_time += $time_interval) {

            $start_date = $this->getModel()->fromDateTime($min_time);
            $end_date = $this->getModel()->fromDateTime($min_time + $time_interval);

            $clone = clone $this;

            $results = $clone->where($column, '>=', $start_date)->where($column, '<', $end_date)->get();

            if ($callback($results) === false) {
                return false;
            }

            unset($results);
        }

        return true;
    }

}
