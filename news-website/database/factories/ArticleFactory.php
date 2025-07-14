<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Article;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{

    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->text(200),
            'content' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'url' => $this->faker->unique()->url,
            'source' => 'TestSource',
            'author' => $this->faker->name,
            'category' => 'TestCategory',
            'published_at' => now(),

        ];
    }
}
