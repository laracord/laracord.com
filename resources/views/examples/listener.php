<?php

namespace App\Events;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event as Events;
use Illuminate\Support\Str;
use Laracord\Events\Event;

class MessageListener extends Event
{
    /**
     * The event handler.
     *
     * @var string
     */
    protected $handler = Events::MESSAGE_CREATE;

    /**
     * Handle the event.
     */
    public function handle(Message $message, Discord $discord): void
    {
        if (! Str::contains($message->content, 'laracord', ignoreCase: true)) {
            return;
        }

        $message->react('❤️');
    }
}
