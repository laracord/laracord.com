<?php

namespace App\Commands\Middleware;

use Closure;
use Laracord\Commands\Middleware\Context;
use Laracord\Commands\Middleware\Middleware;
use Laracord\Discord\Facades\Message;

class ExampleMiddleware implements Middleware
{
    /**
     * Handle the command.
     *
     * @return mixed
     */
    public function handle(Context $context, Closure $next)
    {
        if ($context->isCommand() && $context->command->getName() === 'ping') {
            Message::content('Not this time!')->reply($context->source);

            return;
        }

        return $next($context);
    }
}
