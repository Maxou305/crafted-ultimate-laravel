<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    /**
     * Display all orders.
     * @return JsonResponse : JSON response with all orders.
     */
    public function index(): JsonResponse
    {
        $orderList = OrderResource::collection(Order::with(['user', 'products'])->get());
        return response()->json($orderList, 201);
    }

    /**
     * Display all orders of selected user.
     * @param $id : User ID.
     * @return JsonResponse : JSON response with all orders of selected user.
     */
    public function getByUserId($id): JsonResponse
    {
        $order = Order::where('user_id', $id)->with(['user', 'products'])->get();
        $order = OrderResource::collection($order);
        return response()->json($order, 201);
    }

    /**
     * Display an order by id.
     * @param $id : Order ID.
     * @return JsonResponse : JSON response with the order.
     */
    public function getById($id): JsonResponse
    {
        $order = Order::where('id', $id)->with(['user', 'products'])->get();
        $order = OrderResource::collection($order);
        return response()->json($order, 201);
    }

    /**
     * Store a newly created order in storage.
     * @param StoreOrderRequest $request : Request with order data.
     * @return JsonResponse : JSON response with the created order.
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $highestOrderNumber = Order::max('order_number');
        $newOrderNumber = $highestOrderNumber ? $highestOrderNumber + 1 : 1;

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => $newOrderNumber
        ]);

        foreach ($request->input() as $product) {
            $order->products()->attach(
                $product['id'],
                ['quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'size' => array_key_exists('size', $product) ? $product['size'] : null,
                    'color' => array_key_exists('color', $product) ? $product['color'] : null,
                    'material' => array_key_exists('material', $product) ? $product['material'] : null,
                ]
            );
        }

        $order->save();
        return response()->json($order, 201);
    }

    /**
     * Remove the specified order from storage.
     * @param $id : Order ID.
     * @return JsonResponse : JSON response with message of deletion.
     */
    public function destroy($id): JsonResponse
    {
        $order = Order::find($id);
        $order->orderProducts()->delete();
        $order->delete();
        return response()->json(['message' => 'Order deleted'], 201);
    }
}
