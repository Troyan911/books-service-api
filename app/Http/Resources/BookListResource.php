<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'authors' => AuthorResource::collection(
                $this->whenLoaded('authors')
            ),
            'publisher' => PublisherResource::make(
                $this->whenLoaded('publisher')
            ),
            'published_year' => optional($this->published_at)?->format('Y'),
        ];
    }
}
