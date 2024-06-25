<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyProductRequest;
use App\Http\Requests\FilterProductRequest;
use App\Http\Requests\SortProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * Display all the products.
     * @return JsonResponse : JSON response with all the products
     */
    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Get list of all products",
     *     description="Returns list of products",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $productList = Product::with('user')->get();
        return response()->json($productList);
    }

    /**
     * Display a product by id.
     * @param $id : Product id
     * @return JsonResponse : JSON response with the product
     */
    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     summary="Get a product by id",
     *     description="Returns a product",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Product not found"
     *    ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID of the product",
     *          required=true,
     *     ),
     * )
     */
    public function getById($id): JsonResponse
    {
        $product = Product::find($id);
        return response()->json($product);
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
    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Create a product",
     *     description="Create a product",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Product data",
     *         @OA\JsonContent(
     *             required={"name", "description", "story", "price", "stock", "image", "category"},
     *             @OA\Property(property="name", type="string", example="Product name"),
     *             @OA\Property(property="description", type="string", example="Product description"),
     *             @OA\Property(property="story", type="string", example="Product story"),
     *             @OA\Property(property="price", type="number", format="float", example=10.99),
     *             @OA\Property(property="stock", type="integer", example=10),
     *             @OA\Property(property="image", type="string", example="Product image"),
     *             @OA\Property(property="category", type="string", example="Product category"),
     *             @OA\Property(property="color", type="string", example="Product color"),
     *             @OA\Property(property="material", type="string", example="Product material"),
     *             @OA\Property(property="size", type="string", example="Product size")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $shopId = Shop::where('user_id', Auth::id())->first()->id;
        $product = Product::create(
            array_merge(
                $request->all(),
                ['shop_id' => $shopId]
            ));
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
     * @param DestroyProductRequest $request : Request with the product data
     * @param $id : Product id
     * @return JsonResponse : JSON response with a message
     */
    public function destroy(DestroyProductRequest $request, $id): JsonResponse
    {
        $request->validated();
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
