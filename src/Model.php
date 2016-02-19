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

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value) || !$this->isExtensionCastable($key)) {
            return parent::castAttribute($key, $value);
        }

        switch ($this->getCastType($key)) {
            case 'base64':
                return base64_decode($value);
            default:
                return $value;
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        if (is_null($value) || !$this->isExtensionCastable($key) || $this->hasSetMutator($key)) {
            return parent::setAttribute($key, $value);
        }

        switch ($this->getCastType($key)) {
            case 'base64':
                $value = base64_encode($value);
                break;
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Determine whether a value is Extension castable for inbound manipulation.
     *
     * @param  string $key
     * @return bool
     */
    protected function isExtensionCastable($key)
    {
        return $this->hasCast($key) && in_array($this->getCastType($key), ['base64'], true);
    }
}
