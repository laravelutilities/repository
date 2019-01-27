# Model Repository package for Laravel

This package allows you to create Model Repository with ease. You can use this package as an add-on on existing laravel model classes. Hightlights are given below

* Cache Repository
* Model Repository
* Make Repository Artisan Commands

## Getting Started

### 1. Install

Run the following command:

```bash
composer require laravelutilities/repository
```
### 2. Publish

Publish config file.

```bash
php artisan vendor:publish --tag=repository
```


### 4. Configure

You can change the options of your app from `config/repository.php` file

## Usage

You can inject the dependency of a repository in any controller and use its functions like `$this->repository->getManyByCreatedAt('foo')` or if you want to use cache `$this->repository->getManyByCreatedAt('foo', 'cache')`
### Variations 
```php
$this->repository->getOneByFieldFromCache('created_at', 'somevalue'); // extending cache repository; fetch only single value
$this->repository->getOneByFieldsFromCache(['created_at' => 'somevalue', 'city' => 'someanothervalue',...]); // fetch multiple values
$this->repository->getOneByField('created_at', 'somevalue'); // extending model repository; fetch only single value
$this->repository->getOneByField('created_at', 'somevalue'); // extending model repository; fetch only single value

public function getManyByFieldFromCache($key, $value);
public function getManyByFieldsFromCache(array $fieldsAndValues);

public function getById($id);
public function getByIds(array $ids)

```

### Controller Constructor

```php

use App\Repositories\OrganizationRepository;

protected $organization;
    
public function __construct(OrganizationRepository $organization)
{
    $this->organization = $organization;
}
```
### Model Repository Methods

```php
public function getOneByField($key, $value);
public function getOneByFields(array $fieldsAndValues);

public function getManyByField($key, $value);
public function getManyByFields(array $fieldsAndValues);
```

### Cache Repository Methods

```php
public function getOneByFieldFromCache($key, $value);
public function getOneByFieldsFromCache(array $fieldsAndValues);

public function getManyByFieldFromCache($key, $value);
public function getManyByFieldsFromCache(array $fieldsAndValues);

public function getById($id);
public function getByIds(array $ids)

```



### Accessor Trait

A Trait has been added to further augment these functions using magic method. In all the above mentioned functions, `Field` can be replaced in any of the model field. Suppose, you have a field `created_at` inside your table; this can be called in variaous ways given below

```php
$this->repository->getOneByCreatedAt('somevalue'); // extending model repository; fetch only single value

$this->repository->getOneByCreatedAt('somevalue','cache'); // extending cache repository; fetch only single value

$this->repository->getManyByCreatedAt(['created_at' => 'somevalue', 'city' => 'someanothervalue',...]); // fetch multiple values
```

### Make Repository Command

```bash
php artisan make:repository <name> --model=<model> --cache=true/false
```
You can create Repository classes using `make:repository` command.
#### `<name>` is mandatory; specifies the name of the repository. Using `Repository` as a suffix is mandatory. And if you don't write the name with `Repository` as suffix, command do for you.
#### `--model=modelname` as option if you don't menthion the name of the model, it tries to find the model same as Repository .if model is not created it ask if you want to creat new model.
#### `cache=true|false`, default is true, your repository extends CacheRepository else Model Repository

## Changelog

Please see [Releases](../../releases) for more information what has changed recently.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
