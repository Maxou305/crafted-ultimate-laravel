<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        $shop = Shop::with(['user'])->find($id);
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
        $shop = Shop::with(['user'])->where('user_id', $id)->get();
        if ($shop === null) {
            return response()->json(['message' => 'Shop not found'], 404);
        }
        return response()->json($shop, 201);
    }

    /**
     * Store a newly created shop in storage.
     * @param StoreShopRequest $request : The request containing the shop data
     * @return JsonResponse : JSON response with the shop created
     */
    public function store(StoreShopRequest $request): JsonResponse
    {
        $shop = Shop::create(
            array_merge(
                $request->all(),
                ['user_id' => Auth::id()]
            )
        );
        $shop->save();
        return response()->json($shop, 201);
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
        $shop->update($request->all());
        return response()->json(['message' => 'Shop updated'], 201);
    }

    /**
     * Remove the specified shop from storage.
     * @param $id : The id of the shop
     * @return JsonResponse : JSON response with the shop deleted
     */
    public function destroy($id): JsonResponse
    {
        $shop = Shop::find($id);
        if ($shop === null) {
            return response()->json(['message' => 'Shop not found'], 404);
        }
        $shop->delete();
        return response()->json(['message' => 'Shop deleted'], 201);
    }
}
