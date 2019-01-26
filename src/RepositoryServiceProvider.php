<?php

namespace LaravelUtility\Repository;

use Illuminate\Support\ServiceProvider;
use LaravelUtility\Repository\Console\Commands\RepositoryMakeCommand;

use Illuminate\Filesystem\Filesystem;

/**
 * Description of RepositoryServiceProvider
 *
 * @author ankit
 */
class RepositoryServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    public function boot()
    {
    }
    
    public function register()
    {
        $this->app->singleton('command.repository', function () {
            return new RepositoryMakeCommand(new Filesystem);
        });

        $this->commands(['command.repository']);
    }
    
     /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.repository'];
    }
}
