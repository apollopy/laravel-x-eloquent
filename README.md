# laravel-x-eloquent

## Installation

```base
composer require apollopy/laravel-x-eloquent
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
ApolloPY\Eloquent\EloquentServiceProvider::class,
```
**Laravel 5.5** uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

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
Topic::where('user_id', 1)->chunkByTime(3600, function ($topics) {
    //
});
```
