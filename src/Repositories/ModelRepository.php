<?php

namespace LaravelUtility\Repository\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
class ModelRepository implements IRepository
{
    
    use Accessor;
    
    protected $model;
    protected $prefix;
    
    public function __construct(Model $model)
    {
        $this->model  = $model;
        $this->prefix = str_singular($this->model->getTable());
    }
    
    
    public function getOneByField($key, $value)
    {
        return $this->model->where($key, $value)->first();
    }

    public function getManyByField($key, $value)
    {
        return $this->model->where($key, $value)->get();
    }

    public function getOneByFields(array $fieldsAndValues)
    {
        return $this->model->where($fieldsAndValues)->first();
    }

    public function getManyByFields(array $fieldsAndValues)
    {
        return $this->model->where($fieldsAndValues)->get();
    }
}
