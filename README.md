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

You can inject the dependency of a repository in any controller and use its functions like `$this->repository->fetchByCreatedAt('foo')` or if you want to use cache `$this->repository->fetchByCreatedAt('foo', 'cache')`
### Variations 
```php
$this->repository->findByFieldFromCache('created_at', 'somevalue'); // extending cache repository; fetch only single value
$this->repository->findByFieldsFromCache(['created_at' => 'somevalue', 'city' => 'someanothervalue',...]); // fetch multiple values
$this->repository->findByField('created_at', 'somevalue'); // extending model repository; fetch only single value
$this->repository->findByField('created_at', 'somevalue'); // extending model repository; fetch only single value

public function fetchByFieldFromCache($key, $value);
public function fetchByFieldsFromCache(array $fieldsAndValues);

public function getById($id);
public function getByIds(array $ids)

```

### Controller Constructor

```php

use App\Repositories\OrganizationRepository;

protected $organization;
    
public function __construct()
{
    $this->organization = new OrganizationRepository();
}
```

### Repository Class with Database

```php

namespace App\Repositories;

use App\Models\AppLog;
use LaravelUtility\Repository\Repositories\ModelRepository;

class AppLogRepository extends ModelRepository
{
    public function __construct()
    {
        parent::__construct(new AppLog());
    }
}

```


### Repository Class with Cache

```php

namespace App\Repositories;

use App\Models\AppLog;
use LaravelUtility\Repository\Repositories\CacheRepository;

class AppLogRepository extends CacheRepository
{
    public function __construct()
    {
        parent::__construct(new AppLog());
    }
}

```

### Model Repository Methods

```php
public function findByField($key, $value);
public function findByFields(array $fieldsAndValues);

public function fetchByField($key, $value);
public function fetchByFields(array $fieldsAndValues);
```

### Cache Repository Methods

```php
public function findByFieldFromCache($key, $value);
public function findByFieldsFromCache(array $fieldsAndValues);

public function fetchByFieldFromCache($key, $value);
public function fetchByFieldsFromCache(array $fieldsAndValues);

public function getById($id);
public function getByIds(array $ids)

```



### Accessor Trait

A Trait has been added to further augment these functions using magic method. In all the above mentioned functions, `Field` can be replaced in any of the model field. Suppose, you have a field `created_at` inside your table; this can be called in variaous ways given below

```php
$this->repository->findByCreatedAt('somevalue'); // extending model repository; fetch only single value

$this->repository->findByCreatedAt('somevalue','cache'); // extending cache repository; fetch only single value

$this->repository->fetchByCreatedAt(['created_at' => 'somevalue', 'city' => 'someanothervalue',...]); // fetch multiple values
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
