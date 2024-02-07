---
slug: chatgpt
title: 'ChatGPT Example'
description: 'Easily create a Discord bot that interacts with ChatGPT using Laracord.'
priority: 1
group: Examples
---

Creating a Discord command to interact with OpenAI's API is quite easy thanks to the official [OpenAI PHP package](https://github.com/openai-php/client).

> #### Note
>
> We are unable to use `openai-php/laravel` due to it requiring `laravel/framework` as a dependency which conflicts with Laracord.

In this example, we will create a simple `!chat` command to ask ChatGPT questions through the Discord bot.

## Requirements

Before we get started, make sure you have an [OpenAI API Key](https://platform.openai.com/api-keys) on hand.

Once you have your API key, install the OpenAI Client package using Composer:

```sh
$ composer require openai-php/client
```

and then add your API key to `.env`:

```env
OPENAI_API_KEY=sk-...
```

## Creating the Command

Once the OpenAI package is installed and configured, you can use the `laracord` binary to create your initial chat command:

```sh
$ php laracord make:command Chat
```

## Code Example

I won't bore you with a breakdown of the code, but it achieves the following goals:

- Initializes the OpenAI client using the provided key in **.env**.
- Requires an argument (message) to be passed.
- Trims incoming messages to 384 characters to prevent abuse.
- Caches the ongoing conversation for 1 minute.

Here's how it is done:

```php
<?php

namespace App\Commands;

use Laracord\Commands\Command;
use OpenAI;

class Chat extends Command
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'chat';

    /**
     * The command description.
     *
     * @var string|null
     */
    protected $description = 'Chat with the bot';

    /**
     * The command usage.
     *
     * @var string
     */
    protected $usage = '<message>';

    /**
     * The OpenAI API key.
     *
     * @var string
     */
    protected $apiKey = '';

    /**
     * The OpenAI client instance.
     *
     * @var \OpenAI\Client
     */
    protected $client;

    /**
     * The OpenAI API key.
     */
    protected string $apiKey = '';

    /**
     * The OpenAI system prompt.
     */
    protected string $prompt = 'You only reply with 1-2 sentences at a time as if responding to a chat message.';

    /**
     * Handle the command.
     *
     * @param  \Discord\Parts\Channel\Message  $message
     * @param  array  $args
     * @return mixed
     */
    public function handle($message, $args)
    {
        if (! $args) {
            return $this
                ->message('You must provide a message.')
                ->title('Chat')
                ->error()
                ->send($message);
        }

        $message->channel->broadcastTyping()->done(function () use ($message, $args) {
            $question = trim(
                implode(' ', $args)
            );

            $question = Str::limit($question, 384);

            $key = "{$message->channel->id}.chat.responses";

            $messages = cache()->get($key, [['role' => 'system', 'content' => $this->prompt]]);
            $messages[] = ['role' => 'user', 'content' => $question];

            $result = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ]);

            $messages[] = ['role' => 'assistant', 'content' => $result->choices[0]->message->content];

            cache()->put($key, $messages, now()->addMinutes(1));

            return $this
                ->message($response)
                ->send($message);
        });
    }

    /**
     * Execute the Discord command.
     *
     * @param  \Discord\Parts\Channel\Message  $message
     * @param  array  $args
     * @return mixed
     */
    public function handle($message, $args)
    {
        $input = trim(
            implode(' ', $args ?? [])
        );

        if (! $input) {
            return $this
                ->message('You must provide a message.')
                ->title('Chat')
                ->error()
                ->send($message);
        }

        $message->channel->broadcastTyping()->done(function () use ($message, $input) {
            $key = "{$message->channel->id}.chat.responses";
            $input = Str::limit($input, 384);

            $messages = cache()->get($key, [['role' => 'system', 'content' => $this->prompt]]);
            $messages[] = ['role' => 'user', 'content' => $input];

            $result = $this->client()->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
            ]);

            $response = $result->choices[0]->message->content;

            $messages[] = ['role' => 'assistant', 'content' => $response];

            cache()->put($key, $messages, now()->addMinute());

            return $this
                ->message($response)
                ->send($message);
        });
    }

    /**
     * Retrieve the OpenAPI client instance.
     *
     * @return \OpenAI\Client
     */
    protected function client()
    {
        if ($this->client) {
            return $this->client;
        }

        return $this->client = OpenAI::client($this->apiKey());
    }

    /**
     * Retrieve the OpenAPI API key.
     *
     * @return string
     */
    protected function apiKey()
    {
        if ($this->apiKey) {
            return $this->apiKey;
        }

        return $this->apiKey = env('OPENAI_API_KEY', $this->apiKey);
    }
}
```
