<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // No authorization check
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'genre' => 'required|string|in:Action,Adventure,RPG,Sports,FPS,Strategy,Puzzle',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The game title is required.',
            'title.string' => 'The game title must be a valid string.',
            'title.max' => 'The game title cannot exceed 255 characters.',
            'description.required' => 'The game description is required.',
            'description.string' => 'The game description must be a valid string.',
            'release_date.required' => 'The release date is required.',
            'release_date.date' => 'The release date must be a valid date.',
            'genre.required' => 'The game genre is required.',
            'genre.in' => 'The genre must be one of the following: Action, Adventure, RPG, Sports, FPS, Strategy, Puzzle.',
        ];
    }
}
