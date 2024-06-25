<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function store(User $user, Shop $shop): Response
    {
        return $user->id === $shop->user_id ?
            Response::allow()
            :
            Response::deny('You do not have permission to create a product');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Product $product): Response
    {
        return $user->id === $product->shop->user_id || $user->role === "admin"?
            Response::allow()
            :
            Response::deny('You do not have permission to update this product');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Product $product): Response
    {
        return $user->id === $product->shop->user_id || $user->role === "admin"?
            Response::allow()
            :
            Response::deny('You do not have permission to delete this product');
    }
}
