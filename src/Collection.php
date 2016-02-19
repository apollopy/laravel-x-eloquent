<?php

namespace ApolloPY\Eloquent;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Collection as BaseCollection;

/**
 * Collection class
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Eloquent
 */
class Collection extends BaseCollection
{
    /**
     * @param array $ids
     * @return static
     */
    public function sortByIds(array $ids)
    {
        $ids = array_flip($ids);
        return $this->sort(function ($a, $b) use ($ids) {
            if ($a instanceof BaseModel && $b instanceof BaseModel) {
                return $ids[$a->getKey()] - $ids[$b->getKey()];
            } else {
                return $ids[data_get($a, 'id')] - $ids[data_get($b, 'id')];
            }
        });
    }
}
