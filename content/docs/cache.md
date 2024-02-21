---
slug: cache
title: 'Cache'
description: 'Efficient use of caching can help keep your Discord bot performant.'
priority: 3
group: 'Digging Deeper'
---

Out of the box, Laracord has support for Laravel's `array` driver for caching. This allows you to use the `Cache` facade or `cache()` helper anywhere in your project.

By default, the project cache will be stored in the `cache/` directory inside of the project. When a bot is built for production, a `cache` folder will be created alongside the binary.

## Usage

Laravel has [in-depth documentation](https://laravel.com/docs/10.x/cache) concerning the usage of `Cache` within Laravel, but here are the basics:

### Storing Cache

Storing an item in cache can be done using the `put()` method on the global `cache()` helper:

```php
$cached = cache()->put('key', 'value', now()->addMinute());
```

You can cache a key forever using the `->forever()` method:

```php
$forever = cache()->forever('key', 'value');
```

Another option is `->rememberForever()` which will return the value of the cache otherwise firing and caching a callback to retrieve the value:

```php
$remember = cache()->rememberForever('key', fn () => ['hello', 'world']);
```

### Retrieving Cache

Retrieving cache is extremely straight forward and can be done using `->get()`:

```php
$cache = cache()->get('key');
```

### Flushing Cache

Individual cache keys can be removed using the `->forget()` method:

```php
cache()->forget('key');
```

To flush the entire cache, you can use `->flush()`:

```php
cache()->flush();
```
