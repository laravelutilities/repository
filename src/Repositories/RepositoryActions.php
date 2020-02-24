<?php

namespace LaravelUtility\Repository\Repositories;
/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Feb 24, 2020
 */
trait RepositoryActions
{
    /**
     * Get the instance of the Model
     */
    public function getInstance()
    {
        return $this->model;
    }
    /**
     * Function is used to insert data
     *
     * Function will only be used with the repository class.
     * @param array $insertData
     *
     * @return object
    */
    public function insert($insertData)
    {
        return $this->model->insert( $insertData );
    }

    /**
     * Update Or Create operation
     *
     * @param array $condition
     * @param array $insertData
     * @return int
     */
    public function updateOrCreate($condition, $insertData)
    {
        return $this->model->updateOrCreate($condition, $insertData);
    }

    public function exists(array $condition)
    {
        return $this->model->where($condition)->exists();
    }
    /**
     * Where In Operation
     *
     * @param string $field
     * @param array $data
     * @return object
     */
    public function whereIn($field, $data)
    {
        return $this->model->whereIn($field, $data);
    }

    public function create($insertData)
    {
        return $this->model->create( $insertData );
    }

}
