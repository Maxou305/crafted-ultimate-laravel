<?php

namespace App\Http\Controllers;

use App\DTO\ShopFullDTO;
use App\Models\Shop;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display all the shops.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $shopList = Shop::with(['user'])->get();
        $shopList->map(function ($shop) {
            return new ShopFullDTO($shop);
        });
        return response()->json($shopList, 201);
    }

    /**
     * Display the specified shop.
     * @param $id
     * @return JsonResponse
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
     * @param $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'user_id' => 'required',
            'biography' => 'required',
            'theme' => 'required',
            'logo' => 'required',
        ]);
        $shop = Shop::create($request->all());
        $shop->save();
        return response()->json($shop, 201);
    }

    /**
     * Update the specified shop in storage.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $shop = Shop::find($id);
        if ($shop === null) {
            return response()->json(['message' => 'Shop not found'], 404);
        }
        $shop->update($request->all());
        return response()->json(['message' => 'Shop updated'], 201);
    }

    /**
     * Remove the specified shop from storage.
     * @param $id
     * @return JsonResponse
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
