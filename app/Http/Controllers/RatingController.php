<?php

namespace App\Http\Controllers;

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

        Rating::updateOrCreate(
            ['user_id' => auth()->id(), 'game_id' => $game->id],
            ['rating' => $data['rating']]
        );

        return response()->json(['message' => 'Rating submitted']);
    }

    public function show(Game $game)
    {

        $this->authorize('view', [Rating::class, $game]);

        return response()->json([
            'rating' => $game->rating()->with('user:id,name')->first(),
        ]);


    }
}

