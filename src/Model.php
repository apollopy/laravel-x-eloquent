<?php

namespace ApolloPY\Eloquent;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Builder as BaseBuilder;

/**
 * Model class
 *
 * @author  ApolloPY <ApolloPY@Gmail.com>
 * @package ApolloPY\Eloquent
 */
abstract class Model extends BaseModel
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \ApolloPY\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

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

    /**
     * The number of affected rows in a previous write operation
     *
     * @var int
     */
    protected $affectedRows = 0;

    /**
     * Get the number of affected rows in a previous write operation
     *
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->affectedRows;
    }

    /**
     * Perform a model update operation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $options
     * @return bool
     */
    protected function performUpdate(BaseBuilder $query, array $options = [])
    {
        $dirty = $this->getDirty();

        if (count($dirty) > 0) {
            // If the updating event returns false, we will cancel the update operation so
            // developers can hook Validation systems into their models and cancel this
            // operation if the model does not pass validation. Otherwise, we update.
            if ($this->fireModelEvent('updating') === false) {
                return false;
            }

            // First we need to create a fresh query instance and touch the creation and
            // update timestamp on the model which are maintained by us for developer
            // convenience. Then we will just continue saving the model instances.
            if ($this->timestamps && Arr::get($options, 'timestamps', true)) {
                $this->updateTimestamps();
            }

            // Once we have run the update operation, we will fire the "updated" event for
            // this model instance. This will allow developers to hook into these after
            // models are updated, giving them a chance to do any special processing.
            $dirty = $this->getDirty();

            if (count($dirty) > 0) {
                $this->affectedRows = $this->setKeysForSaveQuery($query)->update($dirty);

                $this->fireModelEvent('updated', false);
            }
        }

        return true;
    }

    /**
     * Perform the actual delete query on this model instance.
     *
     * @return void
     */
    protected function performDeleteOnModel()
    {
        $this->affectedRows = $this->setKeysForSaveQuery($this->newQueryWithoutScopes())->delete();
    }
}
