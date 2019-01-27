<?php

namespace LaravelUtility\Repository\Repositories;

use Illuminate\Support\Facades\Cache;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
class CacheRepository extends ModelRepository
{
    public function getOneByFieldFromCache($key, $value)
    {
        $cacheKey = $this->prefix . ':' . $key . ':' . $value;
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttle'), function() use ($key, $value){
            return Organization::where($key, $value)->first();
        });
    }
    
    public function getManyByFieldFromCache($key, $value)
    {
        $cacheKey = str_plural($this->prefix) . ":" . $key . ":" . $value;
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($key, $value){
            return $this->model->where($key, $value)->get()->pluck('id');
        })->map(function($id){
            return $this->getById($id);
        });
    }
    
    public function getOneByFieldsFromCache(array $fieldsAndValues)
    {
        $cacheKey = $this->prefix . ":" . md5(print_r($fieldsAndValues, true));
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($fieldsAndValues){
            return $this->model->where($fieldsAndValues)->first();
        });
    }
    
    public function getManyByFieldsFromCache(array $fieldsAndValues)
    {
        $cacheKey = str_plural($this->prefix) . ":" . md5(print_r($fieldsAndValues, true));
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($fieldsAndValues){
            return $this->model->where($fieldsAndValues)->get()->pluck('id');
        })->map(function($id){
            return $this->getById($id);
        });
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
}
