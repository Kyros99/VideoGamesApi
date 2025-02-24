<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'genre' => $this->genre,
            'rating' => $this->whenLoaded('rating', fn() => $this->rating->rating ?? null),
            'review' => $this->whenLoaded('review', fn() => $this->review->review ?? null),
        ];
    }

    public function withResponse($request, $response)
    {
        $message = '';

        // Determine message based on HTTP method
        if ($request->isMethod('post')) {
            $message = 'Game successfully created.';
            $response->setStatusCode(201); // Created
        } elseif ($request->isMethod('put') || $request->isMethod('patch')) {
            $message = 'Game successfully updated.';
        } elseif ($request->isMethod('get')) {
            $message = 'Game successfully retrieved.';
        }

        if ($message) {
            $response->setData([
                'status' => 'success',
                'message' => $message,
                'data' => $response->getData()
            ]);
        }
    }
}
