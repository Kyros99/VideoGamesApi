<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // No authorization check
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'release_date' => 'sometimes|date',
            'genre' => 'sometimes|string|in:Action,Adventure,RPG,Sports,FPS,Strategy,Puzzle',
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'The game title must be a valid string.',
            'title.max' => 'The game title cannot exceed 255 characters.',
            'description.string' => 'The game description must be a valid string.',
            'release_date.date' => 'The release date must be a valid date.',
            'genre.string' => 'The genre must be a valid string.',
            'genre.in' => 'The genre must be one of the following: Action, Adventure, RPG, Sports, FPS, Strategy, Puzzle',
        ];
    }
}
