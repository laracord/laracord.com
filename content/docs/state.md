---
slug: state
title: 'State'
description: 'Easily access the full state of your Laracord Discord bot in any class.'
priority: 5
group: Usage
---

Any class extended from Laracord's framework will typically have multiple methods available to access various components/state such as the Bot, Discord, and Console instances.

## Accessing the Bot

The `bot` instance in this context is the `Laracord` class instance that is initialized when booting the bot. This instance contains the event loop and boot logic.

The `bot` instance is registered with the application container and can be accessed globally using `app()`:

```php
$bot = app('bot');
```

When inside of a class that extends Laracord, the `bot` instance will always be available on the `bot()` getter:

```php
$bot = $this->bot();
```

## Accessing Discord

The Discord instance consists of the DiscordPHP client and can be used anywhere in the bot as long as you have access to the application container.

When inside of a class that extends Laracord, the Discord instance is available using the `discord()` getter:

```php
$channel = $this->discord()->getChannel('your-channel-id');
```

If you need to access the Discord instance outside of Laracord, you can use the `bot` instance in the application container:

```php
$discord = app('bot')->discord();
```

## Accessing Console

Console works the same way as the Discord instance. It is always available using the `console()` getter:

```php
$this->console()->log('Hello world!');
```

Or by using the application container:

```php
$console = app('bot')->console();
```
