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
        $path = file_exists(config_path('repository.php')) ? config_path('repository.php') : __DIR__.'/config/repository.php';
        $this->app->singleton('command.repository', function () {
            return new RepositoryMakeCommand(new Filesystem);
        });

        $this->commands(['command.repository']);
        $this->app['config']->set('database', array_merge_recursive(
                $this->app['config']->get('database'),
                require $path));
        
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
