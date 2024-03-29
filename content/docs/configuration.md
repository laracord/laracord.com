---
slug: configuration
title: 'Configuration'
description: 'Configuring Laracord to get a Discord bot up and running can be done in just a few minutes.'
priority: 2
group: 'Getting Started'
---

Out of the box, Laracord consists of a sane default configuration and in most cases, you will only need to modify your `.env` file.

Outside of `.env`, most Laracord configuration is done inside of `config/discord.php`.

The `discord.php` configuration file is heavily documented and attempts to explain each config value in a way that is easy to understand.

## Default Configuration

The default configuration found in the Laracord skeleton can be found below:

```php
<?php

use Discord\WebSockets\Intents;

return [

    /*
    |--------------------------------------------------------------------------
    | Discord Bot Description
    |--------------------------------------------------------------------------
    |
    | Here you may specify the description of your Discord bot. This will be
    | used when the bot is mentioned in chat, or when you run the "servers"
    | command. Change this to anything you like.
    |
    */

    'description' => env('DISCORD_BOT_DESCRIPTION', 'The Laracord Discord Bot.'),

    /*
    |--------------------------------------------------------------------------
    | Discord Token
    |--------------------------------------------------------------------------
    |
    | Here you may specify your Discord bot token. You can find it under the
    | "Bot" section of your Discord application. Make sure to keep this
    | token private and never share it with anyone for security.
    |
    */

    'token' => env('DISCORD_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Gateway Intents
    |--------------------------------------------------------------------------
    |
    | Here you may specify the gateway intents for your Discord bot. This
    | will tell Discord what events your bot should receive. Intents can be
    | enabled in the Discord developer application portal under:
    |
    | Settings > Bot > Privileged Gateway Intents
    |
    */

    'intents' => Intents::getDefaultIntents() | Intents::MESSAGE_CONTENT | Intents::GUILD_MEMBERS,

    /*
    |--------------------------------------------------------------------------
    | Command Prefix
    |--------------------------------------------------------------------------
    |
    | Here you may specify the command prefix for the Discord bot. This
    | prefix will be used to distinguish commands from regular chat
    | messages. To use mentioning the bot as a prefix, use "@mention".
    | To use multiple prefixes, you may pass an array instead.
    |
    */

    'prefix' => env('DISCORD_COMMAND_PREFIX', '!'),

    /*
    |--------------------------------------------------------------------------
    | Additional DiscordPHP Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify any additional options for the DiscordPHP client.
    | These options will be passed directly to the DiscordPHP client.
    |
    | For more information, see the DiscordPHP documentation:
    |   ↪ <https://discord-php.github.io/DiscordPHP/#basics>
    |
    */

    'options' => [
        'loadAllMembers' => true,
    ],

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

    /*
    |--------------------------------------------------------------------------
    | Timestamp Format
    |--------------------------------------------------------------------------
    |
    | Here you may specify the timestamp format for the Discord bot. This
    | format will be used when formatting console output. You can set this
    | to `false` to disable timestamps.
    |
    */

    'timestamp' => 'h:i:s A',

    /*
    |--------------------------------------------------------------------------
    | Bot Admins
    |--------------------------------------------------------------------------
    |
    | Here you may manually specify bot admins without using the User model.
    | These users will have access to all bot admin commands. User's must
    | be specified by their Discord user ID.
    |
    */

    'admins' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional Commands
    |--------------------------------------------------------------------------
    |
    | Here you may specify any additional commands for the Discord bot. These
    | commands will be loaded in addition to the commands automatically loaded
    | in your project. By default, the Laracord-provided help command is
    | is registered here.
    |
    */

    'commands' => [
        Laracord\Commands\HelpCommand::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional Services
    |--------------------------------------------------------------------------
    |
    | Here you may specify any additional services to run asynchronously
    | alongside the Discord bot. These services will be loaded in addition
    | to the services automatically loaded from your project.
    |
    */

    'services' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional Events
    |--------------------------------------------------------------------------
    |
    | Here you may specify any additional events to listen for in your
    | Discord bot. These events will be registered in addition to the
    | events automatically registered from your project.
    |
    */

    'events' => [
        //
    ],

];
```

## Hide Commands on Boot

By default, Laracord displays a table of registered commands upon booting. To prevent this default behavior, set the `$showCommands` property to `false` in your `Bot.php` file:

```php
/**
 * Determine whether to show the commands on boot.
 */
protected bool $showCommands = false;
```
