<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexGameRequest;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexGameRequest $request)
    {

        $this->authorize('index', Game::class);

        $user = auth()->user();

        $query = $user->isAdmin() ? Game::query() : Game::where('user_id', $user->id);

        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        $query->orderBy('release_date', $request->input('sort', 'desc'));

        // Eager load 'rating' and 'review' relationships
        $games = $query->with(['rating', 'review'])->paginate(10);

        // Wrap the result in the GameResource
        return GameResource::collection($games);


    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGameRequest $request)
    {
        $this->authorize('store', Game::class);

        //auth()->user()->games()->create($request->validated());
        $game = Game::create($request->validated() + ['user_id' => auth()->id()]);

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
    public function update(UpdateGameRequest $request, Game $game)
    {

        $this->authorize('update', $game);

        $game->update($request->validated());

        return response()->json($game, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);

        $game->delete();

        return response(status: 204);
    }
}
