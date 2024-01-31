---
slug: events
title: 'Events'
description: 'Quickly hook into Discord events with your Laracord bot.'
priority: 3
group: Usage
---

Laracord makes creating handlers for specific Discord events extremely straight forward. All [DiscordPHP](https://discord-php.github.io/DiscordPHP/#events) event listeners are supported out of the box and are easily generated using CLI, batteries included.

## Creating an Event

Creating an event handler can be done using the `laracord` binary:

```sh
$ php laracord make:event Example
```

When creating an event, you will be prompted to choose a listener from a searchable select box.

![Event Screenshot](/images/make-event.png)

Once you select a listener, an Event class will automatically be generated including the necessary namespaces/typing specific to the handler.

Here is an example of a simple `MESSAGE_CREATE` event handler that logs a message to console everytime a message is created:

```php
<?php

namespace App\Events;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event as Events;
use Laracord\Events\Event;

class Example extends Event
{
    /**
     * The event handler.
     *
     * @var string
     */
    protected $handler = Events::MESSAGE_CREATE;

    /**
     * Handle the event.
     */
    public function handle(Message $message, Discord $discord)
    {
        $this->console()->log('The Message Create event has fired!');
    }
}
```
