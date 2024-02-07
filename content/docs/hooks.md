---
slug: hooks
title: 'Hooks'
description: 'Laracord has support for 45+ Discord hooks out of the box.'
priority: 2
group: Advanced
---

Laracord comes with various hooks and override-able methods to initialize your own classes alongside the boot process. This is primarily done in `app/Bot.php`.

## Before Boot

The `beforeBoot()` method can be defined to run code before the bot is booted. This is useful for initial configuration or other pre-boot tasks.

```php
/**
 * Actions to run before booting the bot.
 */
public function beforeBoot(): void
{
    ini_set('memory_limit', '-1');

    cache()->flush();
}
```

## After Boot

The `afterBoot()` method can be defined to run code after the bot is booted. This typically happens the first time the Discord `ready` event is fired.

```php
/**
 * Actions to run after booting the bot.
 */
public function afterBoot(): void
{
    $this->console()->log('Hello world!');
}
```
