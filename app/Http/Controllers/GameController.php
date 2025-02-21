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

        //  Simple, clean validation using request->validate()
        $validated = $request->validate([
            'genre' => 'nullable|string|max:50', // Genre must be a string
            'sort_order' => 'nullable|in:asc,desc', // Only 'asc' or 'desc' allowed
            'per_page' => 'nullable|integer|min:1|max:100', // Pagination limit
            'page' => 'nullable|integer|min:1', // Page must be positive
        ]);

        $user = auth()->user();

        // Admins see all games, regular users only see their own
        $query = $user->isAdmin() ? Game::query() : Game::where('user_id', $user->id);

        //  Apply eager loading to prevent N+1 queries
        $query->with(['developer', 'categories', 'reviews']);

        //  Apply filtering
        if (!empty($validated['genre'])) {
            $query->where('genre', $validated['genre']);
        }

        //  Apply sorting (default: newest first)
        $query->orderBy('release_date', $validated['sort_order'] ?? 'desc');

        // Use validated pagination settings
        $games = $query->paginate($validated['per_page'] ?? 10);

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
