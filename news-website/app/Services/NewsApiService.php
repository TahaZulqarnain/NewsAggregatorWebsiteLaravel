<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Article;
use App\Models\ApiLog;
use Carbon\Carbon;


class NewsApiService
{
    public function fetchAndStore(): void
    {
        try {
            $res = Http::get(config('services.newsapi.baseurl') . '/v2/top-headlines', [
                'apiKey' => config('services.newsapi.key'),
                'language' => 'en',
            ]);
            $articles = $res->json('articles');
            foreach ($articles ?? [] as $item) {
                Article::updateOrCreate(
                    ['url' => $item['url']],
                    [
                        'title'       => $item['title'],
                        'description' => substr($item['description'] ?? '', 0, 255),
                        'content'     => $item['content'],
                        'image'       => $item['urlToImage'],
                        'source'      => $item['source']['name'] ?? null,
                        'author'      => $item['author'],
                        'category'    => $item['category'] ?? null,
                        'published_at' => isset($item['publishedAt']) 
                            ? Carbon::parse($item['publishedAt'])->toDateTimeString() 
                            : null,
                    ]
                );
            }
            ApiLog::create([
                'source' => 'newsapi',
                'endpoint' => '/v2/top-headlines',
                'request_payload' => json_encode(['language' => 'en']),
                'response_payload' => json_encode('Success'),
                'success' => true,
            ]);
        }
        catch (\Throwable $e) {
            ApiLog::create([
                'source' => 'newsapi',
                'endpoint' => '/v2/top-headlines',
                'request_payload' => json_encode(['language' => 'en']),
                'success' => false,
                'error_message' => $e->getMessage(),
            ]);

            Log::error('NewsAPI Fetch Failed: ' . $e->getMessage());
        }
    }
}
