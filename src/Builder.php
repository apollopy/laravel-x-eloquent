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
     * @param integer $start_time
     * @param integer $time_interval
     * @param callable $callback
     * @param string $column
     * @param integer $end_time
     * @param string $date_format
     * @return bool
     */
    public function chunkByTime($start_time, $time_interval, callable $callback, $column = 'created_at', $end_time = null, $date_format = 'Y-m-d H:i:s')
    {
        if (is_null($end_time)) {
            $end_time = time();
        }
        if ($start_time > $end_time) {
            return false;
        }

        for ($min_time = $start_time; $min_time <= $end_time; $min_time += $time_interval) {

            $start_date = date($date_format, $min_time);
            $end_date = date($date_format, $min_time + $time_interval);

            $clone = clone $this;

            $results = $clone->where($column, '>=', $start_date)->where($column, '<', $end_date)->get();

            if (call_user_func($callback, $results) === false) {
                return false;
            }

            unset($results);
        }

        return true;
    }
}
