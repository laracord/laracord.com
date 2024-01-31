---
slug: commands
title: 'Commands'
description: 'Learn how to create Discord bot commands with Laracord.'
priority: 1
group: Usage
---

Out of the box, Laracord includes a simple `!ping` command to test your bot with a simple response.

## Creating Commands

Creating your own command is simple and can be generated using the `laracord` binary:

```sh
$ php laracord make:command Example
```

A generated command in it's simplest form will look something like:

```php
<?php

namespace App\Commands;

use Laracord\Commands\Command;

class Example extends Command
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'example';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'The command description.';

    /**
     * Handle the command.
     *
     * @param  \Discord\Parts\Channel\Message  $message
     * @param  array  $args
     * @return void
     */
    public function handle($message, $args)
    {
        return $this
            ->message()
            ->title('Example')
            ->content('Hello world!')
            ->send($message);
    }
}
```
