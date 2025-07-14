<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Article;
use App\Models\ApiLog;
use Carbon\Carbon;
use App\Services\LogApiCallService;


class NewsApiAiService
{
    public function fetchAndStore(): void
    {

    try{
        /*This API only provide last week data Starts*/
        $query = [
            '$query' => [
                'lang' => 'eng',
                'dateStart' => now()->subDays()->toDateString(),
                'dateEnd' => now()->toDateString(),
            ]
        ];
        /*This API only provide last week data End*/

        $response = Http::get(config('services.newsapiai.baseurl') . '/api/v1/article/getArticles', [
            'query' => json_encode($query),
            'resultType' => 'articles',
            'articlesSortBy' => 'date',
            'includeArticleCategories' => true,
            'apiKey' => config('services.newsapiai.key'),
        ]);

        $articles = $response->json('articles.results');

        foreach ($articles ?? [] as $item) {
             $categories = collect($item['categories'] ?? [])
             ->pluck('label')
             ->implode(', '); 
            Article::updateOrCreate(
                ['url' => $item['url']],
                [
                    'title'        => $item['title'],
                    'description'  => substr($item['body'] ?? '', 0, 255),
                    'content'      => $item['body'] ?? null,
                    'image'        => $item['image'] ?? null,
                    'source'       => $item['source']['title'] ?? null,
                    'author'       => $item['authors'][0]['name'] ?? null,
                    'category'     => $categories ?? null,
                    'published_at' => isset($item['dateTimePub']) ? Carbon::parse($item['dateTimePub'])->toDateTimeString() : null,
                ]
            );
        }
        
        LogApiCallService::success('newsapiai', '/api/v1/article/getArticles', ['language' => 'en']);
    }
    catch (\Throwable $e) {

        LogApiCallService::failure('newsapiai', '/api/v1/article/getArticles', ['language' => 'en'], $e->getMessage());

            Log::error('NewsAPIAI Fetch Failed: ' . $e->getMessage());
    }
}
}