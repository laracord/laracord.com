---
slug: installation
title: 'Installation'
description: 'Learn how to install Laracord and get a Discord bot up and running in just a few steps.'
priority: 1
group: 'Getting Started'
---

## What is Laracord?

Laracord is a [micro-framework](https://github.com/laracord/framework) that provides a beautiful starting point for your next Discord bot.

Build functional, elegant bots harnessing the full power of [Laravel](https://laravel.com/) alongside [DiscordPHP](https://github.com/discord-php/DiscordPHP).

![Screenshot](/images/laracord-cli.png)

## Features

- Out of the box support for databases, caching, and many other Laravel features thanks to [Laravel Zero](https://laravel-zero.com/).
- Instantly generate working bot commands and event listeners with 0 knowledge.
- Automatic handling of registering/updating/unregistering application slash commands.
- Generate asynchronous services/tasks that run parallel to the bot.
- Optional HTTP Server with native Laravel routing and Livewire support.
- Fully configurable and extendable.
- Beautiful console logging with timestamps.
- Fully documented and maintained.

## Requirements

Laracord utilizes Composer for managing dependencies. Before using Laracord, please ensure you have Composer installed on your machine.

- [PHP](https://www.php.net/releases/) >= 8.2
- [Composer](https://getcomposer.org/)

The following PHP extensions are also required:

- [fileinfo](https://www.php.net/manual/en/book.fileinfo.php)
- [sqlite3](https://www.php.net/manual/en/book.sqlite3.php)
- [pdo_sqlite](https://www.php.net/manual/en/ref.pdo-sqlite.php)
- [sodium](https://www.php.net/manual/en/book.sodium.php) (to build for production)

## Creating a Project

Before creating your first Laracord project, make sure that your local machine has [PHP](https://secure.php.net/manual/en/install.php) and [Composer](https://getcomposer.org/download/) installed.

After you have installed PHP and Composer, you may create a new Laracord project via Composer's `create-project` command:

```sh
$ composer create-project laracord/laracord
$ cd laracord
```

## Initial Configuration

In order to run the Bot, you will have to create an **Application** using the [Discord Developer Portal](https://discord.com/developers/applications) and obtain a **bot token**.

By default, the Bot will also require you enable the necessary [Intents](https://discord.com/developers/docs/topics/gateway#gateway-intents).

These can be found and enabled in the developer portal under `Settings > Bot > Privileged Gateway Intents`.

![Intents Screenshot](/images/discord-intents.png)

Once you obtain a bot token, you can configure it inside of `.env`:

```env
DISCORD_TOKEN=...
```

## Booting Laracord

To boot your bot, simply run `laracord` with no arguments passed:

```sh
$ php laracord
```

When booting Laracord using a bot token that is currently not in any servers, Laracord will automatically output an invite link in console for convenience.

### Adding a Bot Admin

For convenience, Laracord comes with a console command to set a specified user as admin using their Discord ID:

```sh
$ php laracord bot:admin <id>
```

### Tinker (REPL)

Laracord comes with full support for [Tinker](https://github.com/laravel/tinker) out of the box.

```sh
$ php laracord tinker
```

### Additional Commands

To view all built-in console commands, you can run the `list` command:

```sh
$ php laracord list
```
