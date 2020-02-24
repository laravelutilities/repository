<?php

namespace LaravelUtility\Repository\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Feb 24, 2020
 */
class ModelRepository implements IRepository
{

    use Accessor, RepositoryActions;

    protected $model;
    protected $prefix;

    public function __construct(Model $model)
    {
        $this->model  = $model;
        $this->prefix = str_singular($this->model->getTable());
    }


    public function findByField($key, $value)
    {
        return $this->model->where($key, $value)->first();
    }

    public function fetchByField($key, $value)
    {
        return $this->model->where($key, $value)->get();
    }

    public function findByFields(array $fieldsAndValues)
    {
        return $this->model->where($fieldsAndValues)->first();
    }

    public function fetchByFields(array $fieldsAndValues)
    {
        return $this->model->where($fieldsAndValues)->get();
    }
}
