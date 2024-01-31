<?php

namespace App\Http\Controllers;

use App\Models\Docs;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    /**
     * Render the sitemap.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lastModified = cache()->rememberForever('docs.lastmod', fn () => now()->toAtomString());

        $pages = [
            'url' => route('home'),
            'lastmod' => $lastModified,
        ];

        $pages = [...[$pages], ...Docs::all()->map(fn ($page) => [
            'url' => $page->url,
            'lastmod' => $lastModified,
        ])];

        return response()
            ->view('sitemap', ['pages' => $pages])
            ->header('Content-Type', 'application/xml');
    }
}
