<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Article;
use App\Models\ApiLog;
use Carbon\Carbon;


class NYTimesService
{
   public function fetchAndStore(): void
    {
        try{
            $res = Http::get(config('services.nytimes.baseurl') . '/svc/search/v2/articlesearch.json', [
                'api-key' => config('services.nytimes.key'),
            ]);

            $articles = $res->json('response.docs');

            foreach ($articles as $item) {
                Article::updateOrCreate(
                    ['url' => $item['web_url']],
                    [
                        'title'        => $item['headline']['main'] ?? null,
                        'description'  => substr($item['abstract'] ?? '', 0, 255),
                        'content'      => $item['lead_paragraph'] ?? null,
                        'image'        => $item['multimedia'][0]['default']['url'] ?? null,
                        'source'       => $item['source'],
                        'author'       => $item['byline']['original'] ?? null,
                        'category'     => $item['section_name'] ?? null,
                        'published_at' => isset($item['pub_date']) 
                            ? Carbon::parse($item['pub_date'])->toDateTimeString()
                            : null,
                    ]
                );
            }
            
            LogApiCallService::success('nytimes', '/svc/search/v2/articlesearch.json', ['language' => 'en']);

        }
        catch (\Throwable $e) {

            LogApiCallService::failure('nytimes', '/svc/search/v2/articlesearch.json', ['language' => 'en'], $e->getMessage());

            Log::error('NewsAPI Fetch Failed: ' . $e->getMessage());
        }
       
    }
}
