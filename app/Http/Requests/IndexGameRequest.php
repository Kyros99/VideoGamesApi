<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'genre' => 'sometimes|string|in:Action,Adventure,RPG,Sports,FPS,Strategy,Puzzle',
            'sort' => 'sometimes|string|in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'genre.in' => 'The genre must be one of the following: Action, Adventure, RPG, Sports, FPS, Strategy, Puzzle.',
            'sort.in' => 'The sorting order must be either asc (ascending) or desc (descending).',
        ];
    }


}
