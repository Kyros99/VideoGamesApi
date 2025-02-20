<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GamePolicy
{

    /**
     * Determine whether the user can view the models.
     */
    public function show(User $user, Game $game)
    {
        return $user->id === $game->user_id
            ? Response::allow()
            : Response::deny('You do not own this game;');
    }

    /**
     * Determine whether the user can view model.
     */
    public function index(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): Response
    {
        return $user->id === $game->user_id
            ? Response::allow()
            : Response::deny('You do not own this game.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Game $game)
    {

        return $user->isAdmin() || $user->id === $game->user_id
            ? Response::allow()
            : Response::deny('You cannot delete this game.');
    }


}
