<?php

namespace LaravelUtility\Repository\Repositories;

/**
 *
 * @author ankit
 */
trait Accessor
{
    
    public function __call($method, $arguments)
    {
        preg_match('/^get(One|Many)By([+\w]*)$/', $method, $matches);
        if(isset($matches[2]))
        {
            $key = snake_case($matches[2]);
            $function = 'get' . $matches[1] . 'ByField' . ((isset($arguments[1]) and $arguments[1] == 'cache')  ? 'FromCache' : null);
            return $this->$function($key, $arguments[0]);
        }
            
    }
    
}
