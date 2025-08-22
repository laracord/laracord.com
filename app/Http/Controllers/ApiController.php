<?php

namespace App\Http\Controllers;

use App\Models\Docs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    /**
     * Search the documentation.
     */
    public function searchDocs(): JsonResponse
    {
        $request = request();
        $query = e($request->query('query', ''));
        $version = $request->query('version', '2.x');

        return match (true) {
            empty($query) => response()->json(['error' => 'No query specified.'], 400),
            strlen($query) < 3 => response()->json(['error' => 'Search query must be at least 3 characters.'], 400),
            default => $this->performSearch(strtolower($query), $version)
        };
    }

    /**
     * Perform the actual search operation.
     */
    private function performSearch(string $query, string $version): JsonResponse
    {
        $pages = Docs::where('version', $version)
            ->get()
            ->map(fn ($page) => $this->scorePageRelevance($page, $query))
            ->filter(fn ($page) => $page->relevanceScore > 0)
            ->sortByDesc('relevanceScore');

        if ($pages->isEmpty()) {
            return response()->json(['error' => 'No results found.'], 404);
        }

        $results = $pages
            ->take(8)
            ->map(fn ($page) => $this->formatSearchResult($page, $query))
            ->values();

        return response()->json([
            'total' => $pages->count(),
            'count' => $results->count(),
            'results' => $results,
            'version' => $version,
        ]);
    }

    /**
     * Score a page's relevance to the search query.
     */
    private function scorePageRelevance($page, string $query)
    {
        $titleScore = $this->calculateRelevanceScore($query, strtolower($page->title), 3.0);
        $contentScore = $this->calculateRelevanceScore($query, strtolower($page->content), 1.0);

        $page->relevanceScore = $titleScore + $contentScore;

        return $page;
    }

    /**
     * Format a page into a search result.
     */
    private function formatSearchResult($page, string $query): array
    {
        $content = strip_tags(Str::markdown($page->content));

        return [
            'title' => $this->highlightText($page->title, $query),
            'slug' => $page->slug,
            'content' => $this->getBestExcerpt($query, $content, $page->title),
            'url' => $page->url,
            'group' => $page->group,
            'relevance' => round($page->relevanceScore, 2),
        ];
    }

    /**
     * Highlight an excerpt that contains the search query inside of the content.
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

    /**
     * Calculate relevance score for search terms.
     */
    protected function calculateRelevanceScore(string $query, string $text, float $weight = 1.0): float
    {
        $score = 0;
        $queryWords = explode(' ', $query);

        foreach ($queryWords as $word) {
            if (strlen($word) < 2) {
                continue;
            }

            // Exact matches get higher scores
            if (stripos($text, $word) !== false) {
                $exactMatches = substr_count(strtolower($text), strtolower($word));
                $score += $exactMatches * $weight;

                // Bonus for exact phrase matches
                if (stripos($text, $query) !== false) {
                    $score += 2 * $weight;
                }

                // Bonus for word boundaries (whole word matches)
                if (preg_match('/\b'.preg_quote($word, '/').'\b/i', $text)) {
                    $score += 0.5 * $weight;
                }
            }
        }

        return $score;
    }

    /**
     * Highlight search terms in text.
     */
    protected function highlightText(string $text, string $query): string
    {
        $queryWords = explode(' ', $query);

        foreach ($queryWords as $word) {
            if (strlen($word) < 2) {
                continue;
            }

            $word = preg_quote($word, '/');
            $text = preg_replace("/({$word})/i", "<span class='font-semibold text-primary-500'>$1</span>", $text);
        }

        return $text;
    }

    /**
     * Get the best excerpt for search results.
     */
    private function getBestExcerpt(string $query, string $content, string $title): string
    {
        $queryWords = array_filter(
            explode(' ', strtolower($query)),
            fn (string $word) => strlen($word) >= 2
        );

        $sentences = array_filter(
            preg_split('/[.!?]+/', $content, -1, PREG_SPLIT_NO_EMPTY),
            fn (string $sentence) => strlen(trim($sentence)) >= 20
        );

        $scoredSentences = collect($sentences)
            ->map(fn (string $sentence) => $this->scoreSentence(trim($sentence), $queryWords))
            ->filter(fn (array $scored) => $scored['score'] > 0)
            ->sortByDesc('score')
            ->sortBy('position');

        return $scoredSentences->isNotEmpty()
            ? $this->formatExcerpt($scoredSentences->first()['sentence'], $query)
            : $this->getFallbackExcerpt($query, $content, $queryWords);
    }

    /**
     * Score a sentence based on query word matches.
     */
    private function scoreSentence(string $sentence, array $queryWords): array
    {
        $lowerSentence = strtolower($sentence);
        $wordMatches = collect($queryWords)
            ->filter(fn (string $word) => str_contains($lowerSentence, $word))
            ->count();

        return [
            'sentence' => $sentence,
            'score' => $wordMatches,
            'position' => stripos($lowerSentence, $queryWords[0] ?? '') ?: PHP_INT_MAX,
        ];
    }

    /**
     * Format an excerpt with highlighting and length limits.
     */
    private function formatExcerpt(string $excerpt, string $query): string
    {
        if (strlen($excerpt) > 120) {
            $excerpt = Str::limit($excerpt, 120);
        }

        return $this->highlightText($excerpt, $query);
    }

    /**
     * Get a fallback excerpt when no good sentences are found.
     */
    private function getFallbackExcerpt(string $query, string $content, array $queryWords): string
    {
        $firstWord = $queryWords[0] ?? '';

        if (empty($firstWord)) {
            return Str::limit($content, 100);
        }

        $position = stripos($content, $firstWord);

        if ($position === false) {
            return Str::limit($content, 100);
        }

        $start = max(0, $position - 30);
        $excerpt = substr($content, $start, 120);
        $excerpt = trim($excerpt);

        $excerpt = match (true) {
            $start > 0 && strlen($content) > $start + 120 => "...{$excerpt}...",
            $start > 0 => "...{$excerpt}",
            strlen($content) > $start + 120 => "{$excerpt}...",
            default => $excerpt,
        };

        return $this->highlightText($excerpt, $query);
    }
}
