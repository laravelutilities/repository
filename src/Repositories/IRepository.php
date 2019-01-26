<?php

namespace LaravelUtility\Repository\Repositories;

/**
 *
 * @author ankit
 */
interface IRepository
{
    public function getOneByField($key, $value);
    public function getOneByFields(array $fieldsAndValues);
    
    public function getManyByField($key, $value);
    public function getManyByFields(array $fieldsAndValues);
}
