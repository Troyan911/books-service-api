<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'title' => $this->title,
            'description' => $this->description,

            'edition' => $this->edition,
            'pages' => $this->pages,

            'format' => $this->format,
            'country' => $this->country,

            'isbn' => $this->isbn,

            'published_at' => $this->published_at,

            'publisher' => PublisherResource::make(
                $this->whenLoaded('publisher')
            ),

            'authors' => AuthorResource::collection(
                $this->whenLoaded('authors')
            ),

            'genres' => GenreResource::collection(
                $this->whenLoaded('genres')
            ),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
