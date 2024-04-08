<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display all orders.
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orderList = Order::all();
        return response()->json($orderList, 201);
    }

    /**
     * Display all orders of selected user.
     * @param $id
     * @return JsonResponse
     */
    public function getByUserId($id): JsonResponse
    {
        $order = Order::where('user_id', $id)->with('orderProducts')->get();
        if ($order === null) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order, 201);
    }

    /**
     * Display an order by id.
     * @param $id
     * @return JsonResponse
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
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required',
        ]);
        $order = Order::create([
            'user_id' => $request->user_id,
            'order_number' => Str::uuid(),
        ]);
        $order->save();
        return response()->json($order, 201);
    }

    /**
     * Remove the specified order from storage.
     * @param $id
     * @return JsonResponse
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
