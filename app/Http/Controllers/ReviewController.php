<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Game $game)
    {

        $this->authorize('create', [Review::class, $game]);

        $data = $request->validate([
            'review' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'review' => $data['review'],
        ]);

        return response()->json(['message' => 'Review submitted']);
    }

    public function show(Game $game)
    {

        $this->authorize('view', [Review::class, $game]);

        return response()->json([
            'reviews' => $game->reviews()->with('user:id,name')->latest()->paginate(10),
        ]);
    }
}
