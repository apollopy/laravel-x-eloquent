# laravel-x-eloquent

## Installation

```base
composer require apollopy/laravel-x-eloquent
```

## Use

```php
namespace App;

use ApolloPY\Eloquent\Model;
// use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
}
```

## Extension

### sortByIds

```php
$ids = [3, 1, 2];
$posts = Post::find($ids); // collection -> [1, 2, 3]
$posts = $posts->sortByIds($ids); // collection -> [2 => 3, 0 => 1, 1 => 2]
$posts = $posts->values(); // collection -> [3, 1, 2]
```

### casts

```php
class Post extends Model
{
    protected $casts = [
        'contents' => 'base64', // auto base64_encode and base64_decode, fixed save emoji to mysql
    ];
}
```

### getAffectedRows

Get the number of affected rows in a previous write operation. when use transaction, you may need.

For SoftDeletes `use ApolloPY\Eloquent\SoftDeletes;`

```php
$obj1 = Post::find(1);
$obj2 = clone $obj1;

$obj1->content = 'aaa';
$obj2->content = 'aaa';

$obj1->save(); // return true
$obj2->save(); // return true

$obj1->getAffectedRows(); // return 1
$obj2->getAffectedRows(); // return 0

$obj2->delete(); // return true
$obj1->delete(); // return true

$obj1->getAffectedRows(); // return 0
$obj2->getAffectedRows(); // return 1
```

## Model make command

edit config/app.php

```php
// config/app.php

'aliases' => [
    // 'Eloquent'   => Illuminate\Database\Eloquent\Model::class,
    'Eloquent'   => ApolloPY\Eloquent\Model::class,
],

'providers' => [
    ApolloPY\Eloquent\ModelMake\ModelMakeServiceProvider::class,
]
```

using the make:model Artisan command

```bash
php artisan make:model A
```

The A class:

```php
<?php

namespace App;

use Eloquent as Model;

class A extends Model
{
    //
}

```
