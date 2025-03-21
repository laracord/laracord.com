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

## Developing Slash Commands

Discord uses client-side caching which can make development difficult. When developing slash commands, you can set the `$guild` property on your command to a specific Discord server ID to ensure your changes are immediately visible during development. You can also manually refresh the cache by pressing **CMD+R** (macOS) or **CTRL+R** (Windows).

## Creating Slash Commands

Laracord has full support for slash commands out of the box. When a command is created, updated, or removed – the Discord application command repository is automatically updated.

Similar to creating a normal command, creating a slash command can be done using the `laracord` binary:

```sh
$ php laracord make:slash-command ExampleCommand
```

A slash command in it's simplest form will look something like:

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

### Command Permissions

Discord allows you to limit application commands to users who have specific [permission flags](https://discord.com/developers/docs/topics/permissions#permissions-bitwise-permission-flags). This can be done by passing the required permissions to the `$permissions` property as an array:

```php
/**
 * The permissions required to use the command.
 *
 * @var array
 */
protected $permissions = ['manage_guild'];
```

### Guild Slash Commands

To only register a slash command to a specific guild/server, you may set the `$guild` property:

```php
/**
 * The guild the command belongs to.
 *
 * @var string
 */
protected $guild = 'your-guild-id';
```

## Command Options

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

### Retrieving Option Values

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

## Command Autocomplete

When asking for input from commands like the channel `id` above for `/ticket set channel <id>`, Laracord allows you to easily provide autocomplete results to assist the user.

> #### Note
>
> Autocomplete choices may only contain up to 25 items at a time and will automatically be limited.

How you can approach this is rather flexible and any command/subcommand can be targeted using dot-notation.

In it's simplest form, you may pass a simple array of options to autocomplete to:

```php
/**
 * Set the autocomplete choices.
 */
public function autocomplete(): array
{
    return [
        'set.channel.id' => [
            '00000',
            '11111',
        ],
    ];
}
```

By default, Laracord will automatically handle creating slug values out of passed options. To control the label and value yourself, you may pass them using key value pairs:

```php
public function autocomplete(): array
{
    return [
        'set.channel.id' => [
            'General Chat' => '00000',
            'Staff Chat' => '11111'
        ],
    ];
}
```

For dynamic autocomplete choices, you may pass a callback instead consisting of the current state of the command interaction and the value they currently have entered:

```php
use Discord\Parts\Interactions\Interaction;

public function autocomplete(): array
{
    return [
        'set.channel.id' => fn (Interaction $interaction, mixed $value) => $value
            ? TicketChannel::where('channel_id', 'like', "%{$value}%")->take(25)->pluck('channel_id')
            : TicketChannel::take(25)->pluck('channel_id'),
    ];
}
```

### Slash Commands with Multiple Inputs

You can create more complex slash commands by combining sub-commands with multiple input fields. This is useful when your command needs to collect several pieces of information from the user in one interaction.

Here's an example of a generic "create" command with multiple inputs:

```php
use Discord\Parts\Interactions\Command\Option;

/**
 * The slash command options.
 *
 * @var array
 */
protected $options = [
    [
        'name' => 'create',
        'description' => 'Create a new item',
        'type' => Option::SUB_COMMAND,
        'options' => [
            [
                'name' => 'name',
                'description' => 'The name of the item',
                'type' => Option::STRING,
                'required' => true,
            ],
            [
                'name' => 'description',
                'description' => 'A description of the item',
                'type' => Option::STRING,
                'required' => true,
            ],
            [
                'name' => 'category',
                'description' => 'The category for this item',
                'type' => Option::STRING,
                'required' => false,
            ],
            [
                'name' => 'priority',
                'description' => 'Set the item priority (1-5)',
                'type' => Option::INTEGER,
                'required' => false,
                'min_value' => 1,
                'max_value' => 5,
            ],
        ],
    ],
];
```

In your command handler, you can access these values using the dot notation:

```php
public function handle($interaction)
{
    $name = $this->value('create.name');
    $description = $this->value('create.description');
    $category = $this->value('create.category', 'General');
    $priority = $this->value('create.priority', 3);
    
    // Process the command with these inputs
    $item = $this->itemService->createNewItem($name, $description, $category, $priority);
    
    $interaction->respondWithMessage(
        $this
            ->message()
            ->title('Item Created')
            ->content("Successfully created **{$name}** with priority **{$priority}**!")
            ->build()
    );
}
```
