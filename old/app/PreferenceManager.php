<?php

namespace App;

use App\Models\Preference;
use Illuminate\Support\Arr;

class PreferenceManager
{
    /**
     * The associated model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Create a new preference manager instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all model preferences values.
     *
     * @return array
     */
    public function all()
    {
        $array = [];

        foreach ($this->model->modelPreferences as $item) {
            Arr::set($array, $item->key, $this->cast($item->value, $item->type));
        }

        return $array;
    }

    /**
     * Determine whether the model has the given preference or not.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->model->modelPreferences
                ->where('key', $key)
                ->count() > 0;
    }

    /**
     * Retrieve given preference value.
     *
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if ($this->has($key)) {
            $preference = $this->model->modelPreferences
                ->where('key', $key)
                ->first();

            return $this->cast($preference->value, $preference->type);
        }

        return $default;
    }

    /**
     * Set one or multiple preferences values.
     *
     * @param string|array $key
     * @param mixed|null $value
     */
    public function set($key, $value = null)
    {
        if (is_string($key)) {
            $key = [
                $key => $value
            ];
        }

        foreach ($key as $k => $v) {
            $this->createOrUpdate($k, $v);
        }
    }

    /**
     * Delete given preference value from the database.
     *
     * @param string $key
     */
    public function unset($key)
    {
        $preference = $this->model->modelPreferences
            ->where('key', $key)
            ->first();

        if ($preference) {
            $preference->delete();
        }
    }

    /**
     * Cast preference value to the given data type.
     *
     * @param string $value
     * @param string $type
     * @return mixed
     */
    protected function cast($value, $type)
    {
        settype($value, $type);

        return $value;
    }

    /**
     * Create or update preference value.
     *
     * @param string $key
     * @param mixed $value
     */
    protected function createOrUpdate($key, $value)
    {
        $preference = $this->model->modelPreferences
            ->where('key', $key)
            ->first();

        if ($preference) {
            $preference->update([
                'value' => $value,
                'type'  => gettype($value)
            ]);
        } else {
            $preference = new Preference([
                'key'   => $key,
                'value' => $value,
                'type'  => gettype($value),
            ]);

            $this->model->modelPreferences()->save($preference);
        }
    }
}
