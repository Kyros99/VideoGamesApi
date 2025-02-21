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

        $user = auth()->user();

        // Users see only their own games, admins see all
        $query = $user->isAdmin() ? Game::query() : Game::where('user_id', $user->id);

        // 🎯 Filter by genre
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // 🎯 Sort by release date (default: newest first)
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy('release_date', $sortOrder);

        // 🎯 Get page size from request (default: 10 per page)
        $perPage = $request->input('per_page', 10);

        // 🎯 Paginate results
        $games = $query->paginate($perPage);

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
