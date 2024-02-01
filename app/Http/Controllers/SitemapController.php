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
        $lastModified = cache()->rememberForever('deployed_at', fn () => now());

        $pages = [
            'url' => route('home'),
            'lastmod' => $lastModified->toAtomString(),
        ];

        $pages = [...[$pages], ...Docs::all()->map(fn ($page) => [
            'url' => $page->url,
            'lastmod' => $lastModified->toAtomString(),
        ])];

        return response()
            ->view('sitemap', ['pages' => $pages])
            ->header('Content-Type', 'application/xml');
    }
}
