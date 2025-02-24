<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexGameRequest;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;


class GameController extends Controller
{
    /**
     * Authorize each user action
     */
    public function __construct()
    {
        $this->authorizeResource(Game::class, 'game');
    }

    /**
     * Display a listing of the games the user has
     */
    public function index(IndexGameRequest $request)
    {
        //Get User
        $user = auth()->user();

        //Get the games the user owns,if he is an admin it gets every single one
        $query = $user->isAdmin() ? Game::query() : Game::where('user_id', $user->id);

        //If genre is provided,filter results based on it
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        //Order results in desc or asc order based on release fate,default is desc
        $query->orderBy('release_date', $request->input('sort', 'desc'));

        // Eager load 'rating' and 'review' relationships along with pagination
        $games = $query->with(['rating', 'review']);

        return GameResource::collection($games->paginate());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        $newGame = auth()->user()->games()->create($request->validated());

        return new GameResource($newGame);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        // Eager load 'review' and 'rating' relationships
        $game->load(['review', 'rating']);

        return new GameResource($game);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        $game->update($request->validated());

        return new GameResource($game);
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
