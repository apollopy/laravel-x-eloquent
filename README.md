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

## IDE Helper

if installed barryvdh/laravel-ide-helper

edit the config file: config/ide-helper.php

```php
    'extra' => array(
        // add 'ApolloPY\Eloquent\Builder'
        'Eloquent' => array('ApolloPY\Eloquent\Builder', 'Illuminate\Database\Eloquent\Builder', 'Illuminate\Database\Query\Builder'),
        'Session' => array('Illuminate\Session\Store'),
    ),
```
