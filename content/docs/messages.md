---
slug: messages
title: 'Messages'
description: 'Send beautiful, powerful embed messages with your Discord bot with zero configuration.'
priority: 1
group: 'Digging Deeper'
---

Laracord's `Message` component provides a powerful fluent syntax to send Discord messages to users and channels.

## Basic Usage

When working in the context of Laracord, the `Message` component is almost always available using the `$this->message()` method.

In it's simplest form, message generally requires some form of content and a destination.

```php
$this
    ->message('Hello world!')
    ->send('channel-id');

$this
    ->message('Hello user!')
    ->sendTo('user-id');
```

This gives you a sensibly styled embed with the username and avatar of your bot.

![Simple Message](/images/simple-message.png)

To send a plain message without an embed, you may pass your content to the `->body()` method:

```php
$this
    ->message()
    ->body('Hello world!');
```

## Direct Usage

When `$this->message()` is not available in your class, you can typically access and make `Message` directly:

```php
use Laracord\Discord\Message;

Message::make()->content('Hello world!');
```

## Available Methods

- [Title](#content-title)
- [URL](#content-url)
- [Content](#content-content)
- [Username](#content-username)
- [Avatar](#content-avatar)
- [TTS](#content-tts)
- [Color](#content-color)
- [Footer](#content-footer)
- [Thumbnail](#content-thumbnail)
- [Image](#content-image)
- [Timestamp](#content-timestamp)
- [Author](#content-author)
- [Fields](#content-fields)
- [Files](#content-files)
- [Buttons](#content-buttons)
  - [Link Button](#content-link-button)
  - [Interactions](#content-interactions)
- [Select Menus](#content-select-menus)
  - [Menu Types](#content-menu-types)
- [Body](#content-body)

### Title

Set the title of the embed:

```php
$this
    ->message('Hello world!')
    ->title('Example');
```

### URL

Set the url of the title:

```php
$this
    ->message('Hello world!')
    ->title('Example')
    ->url('https://laracord.com');
```

### Content

Set the content of the embed. This can be used instead of passing content to `message` directly:

```php
$this
    ->message()
    ->content('Hello world!');
```

### Username

By default, this is the username of your bot application.

```php
$this
    ->message('Hello world!')
    ->username('Laracord');
```

### Avatar

By default, this is the avatar of your bot application.

```php
$this
    ->message('Hello world!')
    ->avatarUrl('...');
```

### TTS

This determines whether your message is a TTS message.

```php
$this
    ->message('Hello world!')
    ->tts(true);
```

### Color

By default, Laracord sends embeds using `->success()` which provides a green border color.

This can be overriden by passing a color in decimal directly to `->color()` or by using the other available color helper methods:

```php
$this
    ->message('Hello world!')
    ->color('3066993')
    ->success()
    ->error()
    ->warning()
    ->info();
```

### Footer

The embed footer can contain text as well as an icon.

```php
$this
    ->message('Hello world!')
    ->footerText('Sent by Laracord')
    ->footerUrl('...');
```

### Thumbnail

The thumbnail URL appears as a medium-sized image to the right of the embed.

```php
$this
    ->message('Hello world!')
    ->thumbnailUrl('...');
```

### Image

The image URL appears as a large-sized image inside of the embed.

```php
$this
    ->message('Hello world!')
    ->imageUrl('...');
```

### Timestamp

The timestamp appears at the bottom of the embed and is shown to the user in their local time.

```php
$this
    ->message('Hello world!')
    ->timestamp(now());
```

### Author

The embed author is shown at the top of the embed. By default, Laracord set's the `authorName` and `authorIcon` to the bot's username and avatar.

```php
$this
    ->message('Hello world!')
    ->authorName('Laracord')
    ->authorIcon('...')
    ->authorUrl('...');
```

### Fields

Fields consist of groups of data represented by a label and value. By default, they are inline with Discord showing up to 3 fields per line.

```php
$this
    ->message('Hello world!')
    ->field('Field 1', 'Value 1')
    ->field('Field 2', 'Value 2');
```

To pass a group of fields, you can use the `->fields()` method:

```php
$this
    ->message('Hello world!')
    ->fields([
        'Field 1' => 'Value 1',
        'Field 2' => 'Value 2',
    ]);
```

To prevent a field from being inline, you can pass `inline: false` like so:

```php
$this
    ->message('Hello world!')
    ->field('Field 1', 'Value 1')
    ->field('Field 2', 'Value 2', inline: false);
```

You can also conditionally display a field:

```php
$this
    ->message('Hello world!')
    ->field('Field 1', 'Value 1')
    ->field('Field 2', 'Value 2', hidden: true);
```

### Files

Attaching a file to your message can be done using raw content or by passing a path:

```php
$this
    ->message('Hello world!')
    ->file('Lorem ipsum...', 'lorem.txt');

$this
    ->message('Hello world!')
    ->filePath('path/to/file');
```

### Buttons

Buttons are shown at the bottom of your message and can consist of URL's or interactions. Laracord tries to make both easy to use.

#### Link Button

A button in it's simplest form would be a **link button** and consists of a simple label and URL value:

```php
$this
    ->message('Hello world!')
    ->button('Visit Laracord', 'https://laracord.com');
```

When working with a link button, you also have the option of passing an emoji:

```php
$this
    ->message('Hello world!')
    ->button('Visit Laracord', 'https://laracord.com', emoji: '💻');
```

When using a custom emoji from a server your bot is in, you will have to pass the emoji along with it's internal ID.

> #### Tip
>
> An easy way to obtain this as a string is to escape the emoji in a Discord chat message.
> `\:laracord:` would return `<:laracord:1204740745286656050>` containing the string needed.

Once you obtain the emoji ID, you can then pass it to `emoji` as a string:

```php
$this
    ->message('Hello world!')
    ->button('Visit Laracord', 'https://laracord.com', emoji: ':laracord:1204740745286656050');
```

#### Interactions

Interactions allow you to have the bot respond or perform an action when a button is clicked. This can be achieved by passing an `Interaction` callback as the button's `value` instead of a string:

```php
use Discord\Parts\Interactions\Interaction;

$this
    ->message('Say hello!')
    ->button('Hello', fn (Interaction $interaction) => $interaction->respondWithMessage(
        $this->message('Well hello to you!')->build(),
        ephemeral: true
    ), emoji: '👋');
```

In the example above, we respond to the interaction as well as set `ephemeral` to `true` to ensure the button can only be interacted with a single time.

> #### Note
>
> It is recommended to handle button interactions in commands using Laracord's interaction router. See the [interaction routing](/docs/interactions#content-interaction-routing) documentation to learn more.

When working with buttons that resolve interactions, you also have the option of changing the [button style](https://discord.com/developers/docs/interactions/message-components#button-object-button-styles).

The available options are `primary` (default), `secondary`, `success`, and `danger`:

```php
use Discord\Parts\Interactions\Interaction;

$this
    ->message('Say hello!')
    ->button('Hello', fn (Interaction $interaction) => $this->message('Well hello to you!')->reply($interaction, true), emoji: '👋', style: 'success');
```

### Select Menus

Select menus are typically shown above buttons and have similar functionality sending an interaction when items are selected. Similar to buttons, this interaction can be handled in a callback or using Laracord's [interaction routing](/docs/interactions#content-interaction-routing).

A simple select menu with a few items might look something like this:

```php
$this
    ->message('What kind of fruit do you like?')
    ->select(['Apples', 'Bananas', 'Pineapples']);
```

To add an interaction listener to it, we can either pass a callback as the second parameter the same as shown on buttons above or use Laracord's interaction router (which is recommended):

```php
$this
    ->message('What kind of fruit do you like?')
    ->select([
        'Apples',
        'Oranges',
        'Bananas',
    ], route: 'selectFruit', placeholder: 'Select a fruit...');
```

To get the select value(s) in our `selectFruit` route, we can simple fetch them off of `$interaction->data->values` as an array:

```php
public function interactions(): array
{
    return [
        'selectFruit' => fn (Interaction $interaction) => $interaction->acknowledge() && dump($interaction->data->values),
    ];
}
```

Individual select menu options can be further customized by passing an array of options:

```php
$this
    ->message('What kind of fruit do you like?')
    ->select([
        'apples' => [
            'label' => 'Apples',
            'description' => 'A tasty red fruit.',
            'emoji' => '🍎',
            'default' => true,
        ],
        'oranges' => [
            'label' => 'Oranges',
            'description' => 'A tasty orange fruit.',
            'emoji' => '🍊',
        ],
        'bananas' => [
            'label' => 'Bananas',
            'description' => 'A tasty yellow fruit.',
            'emoji' => '🍌',
        ],
    ], route: 'selectFruit', placeholder: 'Select a fruit...');
```

#### Menu Types

Alongside creating a select menu using an array of options, may also pass one of the built-in types using the `type` property:

```php
$this
    ->message('Pick a select, any select!')
    ->select(type: 'channel', route: 'handleChannel')
    ->select(type: 'mentionable', route: 'handleMentionable')
    ->select(type: 'role', route: 'handleRole')
    ->select(type: 'user', route: 'handleUser');
```

### Body

Set the body of the embed, that send a message before the embed:

```php
$this
    ->message('Hello world!')
    ->body('@everyone');
```