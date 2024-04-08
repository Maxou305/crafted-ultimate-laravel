<?php

namespace App\Http\Controllers;

use App\DTO\ProductDTO;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use function PHPUnit\Framework\isEmpty;

class ProductController extends Controller
{
    /**
     * Display all the products.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $productList = Product::with(['shop', 'shop.user'])->get();
        $productList->map(function ($product) {
            return new ProductDTO($product);
        });
        return response()->json($productList, 201);
    }

    /**
     * Display a product by id.
     * @param $id
     * @return JsonResponse
     */
    public function getById($id): JsonResponse
    {
        $product = Product::with(['shop', 'shop.user'])->find($id);
        if ($product === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $productDTO = new ProductDTO($product);
        return response()->json($productDTO, 201);
    }

    /**
     * Display all the products.
     * @param string $request
     * @return JsonResponse
     */
    public function search(string $request): JsonResponse
    {
        $productList = Product::with(['shop', 'shop.user'])
            ->where('name', 'like', '%' . $request . '%')
            ->orWhere('description', 'like', '%' . $request . '%')
            ->orWhere('story', 'like', '%' . $request . '%')
            ->orWhere('color', 'like', '%' . $request . '%')
            ->orWhere('category', 'like', '%' . $request . '%')
            ->orWhere('material', 'like', '%' . $request . '%')
            ->get();
        if ($productList->isEmpty()) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $productList->map(function ($product) {
            return new ProductDTO($product);
        });
        return response()->json($productList, 201);
    }

    /**
     * Display a product by id.
     * @param string $category
     * @return JsonResponse
     */
    public function getByCategory(string $category): JsonResponse
    {
        $productList = Product::with(['shop', 'shop.user'])->where('category', $category)->get();
        if ($productList === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $productList->map(function ($product) {
            return new ProductDTO($product);
        });
        if ($productList->count() === 1) {
            return response()->json($productList->first());
        }
        return response()->json($productList, 201);
    }

    /**
     * Store a newly created product in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
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
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public
    function update(Request $request, $id): JsonResponse
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated'], 201);
    }

    /**
     * Remove the specified product from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $product = Product::find($id);
        if ($product === null) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted'], 201);
    }
}
