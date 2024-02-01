---
slug: installation
title: 'Installation'
description: 'Learn how to install Laracord and get a Discord bot up and running in just a few steps.'
priority: 1
group: 'Getting Started'
---

## What is Laracord?

Laracord is a [micro-framework](https://github.com/laracord/framework) that provides a powerful starting point for your next Discord bot.

Build functional, elegant bots harnessing the full power of [Laravel](https://laravel.com/) alongside [DiscordPHP](https://github.com/discord-php/DiscordPHP).

![Screenshot](/images/laracord-cli.png)

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

### Adding a Bot Admin

For convenience, Laracord comes with a console command to set a specified user as admin using their Discord ID:

```sh
$ php laracord bot:admin <id>
```

### Additional Commands

To view all built-in console commands, you can run the `list` command:

```sh
$ php laracord list
```
