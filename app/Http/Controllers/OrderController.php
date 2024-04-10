<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display all orders.
     * @return JsonResponse : JSON response with all orders.
     */
    public function index(): JsonResponse
    {
        $orderList = Order::with('products')->get();
        $orderList->each(function ($order) {
            $order->products->each(function ($product) {
                $product->makeHidden(
                    'shop_id',
                    'image',
                    'description',
                    'story',
                    'pivot',
                    'created_at',
                    'updated_at',
                    'color',
                    'material',
                    'size');
            });
        });
        return response()->json($orderList, 201);
    }

    /**
     * Display all orders of selected user.
     * @param $id : User ID.
     * @return JsonResponse : JSON response with all orders of selected user.
     */
    public function getByUserId($id): JsonResponse
    {
        $order = Order::where('user_id', $id)->with('orderProducts')->get();
        return response()->json($order, 201);
    }

    /**
     * Display an order by id.
     * @param $id : Order ID.
     * @return JsonResponse : JSON response with the order.
     */
    public function getById($id): JsonResponse
    {
        $order = Order::where('id', $id)->with('orderProducts')->get();
        if ($order === null) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        if ($order->count() === 1) {
            return response()->json($order[0], 201);
        }
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
            'user_id' => $request->user_id,
            'order_number' => $newOrderNumber
        ]);
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
        if ($order === null) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        $order->orderProducts()->delete();
        $order->delete();
        return response()->json(['message' => 'Order deleted'], 201);
    }
}
