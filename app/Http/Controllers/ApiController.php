<?php

namespace App\Http\Controllers;

use App\Models\Docs;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    /**
     * Search the documentation.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchDocs()
    {
        $query = request()->query('query', '');
        $query = e($query);

        if (! $query) {
            return response()->json([
                'error' => 'No query specified.',
            ], 400);
        }

        if (strlen($query) < 3) {
            return response()->json([
                'error' => 'Search query must be at least 3 characters.',
            ], 400);
        }

        $query = strtolower($query);

        $pages = Docs::all()->filter(function ($page) use ($query) {
            return Str::contains(strtolower($page->title), $query)
                || Str::contains(strtolower($page->content), $query);
        });

        if (! $pages) {
            return response()->json([
                'error' => 'No results found.',
            ], 404);
        }

        $results = $pages->take(5)->map(function ($page) use ($query) {
            $content = strip_tags(Str::markdown($page->content));
            $content = $this->highlightContent($query, $content);

            if (! $content) {
                return;
            }

            return [
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $content,
                'url' => $page->url,
            ];
        })->filter();

        return response()->json([
            'total' => $results->count() > 0 ? $pages->count() : 0,
            'count' => $results->count(),
            'results' => $results,
        ]);
    }

    /**
     * Highlight an excerpt that contains the search query inside of the content.
     *
     * @return string|null
     */
    protected function highlightContent(string $query, string $content)
    {
        $content = strip_tags(Str::markdown($content));
        $position = stripos($content, $query);

        if ($position === false) {
            return;
        }

        $start = max($position - 25, 0);
        $end = min($position + 50, strlen($content));

        $excerpt = Str::of($content)
            ->before("\n")
            ->substr($start, $end - $start)
            ->trim()
            ->__toString();

        if (! $excerpt) {
            return;
        }

        $query = preg_quote($query, '/');
        $excerpt = preg_replace("/({$query})/i", "<span class='font-semibold text-primary-500'>$1</span>", $excerpt);

        $excerpt = Str::of($excerpt)
            ->start('...')
            ->finish('...')
            ->__toString();

        return $excerpt;
    }
}
