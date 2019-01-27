<?php

namespace LaravelUtility\Repository\Repositories;

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
            $key = snake_case($matches[2]);
            $function = $matches[1] . 'ByField' . ((isset($arguments[1]) and $arguments[1] == 'cache')  ? 'FromCache' : null);
            return $this->$function($key, $arguments[0]);
        }
            
    }
    
}
