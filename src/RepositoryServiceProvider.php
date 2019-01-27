<?php

namespace LaravelUtility\Repository;

use Illuminate\Support\ServiceProvider;
use LaravelUtility\Repository\Console\Commands\RepositoryMakeCommand;

use Illuminate\Filesystem\Filesystem;

/**
 * Description of RepositoryServiceProvider
 *
 * 
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
 
class RepositoryServiceProvider extends ServiceProvider
{
    protected $defer = true;
    
    
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/repository.php' => config_path('repository.php'),
        ], 'repository');
    }
    
    public function register()
    {
        $this->app->singleton('command.repository', function () {
            return new RepositoryMakeCommand(new Filesystem);
        });
        $this->commands(['command.repository']);

        $this->mergeConfigFrom(__DIR__.'/config/repository.php', 'repository');
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
