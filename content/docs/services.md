---
slug: services
title: 'Services'
priority: 4
group: Usage
---

Services are asynchronous tasks that run parallel to the Discord bot on an interval. This is useful for scenarios such as fetching data from an API every so often and sending the results to Discord through the bot.

Services created in your application are automatically booted alongside your bot with the Discord instance being easily accessible through `discord()`.

To create a service, run the `make:service` command:

```sh
$ php laracord make:service Example
```

The default generated service will create a task that logs `Hello World` to console every 5 seconds.

```php
<?php

namespace App\Services;

use Laracord\Services\Service;

class Example extends Service
{
    /**
     * The service interval.
     */
    protected int $interval = 5;

    /**
     * Handle the service.
     */
    public function handle(): void
    {
        $channel = $this->discord()->getChannel('your-channel-id');

        $this
            ->message()
            ->content('Hello world.')
            ->send($channel);

        $this->console()->log('Hello world.');
    }
}
```

Sending a message to a Discord channel through a service can be done similarily to commands. The exception is you must get an instance of the channel/user to send the message to. This can be done through accessing the Discord instance:

```php
$channel = $this->discord()->getChannel('your-channel-id');

$this
    ->message()
    ->content('Hello world.')
    ->send($channel);

$user = $this->discord()->users->get('id', 'a-user-id');

$this
    ->message()
    ->content('Hello world.')
    ->sendTo($user);
```
