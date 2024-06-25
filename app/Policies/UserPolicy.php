<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->role === 'admin' ?
            Response::allow()
            :
            Response::deny('You are not an admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return $user->role === 'admin' || $user->id === $model->id ?
            Response::allow()
            :
            Response::deny('You are not an admin or the user owner');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        return $user->role === 'admin' || $user->id === $model->id ?
            Response::allow()
            :
            Response::deny('You are not an admin or the user owner');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): Response
    {
        return $user->role === 'admin' || $user->id === $model->id ?
            Response::allow()
            :
            Response::deny('You are not an admin or the user owner');
    }
}
