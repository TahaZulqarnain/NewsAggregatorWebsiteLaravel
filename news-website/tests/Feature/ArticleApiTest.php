<?php 

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_articles_index_returns_articles()
    {
        Article::factory()->count(10)->create();

        $response = $this->getJson('/api/articles');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'count',
                'data' => [
                    '*' => [
                        'id', 'title', 'description', 'content','image','url','source','author','category','publishedAt'
                    ]
                ]
            ]);
    }

    public function test_article_show_returns_single_article()
    {
        $article = Article::factory()->create();

        $response = $this->getJson("/api/articles/{$article->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $article->id,
                    'title' => $article->title,
                    'description' => $article->description,
                    'content' => $article->content,
                    'image' => $article->image,
                    'url'   => $article->url,
                    'source' => $article->source,
                    'author' => $article->author,
                    'category' => $article->category,
                    'publishedAt' => $article->published_at,
                ],
            ]);
    }

    public function test_article_show_returns_404_if_not_found()
    {
        $response = $this->getJson("/api/articles/999");

        $response->assertStatus(404);
    }
}
