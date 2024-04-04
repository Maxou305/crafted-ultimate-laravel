<?php

namespace App\Http\Controllers;

use App\DTO\ProductDTO;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
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
//        $productList = Product::with(['shop', 'shop.user'])->where('category', $category)->get();
//        if ($productList === null) {
//            return response()->json(['message' => 'Product not found'], 404);
//        }
//        $proid
//        $productListDTO = new ProductDTO($productList);
//        return response()->json($productDTO);
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
    function store(StoreProductRequest $request)
    {
        //
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
    function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) : JsonResponse
    {
        $product = Product::class->find($id);
//        $product = Product::find($id);
        if ($product === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
