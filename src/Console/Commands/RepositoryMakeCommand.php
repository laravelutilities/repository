<?php

namespace LaravelUtility\Repository\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
/**
 * @author Ankit Vishwakarma <er.ankitvishwakarma@gmail.com>
 * @modified Jan 26, 2019
 */
class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : The name of the repository}'
            . '{--model= : The model to be assoicated}'
            . '{--cache=true : Repository use cache}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new repository command';
    
     /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $type = $this->option('cache') == 'true' ? 'cache' : 'model';
        $stub = "/stubs/repository.$type.stub";

        return __DIR__.$stub;
    }

    /**
     * Parse the class name and format according to the root namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function qualifyClass($name)
    {
        $name = ltrim($name, '\\/');

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($name, $rootNamespace)) {
            return $name;
        }

        $name = str_replace('/', '\\', $name);
        $name = ends_with($name, 'Repository') ? $name : $name.'Repository'; 

        return $this->qualifyClass(
            $this->getDefaultNamespace(trim($rootNamespace, '\\')).'\\'.$name
        );
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

     /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [];
        $model = $this->option('model');
        if(empty($model))
        {
            $model = str_replace('Repository', '', $this->argument('name'));
        }
        
        $replace = $this->buildModelReplacements($replace, $model);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }
    /**
     * Build the model replacement values.
     *
     * @param  array  $replace
     * @return array
     */
    protected function buildModelReplacements(array $replace, $model)
    {
        $modelClass = $this->parseModel($model);
        if (! class_exists($modelClass)) {
            if ($this->confirm("A {$modelClass} model does not exist. Do you want to generate it?", true)) {
                $this->call('make:model', ['name' => $modelClass]);
            }
        }
        
        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            'DummyModelVariable' => lcfirst(class_basename($modelClass)),
        ]);
    }
    
    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = trim(str_replace('/', '\\', $model), '\\');
        if (! Str::startsWith($model, $rootNamespace = $this->laravel->getNamespace() . 'Models\\')) {
            $model = $rootNamespace.$model;
        }

        return $model;
    }
}
