<?php

namespace App\Livewire\Docs;

use App\Models\Docs;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\Component;

class Show extends Component
{
    /**
     * The page.
     *
     * @var \App\Models\Docs
     */
    public $page;

    /**
     * The version.
     */
    public string $version;

    /**
     * The navigation groups.
     */
    protected array $groups = [
        'Getting Started',
        'Usage',
        'Digging Deeper',
        'Advanced',
        'Examples',
    ];

    /**
     * Mount the component.
     */
    public function mount(string $version, string $page): void
    {
        abort_if(Str::startsWith($page, '_'), 404);
        abort_unless(in_array($version, ['2.x']), 404);

        $this->version = $version;
        $this->page = Docs::where('version', $this->version)
            ->where('slug', $page)
            ->firstOrFail();

        $this->configureSeo();
    }

    /**
     * Configure the SEO.
     */
    private function configureSeo(): void
    {
        seo()
            ->title("{$this->page->title} Docs | Laracord")
            ->canonical(route('docs.show', [
                'version' => $this->version,
                'page' => $this->page->slug,
            ]));

        if ($this->page->description) {
            seo()->description($this->page->description);
        }
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        $docs = Docs::where('version', $this->version)
            ->orderBy('priority')
            ->get();

        $menu = $this->buildNavigationMenu($docs);

        return view('livewire.docs.show', [
            'docs' => $docs,
            'menu' => $menu,
            'version' => $this->version,
        ]);
    }

    /**
     * Build the navigation menu.
     */
    private function buildNavigationMenu($docs): array
    {
        $menu = $docs->groupBy('group')
            ->map(fn ($items) => $items->map(fn ($doc) => [
                'title' => $doc->title,
                'slug' => $doc->slug,
            ]))
            ->toArray();

        return collect($menu)
            ->sortBy(fn ($value, $key) => array_search($key, $this->groups, true))
            ->toArray();
    }
}
