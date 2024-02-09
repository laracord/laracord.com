---
slug: http-server
title: 'HTTP Server'
description: 'Laracord provides an HTTP server with Laravel routing out of the box.'
priority: 5
group: Usage
---

Laracord provides an optional [reactphp/http](https://github.com/reactphp/http) server with Laravel routing support out of the box. This can be useful for creating webhooks and/or an API to interact with your bot.

> #### Note
>
> Please refer to the [Security](#content-security) section for generating an API token.

## Configuration

The Laracord HTTP server conditionally starts if there are valid routes registered to your application.

By default, the HTTP server will be accessible on port `:8080`.

This can be configured by specifying a port and optional IP to the `HTTP_SERVER` environment variable:

```env
HTTP_SERVER=:8080 # Binds on all addresses.
HTTP_SERVER=127.0.0.1:8080 # Binds on localhost.
```

If omitting the IP address, the port must be prefixed with `:`.

If you need to set this value dynamically, you may do so in the `config/discord.php` configuration file:

```php
/*
|--------------------------------------------------------------------------
| HTTP Server
|--------------------------------------------------------------------------
|
| The Laracord HTTP server allows you to receive and respond to HTTP
| requests from the bot at the specified address/port. This can be useful
| for creating a RESTful API for your bot.
|
| The HTTP server is automatically started when a `routes.php` file is
| present and contains valid routes. You can override this behavior by
| setting this option to `false`.
|
*/

'http' => env('HTTP_SERVER', ':8080'),
```

## Routes

Routes can be defined inside of the `routes()` method in your `Bot` class located at `app/Bot.php`.

By default, an example route is provided but is commented out:

```php
/**
 * The HTTP routes.
 */
public function routes(): void
{
    Route::middleware('auth')->group(function () {
        Route::get('/', fn () => collect($this->registeredCommands)->map(fn ($command) => [
            'signature' => $command->getSignature(),
            'description' => $command->getDescription(),
        ]));
    });
}
```

## Controllers

Similar to Laravel, you may generate dedicated [Controllers](https://laravel.com/docs/10.x/controllers) to handle your route logic.

This can be done using the `make:controller` console command:

```sh
$ php laracord make:controller ExampleController
```

Generated controllers will be located in the `app/Http` directory.

To use your Controller, start by giving it a method that returns some type of data:

```php
<?php

namespace App\Http;

use Illuminate\Http\Request;
use Laracord\Http\Controllers\Controller;

class ExampleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {
        return ['message' => 'Hello world!'];
    }
}
```

After, add your Controller along with a Route to `app/Bot.php`:

```php
<?php

namespace App;

use Illuminate\Support\Facades\Route;
use Laracord\Laracord;

class Bot extends Laracord
{
    /**
     * The HTTP routes.
     */
    public function routes(): void
    {
        Route::middleware('auth')->group(function () {
            Route::get('/example', 'App\Http\ExampleController@index');
        });
    }
}
```

Your Controller's `index` method should now be available at `/example`.

## Middleware

Custom Middleware can easily be configured globally using the `middleware()` and `prependMiddleware()` methods on the `Bot` class. Both of these methods expect an array of Middleware.

```php
/**
 * The HTTP middleware.
 */
public function middleware(): array
{
    return [];
}

/**
 * The prepended HTTP middleware.
 */
public function prependMiddleware(): array
{
    return [];
}
```

## Security

It is suggested that all routes utilize the `auth` middleware as shown in the default `routes()` example. This will require you pass an API token through the `token` query parameter or through the `Authorization` header as a `Bearer` token.

Generating an API token for use with the `auth` middleware can be done through the `laracord` binary by passing the user ID of the Discord user who it should be assigned to:

```sh
$ php laracord bot:token <id> [--revoke] [--regenerate]
```

Once a token has been generated, the easiest way to access your protected route is by using the `token` query parameter like so:

```
http://localhost:8080/?token=<token>
```

## Debugging

While in an environment that is not `production`, the HTTP server will return Symfony error pages and the default Laravel response code pages.

![Exception Screenshot](/images/http-server-exception.png)

When in production, all responses are instead returned as generic `JSON` and exception messages are not shown.
