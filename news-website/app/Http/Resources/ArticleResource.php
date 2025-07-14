<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'image'       => $this->image,
            'url'         => $this->url,
            'source'      => $this->source,
            'author'      => $this->author,
            'category'    => $this->category,
            'publishedAt' => isset($this->published_at) 
            ? Carbon::parse($this->published_at)->toDateTimeString()
            : null,
        ];
    }
}
