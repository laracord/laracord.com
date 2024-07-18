---
slug: context-menus
title: 'Context Menus'
description: 'Allow interacting with your Discord bot using context menus.'
priority: 3
group: Usage
---

Context menus are similar to slash commands, but are instead shown under `Apps` when right clicking/tapping a user or message.

Unlike slash commands, context menus do not contain options or subcommands.

## Creating a Context Menu

Creating your first context menu can be done using the `make:menu` command:

```sh
$ php laracord make:menu ExampleMenu
```

A context menu in it's simplest form will look something like:

```php
<?php

namespace App\Menus;

use Discord\Parts\Channel\Message;
use Discord\Parts\Interactions\Interaction;
use Discord\Parts\User\User;
use Laracord\Commands\ContextMenu;

class ExampleMenu extends ContextMenu
{
    /**
     * The context menu name.
     *
     * @var string
     */
    protected $name = 'Example Menu';

    /**
     * The context menu type.
     */
    protected string|int $type = 'message';

    /**
     * Handle the context menu interaction.
     */
    public function handle(Interaction $interaction, Message|User|null $target): mixed
    {
        $interaction->respondWithMessage(
            $this
              ->message()
              ->title('Example Menu')
              ->content('Hello world!')
              ->build()
        );
    }
}
```

### Context Menu Types

By default, the context menu will be shown when right-clicking a **message**. To have it shown when right-clicking a **user** instead, simply change `$type` to `user`:

```php
/**
 * The context menu type.
 */
protected string|int $type = 'user';
```

### Guild Context Menus

To only register a context menu to a specific guild/server, you may set the `$guild` property:

```php
/**
 * The guild the context menu belongs to.
 *
 * @var string
 */
protected $guild = 'your-guild-id';
```
