<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\SchemaOrg\Schema;

class Home extends Component
{
    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        seo()
            ->title($title = config('app.name').' | Discord Bot Micro-framework')
            ->description($description = 'Create powerful Discord bots using Laravel and DiscordPHP.')
            ->canonical($url = route('home'))
            ->addSchema(
                Schema::webPage()
                    ->name($title)
                    ->description($description)
                    ->url($url)
                    ->author(Schema::organization()->name($title))
            );

        return view('livewire.home');
    }
}
