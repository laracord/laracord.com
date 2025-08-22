<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DocsSearch extends Component
{
    /**
     * The search endpoint.
     */
    public string $endpoint = '';

    /**
     * The search placeholder.
     */
    public string $placeholder = 'Search the docs...';

    /**
     * The minimum search length.
     */
    public int $minLength = 3;

    /**
     * The version to search within.
     */
    public string $version = '2.x';

    /**
     * Create a new component instance.
     */
    public function __construct(string $version = '2.x')
    {
        $this->version = $version;
        $this->endpoint = route('api.docs.search');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.docs-search');
    }
}
