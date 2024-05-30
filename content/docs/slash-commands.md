---
slug: slash-commands
title: 'Slash Commands'
description: 'Create powerful Discord slash commands and let Laracord handle the hard work for you.'
priority: 2
group: Usage
---

Laracord comes with full support for application commands (slash commands) out of the box.

This includes automatically syncing changes you make to your command as well as re-registering it in the event that you bind it to a specific guild.

> #### Note
>
> **Do not** attempt to use Laracord on the same bot token as an existing bot with application commands. Laracord will **sync/cache slash commands** on boot and will **remove** any commands that are not registered with Laracord.

## Creating Slash Commands

Laracord has full support for slash commands out of the box. When a command is created, updated, or removed – the Discord application command repository is automatically updated.

Similar to creating a normal command, creating a slash command can be done using the `laracord` binary:

```sh
$ php laracord make:slash-command Example
```

A generated slash command in it's simplest form will look something like:

```php
<?php

namespace App\SlashCommands;

use Laracord\Commands\SlashCommand;

class Example extends SlashCommand
{
    /**
     * The slash command name.
     *
     * @var string
     */
    protected $name = 'example';

    /**
     * The slash command description.
     *
     * @var string
     */
    protected $description = 'The example slash command.';

    /**
     * Handle the slash command.
     *
     * @param  \Discord\Parts\Interactions\Interaction  $interaction
     * @return void
     */
    public function handle($interaction)
    {
        $interaction->respondWithMessage(
            $this
              ->message()
              ->title('Example')
              ->content('Hello world!')
              ->build()
        );
    }
}
```

To only register a slash command to a specific guild/server, you may set the `$guild` property:

```php
/**
 * The guild the command belongs to.
 *
 * @var string
 */
protected $guild = 'your-guild-id';
```

Adding options to your slash command can be done by passing an array of options to the `$options` property **or** overriding the `options()` method.

Options can be specified as a raw array or by passing an array of [DiscordPHP Option Parts](https://github.com/discord-php/DiscordPHP/wiki/Option_commands):

```php
use Discord\Parts\Interactions\Command\Option;

/**
 * The slash command options.
 *
 * @var array
 */
protected $options = [
    [
        'name' => 'message',
        'description' => 'Send a message through the bot.',
        'type' => Option::STRING,
        'required' => true,
    ],
];

/**
 * The slash command options.
 *
 * @return array
 */
public function options()
{
    $option = new Option($this->discord());

    return [
        $option
          ->setName('message')
          ->setDescription('Send a message through the bot')
          ->setType(Option::STRING)
          ->setRequired(true)
          ->toArray(),
    ];
}
```

## Retrieving Option Values

Laracord makes it easy to retrieve any passed command option values in your handler using the `value()` method.

Let's use the following options as an example:

```php
use Discord\Parts\Interactions\Command\Option;

protected $options = [
    [
        'name' => 'set',
        'description' => 'Manage the ticket system.',
        'type' => Option::SUB_COMMAND_GROUP,
        'options' => [
            [
                'name' => 'channel',
                'description' => 'Set the ticket channel.',
                'type' => Option::SUB_COMMAND,
                'options' => [
                    [
                        'name' => 'id',
                        'description' => 'The channel ID.',
                        'type' => Option::STRING,
                        'required' => true,
                    ],
                ],
            ],
        ],
    ],
];
```

In the above example, we have a `set` command group for our `/ticket` command. Inside of it, it has a sub command called `channel` which ultimately has an `id` which gets passed by the user and used in the command.

To retrieve that `id`, we can simply transverse through the nested options using dot notation:

```php
$id = $this->value('set.channel.id', $default = null);
```

By default, `value` will return `null` when no option value is found. This makes it safe to use when checking for the existence of option keys and handling command logic depending on what is passed.

To retrieve all flattened option values, you can simply omit passing a key:

```php
$values = $this->value();
```
