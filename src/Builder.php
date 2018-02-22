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

    /**
     * Chunk the results of a query by comparing numeric IDs.
     *
     * @param  int $count
     * @param  callable $callback
     * @param  string $column
     * @param  string|null $alias
     * @return bool
     */
    public function chunkById($count, callable $callback, $column = null, $alias = null)
    {
        $column = is_null($column) ? $this->getModel()->getKeyName() : $column;

        $alias = is_null($alias) ? $column : $alias;

        $lastId = 0;

        do {
            $clone = clone $this;

            // We'll execute the query for the given page and get the results. If there are
            // no results we can just break and return from here. When there are results
            // we will call the callback with the current chunk of these results here.
            $results = $clone->forPageAfterId($count, $lastId, $column)->get();

            $countResults = $results->count();

            if ($countResults == 0) {
                break;
            }

            // On each chunk result set, we will pass them to the callback and then let the
            // developer take care of everything within the callback, which allows us to
            // keep the memory low for spinning through large result sets for working.
            if ($callback($results) === false) {
                return false;
            }

            $lastId = $results->last()->{$alias};

            unset($results);
        } while ($countResults == $count);

        return true;
    }
}
