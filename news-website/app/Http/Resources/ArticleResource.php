<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
           return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'content'     => $this->content,
            'url'         => $this->url,
            'source'      => $this->source,
            'author'      => $this->author,
            'category'    => $this->category,
            'published_at' => isset($item['publishedAt']) 
            ? Carbon::parse($item['publishedAt'])->toDateTimeString()
            : null,
        ];
    }
}
