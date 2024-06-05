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

## Message Interaction Persistence

A common use-case for interactions is for a Button. Using a button, your bot can react to clicks with a response such as a message like the above.

While this can generally be done by passing a callback to `->button()` inside of a [`Message`](/docs/messages), you will find that the button will no longer respond to interactions when the bot is restarted.

Laracord provides a solution to this by allowing you to define interaction routes inside of commands and assign buttons to them. Similar to the Laravel router, this also allows you to cleanly pass parameters to your interactions for handling dynamic behavior.

Using the example below, our command will respond with a generic message containing two buttons. We will then map out and handle the interactions inside of the `interactions()` method.

```php
use Discord\Parts\Interactions\Interaction;

/**
 * Handle the command.
 */
public function handle($message, $args)
{
    return $this
        ->message()
        ->title('Hello')
        ->content('Hello world!')
        ->button('👋 Everyone', route: 'wave')
        ->button('👋 Log1x', route: 'wave:log1x')
        ->button('🖐️ Goodbye', route: 'goodbye')
        ->send($message);
}

/**
 * The command interaction routes.
 */
public function interactions(): array
{
    return [
        'wave:{id?}' => fn (Interaction $interaction, string $id = 'Everyone') => $this->message("Hello {$id}!")->reply($interaction, true),
        'goodbye' => fn (Interaction $interaction) => $this->message("Bye for now, {$interaction->member->__toString()}!")->reply($interaction, true),
    ];
}
```

In the above, we are able to make the `id` parameter optional in our `wave` route by suffixing a `?` in the in the key.

With that, our interactions will now be uniquely handled and routed for our command's message automatically.

## Using Modals

A neat feature in Discord is the ability to respond to an interaction using a Modal. This allows the user to input and submit text for it to then get parsed by the bot.

While the usage of this feature comes from DiscordPHP and is not specific to Laracord, using this functionality can often be confusing and thus we will give an example here for good measure.

Below we will show a modal for creating a ticket consisting of a `Title` input and `Description` paragraph.

```php
use Discord\Builders\Components\ActionRow;
use Discord\Builders\Components\TextInput;

$interaction->showModal('Create Ticket', 'createTicket', [
    ActionRow::new()->addComponent(
        TextInput::new('Title', TextInput::STYLE_SHORT, 'title')
            ->setPlaceholder('Enter a title.')
            ->setRequired(true)
    ),

    ActionRow::new()->addComponent(
        TextInput::new('Description', TextInput::STYLE_PARAGRAPH, 'description')
            ->setPlaceholder('Please describe the issue in detail.')
            ->setRequired(true)
    ),
], fn ($interaction, $components) => $this->createTicket($interaction, $components));
```

In the example above, once the modal is submitted, we will be passing the `$interaction` instance and modal `$components` to our `createTicket()` method. From there, we will handle the data and then acknowledge the response.

```php
use App\Models\Ticket;
use Discord\Parts\Interactions\Interaction;

protected function createTicket(Interaction $interaction, $components)
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