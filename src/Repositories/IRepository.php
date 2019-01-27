<?php

namespace LaravelUtility\Repository\Repositories;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
interface IRepository
{
    public function findByField($key, $value);
    public function findByFields(array $fieldsAndValues);
    
    public function fetchByField($key, $value);
    public function fetchByFields(array $fieldsAndValues);
}
