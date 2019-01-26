<?php

namespace LaravelUtility\Repository\Repositories;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
interface IRepository
{
    public function getOneByField($key, $value);
    public function getOneByFields(array $fieldsAndValues);
    
    public function getManyByField($key, $value);
    public function getManyByFields(array $fieldsAndValues);
}
