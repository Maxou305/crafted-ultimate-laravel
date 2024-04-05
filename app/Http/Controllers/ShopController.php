<?php

namespace App\Http\Controllers;

use App\DTO\ShopFullDTO;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shopList = Shop::with(['user'])->get();
        return $shopList->map(function ($shop) {
            return new ShopFullDTO($shop);
        });
//        return Shop::with(['user'])->get();
    }

    /**
     * Display the specified resource.
     */
    public function getById($id)
    {
        $shop = Shop::with(['user'])->find($id);
        if ($shop === null) {
            return response()->json(['message' => 'Shop not found'], 404);
        }
        return $shop;
    }

    /**
     * Display the specified resource.
     */
    public function getByUserId($id){
        $shop = Shop::with(['user'])->where('user_id', $id)->get();
        if ($shop === null){
            return response()->json(['message' => 'Shop not found'], 404);
        }
        return $shop;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) : JsonResponse
    {
        $shop = Shop::find($id);
        if ($shop === null){
            return response()->json(['message' => 'Shop not found'], 404);
        }
        $shop->update($request->all());
        return response()->json(['message' => 'Shop updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $shop = Shop::find($id);
        if ($shop === null){
            return response()->json(['message' => 'Shop not found'], 404);
        }
        $shop->delete();
        return response()->json(['message' => 'Shop deleted']);
    }
}
