<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $this->authorize('index', Game::class);

        // Get the authenticated user
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Start building the query
        $query = Game::where('user_id', $user->id);

        // Apply genre filter if provided
        if ($request->has('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        // Apply sorting by release date if sort parameter is provided
        if ($request->has('sort_by') && $request->input('sort_by') === 'release_date') {
            $query->orderBy('release_date', $request->input('sort_order', 'asc'));
        }

        // Fetch the filtered and sorted results
        $games = $query->get();

        // Return the games as a JSON response
        return response()->json($games);
    }


        /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('store', Game::class);

        $game = Game::create([
            ...$request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'release_date' => 'required|date|before:tomorrow',
                'genre' => 'required|string|max:50',
                'is_admin' => 'boolean'
            ]),
            'user_id' => auth()->id(),
        ]);

        return response()->json($game, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        // Authorization: Ensure the user can view this specific game
        $this->authorize('show', $game);

        // Return the game as a JSON response
        return response()->json($game, 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {

        $this->authorize('update', $game);

        $game->update(
            $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:1000',
                'release_date' => 'sometimes|date|before:tomorrow',
                'genre' => 'sometimes'
            ])
        );
        return response()->json($game, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $this->authorize('destroy', $game);

        $game->delete();

        return response(status: 204);
    }
}
