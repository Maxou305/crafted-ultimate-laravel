<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyShopRequest;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ShopController extends Controller
{
    /**
     * Display all the shops.
     * @return JsonResponse : JSON response with the list of shops
     */
    public function index(): JsonResponse
    {
        $shopList = Shop::with(['user'])->get();
        return response()->json($shopList, 201);
    }

    /**
     * Display the specified shop.
     * @param $id : The id of the shop
     * @return JsonResponse : JSON response with the shop
     */
    public function getById($id): JsonResponse
    {
        $shop = Shop::with(['user', 'products'])->find($id);
        if ($shop === null) {
            return response()->json(['message' => 'Shop not found'], 404);
        }
        return response()->json($shop, 201);
    }

    /**
     * Display the specified shop.
     * @param $id : The id of the user
     * @return JsonResponse : JSON response with the shop
     */
    public function getByUserId($id): JsonResponse
    {
        $shop = Shop::where('user_id', $id)->with('products')->first();
        if ($shop === null) {
            return response()->json(['message' => 'Shop not found'], 404);
        }
        $shop->makeHidden(['user_id', 'created_at', 'updated_at']);
        return response()->json($shop, 201);
    }

    /**
     * Store a newly created shop in storage.
     * @param StoreShopRequest $request : The request containing the shop data
     * @return JsonResponse : JSON response with the shop created
     */
    public function store(StoreShopRequest $request): JsonResponse
    {
        $response = Gate::inspect('store', Shop::class);

        if($response->allowed()) {
            $shop = Shop::create($request->all());
            $shop->save();
            return response()->json($shop, 201);
        } else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Update the specified shop in storage.
     * @param UpdateShopRequest $request : The request containing the shop data
     * @param $id : The id of the shop
     * @return JsonResponse : JSON response with the shop updated
     */
    public function update(UpdateShopRequest $request, $id): JsonResponse
    {
        $shop = Shop::find($id);

        $response = Gate::inspect('update', $shop);

        if($response->allowed()) {
            $shop->update($request->all());
            return response()->json(['message' => 'Shop updated']);
        } else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Remove the specified shop from storage.
     * @param DestroyShopRequest $request : The request containing the shop data
     * @param $id : The id of the shop
     * @return JsonResponse : JSON response with the shop deleted
     */
    public function destroy(DestroyShopRequest $request, $id): JsonResponse
    {
        $request->validated();
        $shop = Shop::find($id);

        $response = Gate::inspect('delete', $shop);

        if($response->allowed()) {
            $shop->delete();
            return response()->json(['message' => 'Shop deleted']);
        } else {
            return response()->json(['message' => $response->message()], 403);
        }
    }
}
