<?php 

namespace App\Services;

class ArticleService
{
    public function __construct(
        protected NewsApiService $newsApi,
        protected NYTimesService $nyTimes,
        protected NewsApiAiService $newsApiAi
    ) {}

    public function fetchFromAllSources(): void
    {
        $this->newsApi->fetchAndStore();
        $this->nyTimes->fetchAndStore();
        $this->newsApiAi->fetchAndStore();
    }

    public function getFilteredArticles(array $filters, int $perPage = 10)
    {
        $query = \App\Models\Article::query();

        if ($filters['search'] ?? false) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                  ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        if ($filters['source'] ?? false) $query->where('source', $filters['source']);
        if ($filters['author'] ?? false) $query->where('author', $filters['author']);
        if ($filters['category'] ?? false) $query->where('category', $filters['category']);
        if ($filters['from'] ?? false && $filters['to'] ?? false)
            $query->whereBetween('published_at', [$filters['from'], $filters['to']]);

        return $query->latest()->paginate($perPage);
    }
}
