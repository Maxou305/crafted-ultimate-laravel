<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    /**
     * Display all orders.
     * @return JsonResponse : JSON response with all orders.
     */
    public function index(): JsonResponse
    {
        $response = Gate::inspect('viewAny', Order::class);

        if ($response->allowed()) {
            $orderList = OrderResource::collection(Order::with(['user', 'products'])->get());
            return response()->json($orderList, 201);
        }
        else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Display all orders of selected user.
     * @param $id : User ID.
     * @return JsonResponse : JSON response with all orders of selected user.
     */
    public function getByUserId($id): JsonResponse
    {
        $order = Order::where('user_id', $id)->with(['user', 'products'])->get();

        $response = Gate::inspect('view', $order->first());

        if ($response->allowed()) {
            $order = OrderResource::collection($order);
            return response()->json($order, 201);
        }
        else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Display an order by id.
     * @param $id : Order ID.
     * @return JsonResponse : JSON response with the order.
     */
    public function getById($id): JsonResponse
    {
        $order = Order::where('id', $id)->with(['user', 'products'])->get();

        $response = Gate::inspect('view', $order->first());

        if ($response->allowed()) {
            $order = OrderResource::collection($order);
            return response()->json($order, 201);
        }
        else {
            return response()->json(['message' => $response->message()], 403);
        }
    }

    /**
     * Store a newly created order in storage.
     * @param StoreOrderRequest $request : Request with order data.
     * @return JsonResponse : JSON response with the created order.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $response = Gate::inspect('create', Order::class);

        if($response->allowed()){
            $highestOrderNumber = Order::max('order_number');
            $newOrderNumber = $highestOrderNumber ? $highestOrderNumber + 1 : 1;

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => $newOrderNumber,
                'price' => $request->input('price'),
                'validatedStatus' => $request->input('validatedStatus'),
                'shippingCountry' => $request->input('shippingCountry'),
                'shippingMode' => $request->input('shippingMode'),
                'shippingPrice' => $request->input('shippingPrice'),
                'creatorCode' => $request->input('creatorCode'),
                'promoCode' => $request->input('promoCode'),
            ]);

            foreach ($request->input('products') as $product) {
                $order->products()->attach(
                    $product['id'],
                    ['quantity' => $product['quantity'],
                        'price' => $product['price'],
                        'size' => array_key_exists('size', $product) ? $product['size'] : null,
                        'color' => array_key_exists('color', $product) ? $product['color'] : null,
                        'material' => array_key_exists('material', $product) ? $product['material'] : null,
                    ]
                );
                Product::find($product['id'])->decrement('stock', $product['quantity']);
            }
            $order->save();
            return response()->json($order, 201);
        }
       else {
            return response()->json(['message' => $response->message()], 403);
       }
    }

    /**
     * Remove the specified order from storage.
     * @param $id : Order ID.
     * @return JsonResponse : JSON response with message of deletion.
     */
    public function destroy($id): JsonResponse
    {
        $order = Order::find($id);

        $response = Gate::inspect('delete', $order);

        if ($response->allowed()) {
            $order->orderProducts()->delete();
            $order->delete();
            return response()->json(['message' => 'Order deleted'], 201);
        }
        else {
            return response()->json(['message' => $response->message()], 403);
        }
    }
}
