<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,

            'category' => new CategoryResource($this->whenLoaded('category')),
            'author' => $this->author,
            'isFeatured' => $this->isFeatured,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
