<?php

namespace LaravelUtility\Repository\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
class CacheRepository extends ModelRepository
{

    protected $redis;
    
    public function __construct(Model $model)
    {
        parent::__construct($model);
        $this->redis  = Redis::connection('repository');
    }
    
    public function getOneByFieldFromCache($key, $value)
    {
        
        $cacheKey = $this->prefix . ":" . $key . ":" . $value;
        if ($this->has($cacheKey)) {
            $result = json_decode($this->redis->get($cacheKey));
        } else {
            $result = $this->getOneByField($key, $value);
            $this->redis->set($cacheKey, $result);
        }
        return $result;
    }

    public function getOneByFieldsFromCache(array $fieldsAndValues)
    {
        $cacheKey = $this->prefix . ":" . md5(print_r($fieldsAndValues, true));
        if ($this->has($cacheKey)) {
            $result = $this->redis->smembers($cacheKey);
        } else {
            $result = $this->getOneByFields($fieldsAndValues)->pluck('id');
            $this->redis->sadd($cacheKey, current($result));
        }
        return $this->getById(current($result));
    }

    public function getManyByFieldFromCache($key, $value)
    {
        $cacheKey = str_plural($this->prefix) . ":" . $key . ":" . $value;
        if ($this->has($cacheKey)) {
            $result = $this->redis->smembers($cacheKey);
        } else {
            $result = $this->getManyByField($key, $value)->pluck('id')->toArray();
            $this->redis->sadd($cacheKey, $result);
        }
        return $this->getByIds($result);
    }

    public function getManyByFieldsFromCache(array $fieldsAndValues)
    {
        $cacheKey = str_plural($this->prefix) . md5(print_r($fieldsAndValues, true));
        
        if ($this->has($cacheKey)) {
            $result = $this->redis->smembers($cacheKey);
        } else {
            $result = $this->getManyByFields($fieldsAndValues)->pluck('id')->toArray();
            $this->redis->sadd($cacheKey, $result);
        }
        return $this->getByIds($result);
    }

    public function getById($id)
    {
        return $this->getOneByFieldFromCache('id', $id);
    }

    public function getByIds(array $ids)
    {
        $results = [];
        foreach ($ids as $id) {
            $results[$id] = $this->getOneByFieldFromCache('id', $id);
        }
        return $results;
    }

    /**
     * Determine if the given configuration value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return $this->redis->exists($key);
    }
}
