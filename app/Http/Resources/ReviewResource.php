<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'review' => $this->review,
            'user' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ];
            }),
            'game' => $this->whenLoaded('game', function () {
                return [
                    'id' => $this->game->id,
                    'title' => $this->game->title,
                ];
            }),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
