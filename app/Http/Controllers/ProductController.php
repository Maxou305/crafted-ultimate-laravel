<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterProductRequest;
use App\Http\Requests\SortProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display all the products.
     * @return JsonResponse : JSON response with all the products
     */
    public function index(): JsonResponse
    {
        $productList = Product::with(['shop', 'user'])->get();
        return response()->json($productList, 201);
    }

    /**
     * Display a product by id.
     * @param $id : Product id
     * @return JsonResponse : JSON response with the product
     */
    public function getById($id): JsonResponse
    {
        $product = Product::with(['shop', 'shop.user'])->find($id);
        return response()->json($product, 201);
    }

    /**
     * Display all the products.
     * @param string $request : Search request
     * @return JsonResponse : JSON response with all the products
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
        return response()->json($productList, 201);
    }

    /**
     * Display a filtered list of products by id.
     * @param FilterProductRequest $request : Request with the product data
     * @return JsonResponse : JSON response with the product(s)
     */
    public function filter(FilterProductRequest $request): JsonResponse
    {
        $params = $request->input();
        $query = Product::query();
        foreach ($params as $key => $value) {
            $query->where($key, $value);
        }
        return response()->json($query->get(), 201);
    }

    /**
     * Display a sorted list of products by id.
     * @param SortProductRequest $request : Request with the product data
     * @return JsonResponse : JSON response with the product(s)
     */
    public function sort(SortProductRequest $request): JsonResponse
    {
        $params = $request->input();
        $query = Product::query()->orderBy($params['column'], $params['order']);
        return response()->json($query->get(), 201);
    }

    /**
     * Store a newly created product in storage.
     * @param StoreProductRequest $request : Request with the product data
     * @return JsonResponse : JSON response with the product
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->all());
        $product->save();
        return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateProductRequest $request : Request with the product data
     * @param $id : Product id
     * @return JsonResponse : JSON response with the product
     */
    public
    function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json(['message' => 'Product updated'], 201);
    }

    /**
     * Remove the specified product from storage.
     * @param $id : Product id
     * @return JsonResponse : JSON response with a message
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
