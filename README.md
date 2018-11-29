# laravel-x-eloquent

## Installation

```base
composer require apollopy/laravel-x-eloquent
```

## Extension

### sortByIds

```php
$ids = [3, 1, 2];
$posts = Post::find($ids); // collection -> [1, 2, 3]
$posts = $posts->sortByIds($ids); // collection -> [2 => 3, 0 => 1, 1 => 2]
$posts = $posts->values(); // collection -> [3, 1, 2]
```

### chunkByTime

```php
namespace App;

use Illuminate\Database\Eloquent\Model;
use ApolloPY\Eloquent\Traits\UseXEloquentBuilder;

class Topic extends Model
{
    use UseXEloquentBuilder;
}


Topic::where('user_id', 1)->chunkByTime(3600, function ($topics) {
    //
});
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
