<?php

namespace LaravelUtility\Repository\Repositories;

use Illuminate\Support\Facades\DB;

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
        return $this->model->insert($insertData);
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
        return $this->model->create($insertData);
    }

    public function insertOrUpdate($data)
    {
        $tableName = $this->model->getTable();
        if (empty($data)) {
            return false;
        }

        $columns = implode(", ", array_keys($data[0]));
        $updateColumns = array_map(function ($column) {
            return "{$column} = VALUES({$column})";
        }, array_keys($data[0]));
        $updateColumns = implode(", ", $updateColumns);

        $values = [];
        foreach ($data as $row) {
            $values[] = "('" . implode("', '", array_map(function ($r) {
                return addslashes($r);
            }, array_values($row))) . "')";
        }
        $values = implode(", ", $values);

        $query = "INSERT INTO {$tableName} ({$columns}) VALUES {$values} ON DUPLICATE KEY UPDATE {$updateColumns}";

        // Execute the query here (e.g., using PDO)

        return DB::statement($query);
        return $query;
    }

    public function truncate($foreignKeyChecks = false)
    {
        if($foreignKeyChecks)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }
        $this->model->truncate();
        if($foreignKeyChecks)
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
