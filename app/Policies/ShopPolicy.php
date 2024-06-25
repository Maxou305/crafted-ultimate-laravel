<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Shop;
use App\Models\User;

class ShopPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): Response
    {
        return $user->role === "user" || "admin" ?
            Response::allow()
            :
            Response::deny('You do not have permission to create a shop');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Shop $shop): Response
    {
        return $user->role === 'admin' || $user->id === $shop->user_id ?
            Response::allow()
            :
            Response::deny('You do not have permission to update this shop');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Shop $shop): Response
    {
        return $user->role === 'admin' || $user->id === $shop->user_id ?
            Response::allow()
            :
            Response::deny('You do not have permission to delete this shop');
    }
}
