<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $game = Game::create([
            ...$request->validate([
                'title' => 'required',
                'description' => 'required',
                'release_date' => 'required|date',
                'genre' => 'required',
            ]),
            'user_id' => 1,
        ]);

        return response()->json($game, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Game $game)
    {
        $game->update(
            $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'string',
                'release_date' => 'sometimes|date',
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
        $game->delete();

        return response(status: 204);
    }
}
