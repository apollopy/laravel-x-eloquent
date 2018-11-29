<?php

namespace ApolloPY\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

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
        Collection::macro('sortByIds', function (array $ids) {
            $ids = array_flip($ids);

            return $this->sort(function ($a, $b) use ($ids) {
                return Arr::get($ids, $a->getKey(), PHP_INT_MAX) - Arr::get($ids, $b->getKey(), PHP_INT_MAX);
            });
        });
    }
}
