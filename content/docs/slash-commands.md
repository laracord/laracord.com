---
slug: slash-commands
title: 'Slash Commands'
priority: 2
group: Usage
---

Laracord comes with full support for application commands (slash commands) out of the box.

This includes automatically syncing changes you make to your command as well as re-registering it in the event that you bind it to a specific guild.

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

Adding options to your slash command can be done by passing an array of options to the `$options` property **or** overriding the `options()` method. Options can be specified as a raw array or by passing an array of [DiscordPHP Option Parts](https://github.com/discord-php/DiscordPHP/wiki/Option_commands).

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
```

```php
use Discord\Parts\Interactions\Command\Option;

/**
 * Set the command options.
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
