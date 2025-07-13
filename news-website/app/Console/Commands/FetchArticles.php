<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\ArticleService;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from APIs and store them locally';

    /**
     * Execute the console command.
     */
    
    public function __construct(protected ArticleService $service) {
        parent::__construct();
    }

    public function handle()
    {
        $this->service->fetchFromAllSources();
        $this->info('Articles fetched from all sources.');
    }
}
