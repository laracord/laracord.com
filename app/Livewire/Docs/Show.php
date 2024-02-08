<?php

namespace App\Livewire\Docs;

use App\Models\Docs;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    /**
     * The page.
     *
     * @var string
     */
    public $page;

    /**
     * The navigation groups.
     *
     * @var array
     */
    protected $groups = [
        'Getting Started',
        'Usage',
        'Digging Deeper',
        'Advanced',
        'Examples',
    ];

    /**
     * Mount the component.
     *
     * @return void
     */
    public function mount(string $page)
    {
        abort_if(Str::startsWith($page, '_'), 404);

        $this->page = Docs::findOrFail($page);

        seo()
            ->title("{$this->page->title} Docs | Laracord")
            ->canonical(route('docs.show', $this->page->slug));

        if ($this->page->description) {
            seo()->description($this->page->description);
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $docs = Docs::orderBy('priority')->get();

        $menu = [];

        foreach ($docs as $doc) {
            if (! isset($menu[$doc->group])) {
                $menu[$doc->group] = [];
            }

            $menu[$doc->group][] = [
                'title' => $doc->title,
                'slug' => $doc->slug,
                'sections' => request()->url() === route('docs.show', [$doc->slug])
                    ? collect(explode("\n", $doc->content))
                        ->filter(fn ($line) => Str::startsWith($line, '## '))
                        ->map(fn ($line) => Str::after($line, '## '))
                        ->mapWithKeys(fn ($section) => [$section => Str::slug($section)])
                        ->map(fn ($section) => "#content-{$section}")
                        ->toArray()
                    : [],
            ];
        }

        $menu = collect($menu)
            ->sortBy(fn ($value, $key) => array_search($key, $this->groups))
            ->toArray();

        return view('livewire.docs.show', [
            'docs' => $docs,
            'menu' => $menu,
        ]);
    }
}
