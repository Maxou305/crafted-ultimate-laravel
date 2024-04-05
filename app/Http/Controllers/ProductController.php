<?php

namespace App\Http\Controllers;

use App\DTO\ProductDTO;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productList = Product::with(['shop', 'shop.user'])->get();
        return $productList->map(function ($product) {
            return new ProductDTO($product);
        });
    }

    /**
     * Display a product by id.
     */
    public function getById($id)
    {
        $product = Product::with(['shop', 'shop.user'])->find($id);
        if ($product === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $productDTO = new ProductDTO($product);
        return response()->json($productDTO);
    }


    /**
     * Display a product by id.
     */
    public function getByCategory($category)
    {
        $productList = Product::with(['shop', 'shop.user'])->where('category', $category)->get();
        if ($productList === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $productList->map(function ($product) {
            return new ProductDTO($product);
        });
        if ($productList->count() === 1){
            return response()->json($productList->first());
        }
        return response()->json($productList);
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
    public
    function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'shop_id' => 'required'
        ]);
        $product = Product::create($request->all());
        $product->save();
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public
    function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $product = Product::find($id);
        if ($product === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
