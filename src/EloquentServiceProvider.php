<?php

namespace ApolloPY\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;

/**
 * EloquentServiceProvider class.
 *
 * @author ApolloPY <ApolloPY@Gmail.com>
 */
class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Sort the collection using by designated key.
         */
        Collection::macro('sortByIds', function (array $ids, $key = 'id') {
            $ids = array_flip($ids);

            return $this->sort(function ($a, $b) use ($ids, $key) {
                $a_value = Arr::get($a, $key, '');
                $b_value = Arr::get($b, $key, '');

                return Arr::get($ids, $a_value, PHP_INT_MAX) - Arr::get($ids, $b_value, PHP_INT_MAX);
            });
        });

        /**
         * Chunk the results of a query by time.
         */
        Builder::macro('chunkByTime', function ($time_interval, callable $callback, $column = 'created_at') {
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
        });
    }
}
