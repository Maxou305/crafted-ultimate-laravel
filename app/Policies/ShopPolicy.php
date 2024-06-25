<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class ShopPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Shop $shop): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'user' || 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shop $shop): Response
    {
        return $user->role === 'admin' || $user->id() === $shop->user_id ?
            Response::allow()
            :
            Response::deny('You do not have permission to update this shop');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shop $shop): bool
    {
        return ($user->id === $shop->user_id ) || ($user->role === 'admin');
    }


    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Shop $shop): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Shop $shop): bool
    {
        //
    }
}
