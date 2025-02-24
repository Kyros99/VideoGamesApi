<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GamePolicy
{

    public function viewAny(User $user): Response
    {
        return Response::allow();
    }
    /**
     * Determine whether the user can view the models.
     */
    public function view(User $user, Game $game)
    {
        //Game can be seen only if the user owns it
        return $user->id === $game->user_id
            ? Response::allow()
            : Response::deny('You do not own this game');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Game $game): Response
    {
        //Game can be updated only if the user owns it
        return $user->id === $game->user_id
            ? Response::allow()
            : Response::deny('You do not own this game.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Game $game): Response
    {
        //Game can be deleted only if the user owns it or he is an admin
        return $user->isAdmin() || $user->id === $game->user_id
            ? Response::allow()
            : Response::deny('You cannot delete this game.');
    }

    public function create(User $user): Response
    {
        return Response::allow();
    }



}
