<?php

namespace LaravelUtility\Repository\Repositories;
use Illuminate\Support\Str;
/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
trait Accessor
{
    
    public function __call($method, $arguments)
    {
        preg_match('/^(find|fetch)By([+\w]*)$/', $method, $matches);
        if(isset($matches[2]))
        {
            $key = Str::snake($matches[2]);
            
            $function = $matches[1] . 'ByField' . $this->suffix($arguments);
            return $this->$function($key, $arguments[0]);
        }
            
    }
    
    private function suffix($arguments)
    {
        $suffix = null;
        if(isset($arguments[1]))
        {
            if(in_array($arguments[1], ['cache', true])
                    and ($this instanceof CacheRepository))
            {
                $suffix = 'FromCache';
            }
        }
        return $suffix;
    }
    
}
