---
slug: interactions
title: 'Interactions'
description: 'Easily handle interactions in your Discord messages and commands.'
priority: 2
group: 'Digging Deeper'
---

An interaction takes place when your application recieves an application (slash) command or a user interacts with a message component such as a Button.

This documentation will cover common scenarios such as handling an interaction, persisting a button interaction on restart, and using action groups.

## Handling Interactions

When the bot receives an interaction, Discord will expect it to be acknowledged and handled within a timely manner.

Generally, this can simply be done by responding to the interaction using the `message()` method:

```php
$this->message('Hello to you!')->reply($interaction, ephemeral: true);
```

This can alternatively be done using the `Interaction` instance directly:

```php
$interaction->respondWithMessage(
    $this->message('Hello to you!')->build(),
    ephemeral: true
);
```

When responding to an interaction that will take longer than 3 seconds to respond to, it is recommended to acknowledge the interaction immediately before asynchronously handling your task:

```php
$interaction
    ->acknowledge()
    ->then(fn ($interaction) => $this->handleLongTask($interaction));
```

## Interaction Routing

When using buttons and select menus, Laracord provides a persistent, easy to use interaction router that gives a Laravel-like feel to handling responses.

In the example below, we will pass a route to a few buttons and a select menu and then handle the responses in the router.

```php
use Discord\Parts\Interactions\Interaction;

/**
 * Handle the command.
 */
public function handle($message, $args)
{
    return $this
        ->message('Try out some interactions below.')
        ->title('Interaction Example')
        ->button('👋 Hello', route: 'wave:hello')
        ->button('👋 Goodbye', route: 'wave:goodbye')
        ->select([
            'Apples',
            'Bananas',
            'Oranges',
        ], route: 'fruit', placeholder: 'Select a fruit...');
        ->send($message);
}

/**
 * The command interaction routes.
 */
public function interactions(): array
{
    return [
        'wave:{type}' => fn (Interaction $interaction, string $type) =>
            $this
                ->message("You clicked {$type}.")
                ->reply($interaction, ephemeral: true),

        'fruit' => fn (Interaction $interaction) =>
            $this
                ->message("You selected {$interaction->data->values[0]}.")
                ->reply($interaction, ephemeral: true),
    ];
}
```

## Using Modals

A neat feature in Discord is the ability to respond to an interaction using a Modal. This allows the user to input and submit text for it to then get parsed by the bot.

Below we will show a modal for creating a ticket consisting of a `Title` text input and `Description` paragraph.

```php
$this
    ->modal('Create Ticket')
    ->text('Title', placeholder: 'Enter a title.', minLength: 2, maxLength: 32, required: true)
    ->paragraph('Description', placeholder: 'Please describe the issue in detail.', minLength: 5, maxLength: 256, required: true)
    ->submit(fn ($interaction, $components) => $this->createTicket($interaction, $components))
    ->show($interaction);
```

> #### Tip
>
> If you need to show a modal outside of a command, you can use the `HasModal` trait but it will still require an `$interaction`.

In the example above, once the modal is submitted, we will be passing the `$interaction` instance and modal `$components` to our `createTicket()` method. From there, we will handle the data and then acknowledge the response.

```php
use App\Models\Ticket;
use Discord\Helpers\Collection;
use Discord\Parts\Interactions\Interaction;

protected function createTicket(Interaction $interaction, Collection $components)
{
    $title = $components->get('custom_id', 'title')->value;
    $description = $components->get('custom_id', 'description')->value;

    $ticket = Ticket::create([
        'title' => $title,
        'description' => $description,
    ]);

    return $this->message("Your ticket with ID {$ticket->id} has been created.")->reply($interaction, ephemeral: true);
}
```
