---
slug: filesystem
title: 'Filesystem'
description: "Make use of Laravel's powerful filesystem abstraction powered by Flysystem."
priority: 4
group: 'Digging Deeper'
---

Laravel provides Laracord with a powerful filesystem abstraction out of the box utilizing [Flysystem](https://github.com/thephpleague/flysystem). This allows you to easily work with files on your system.

> #### Note
>
> For advanced usage, we strongly suggest checking out the official [Laravel Filesystem documentation](https://laravel.com/docs/10.x/filesystem).

## File Usage

Basic file operations can mostly be covered using the `File` facade:

```php
<?php

use Illuminate\Support\Facades\File;

File::put('/path/to/file.txt', 'Hello world');

$file = File::get('/path/to/file.txt');
```

## Storage Usage

The `Storage` facade allows you to interact with your bot's configured storage directly. By default, this is the `storage/app` folder inside your bot project.

While in production, the `storage` directory will be created alongside the `laracord` binary in the current working directory.

```php
<?php

use Illuminate\Support\Facades\Storage;

Storage::put('file.txt', 'Hello world');

$file = Storage::get('file.txt');
```
