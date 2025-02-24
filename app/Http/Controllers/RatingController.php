<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Game;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, Game $game)
    {

        $this->authorize('create', [Rating::class, $game]);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = $game->rating()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $data['rating']]
        );

        return new RatingResource($rating);
    }

    public function show(Game $game)
    {

        $this->authorize('view', [Rating::class, $game]);

        $rating = $game->rating()->with('user:id,name', 'game:id,title')->first();

        return new RatingResource($rating);


    }
}

