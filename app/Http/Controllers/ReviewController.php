<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
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

        $review = $game->review()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['review' => $data['review']]
        );

        return new ReviewResource($review);
    }

    public function show(Game $game)
    {

        $this->authorize('view', [Review::class, $game]);

        $rating = $game->review()->with('user:id,name', 'game:id,title')->first();

        return new ReviewResource($rating);
    }
}
