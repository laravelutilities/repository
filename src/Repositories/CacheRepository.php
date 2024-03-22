<?php

namespace LaravelUtility\Repository\Repositories;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
class CacheRepository extends ModelRepository
{
    public function findByFieldFromCache($key, $value)
    {
        $cacheKey = $this->prefix . ':' . $key . ':' . $value;
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($key, $value){
            return $this->model->where($key, $value)->first();
        });
    }
    
    public function fetchByFieldFromCache($key, $value)
    {
        $cacheKey = Str::plural($this->prefix) . ":" . $key . ":" . $value;
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($key, $value){
            return $this->model->where($key, $value)->get()->pluck('id');
        })->map(function($id){
            return $this->getById($id);
        });
    }
    
    public function findByFieldsFromCache(array $fieldsAndValues)
    {
        $cacheKey = $this->prefix . ":" . md5(print_r($fieldsAndValues, true));
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($fieldsAndValues){
            return $this->model->where($fieldsAndValues)->first();
        });
    }
    
    public function fetchByFieldsFromCache(array $fieldsAndValues)
    {
        $cacheKey = Str::plural($this->prefix) . ":" . md5(print_r($fieldsAndValues, true));
        return Cache::tags($this->prefix)->remember($cacheKey, config('repository.cache_ttl'), function() use ($fieldsAndValues){
            return $this->model->where($fieldsAndValues)->get()->pluck('id');
        })->map(function($id){
            return $this->getById($id);
        });
    }

    public function getById($id)
    {
        return $this->findByFieldFromCache('id', $id);
    }

    public function getByIds(array $ids)
    {
        $results = [];
        foreach ($ids as $id) {
            $results[$id] = $this->findByFieldFromCache('id', $id);
        }
        return $results;
    }
}
