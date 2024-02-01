---
slug: structure
title: 'Directory Structure'
description: 'If you are comfortable with Laravel, Laracord provides a very familiar starting point.'
priority: 3
group: 'Getting Started'
---

Laracord is based on [Laravel Zero](https://github.com/laravel-zero/laravel-zero) and has a very similar directory structure and build process.

The primary difference is the `Commands` directory consists of Discord commands instead of console commands. Instead, console commands are located in `Console/Commands` and the directory structure brings focus to the bot instead of CLI.

```sh
.
├── app
│   ├── Commands
│   ├── Console
│   │   └── Commands
│   ├── Events
│   ├── Models
│   ├── Providers
│   │   └── BotServiceProvider.php
│   ├── Services
│   ├── SlashCommands
│   └── Bot.php
├── bootstrap
│   └── app.php
├── config
│   ├── app.php
│   └── discord.php
├── database
│   └── migrations
└── laracord
```
