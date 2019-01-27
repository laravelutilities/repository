<?php

return [
   /**
    * Redis connection to be used
    */
    'use' => 'cache',
    
    /**
     * Cache TTL in minutes
     */
   'cache_ttl' => env('REPOSITORY_CACHE_TTLE', 60)
];

