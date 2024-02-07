---
slug: http-client
title: 'HTTP Client'
description: "Make use of Laravel's expressive API around the Guzzle HTTP client in your Discord bot."
priority: 4
group: 'Digging Deeper'
---

Laracord provides out of the box support for Laravel's expressive HTTP client based on [Guzzle](https://github.com/guzzle/guzzle). This allows an extremely easy way to handle making API requests from your bot.

For advanced usage, we strongly suggest referring to the official [HTTP Client Laravel documentation](https://laravel.com/docs/10.x/http-client).

## Usage

Basic usage of the HTTP client can be done using the `get()` and `post()` methods on the `Http` facade:

```php
<?php

use Illuminate\Support\Facades\Http;

$body = Http::get($url);
$post = Http::post($url, $data = []);
```
