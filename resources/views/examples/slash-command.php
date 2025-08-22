<?php

namespace App\SlashCommands;

use Discord\Parts\Interactions\Interaction;
use Laracord\Commands\SlashCommand;

class HelloSlashCommand extends SlashCommand
{
    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'hello';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'A simple hello command.';

    /**
     * The command options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Handle the command.
     */
    public function handle(Interaction $interaction): void
    {
        $this
            ->message('Hello world!')
            ->button('👋', route: 'wave')
            ->reply($interaction, ephemeral: true);
    }

    /**
     * The command interaction routes.
     */
    public function interactions(): array
    {
        return [
            'wave' => fn (Interaction $interaction) => $this->message('👋')->reply($interaction, ephemeral: true),
        ];
    }
}
