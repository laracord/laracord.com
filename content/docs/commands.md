---
slug: commands
title: 'Commands'
description: 'Learn how to create Discord bot commands with Laracord.'
priority: 1
group: Usage
---

Out of the box, Laracord includes a simple `!ping` command to test your bot with a simple response.

![Ping example screenshot](/images/ping-example.png)

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

In the command above, the bot will send a message to the current channel with **Hello world!** when using the `!example` command.

To send the message to a user directly, you can use the `->sendTo()` method on the author instead:

```php
return $this
    ->message()
    ->title('Example')
    ->content('Hello world!')
    ->sendTo($message->author);
```

For a more in-depth example, check out the **Examples** section in the documentation sidebar.

## Command Help

Out of the box, Laracord registers a default `!help` command which sends a message to the channel of the bot's registered commands consisting of syntax/usage and descriptions.

Hiding a command from the `!help` command can be done by setting the `$hidden` property in the command class to `true`:

```php
/**
 * Indicates whether the command should be displayed in the commands list.
 *
 * @var bool
 */
protected $hidden = true;
```

To opt out of using the default `!help` command, simply remove, `Laracord\Commands\HelpCommand::class` from the `commands` section in `config/discord.php`.
