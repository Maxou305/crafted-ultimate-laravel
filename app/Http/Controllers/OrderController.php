<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with('orderProducts', 'user')->get();
    }

    public function getByUserId($id)
    {
        $order = Order::where('user_id', $id)->with('orderProducts')->get();
        if ($order === null) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return $order;
    }

    public function getById($id)
    {
        $order = Order::where('id', $id)->with('orderProducts')->get();
        if ($order === null) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        if ($order->count() === 1) {
            return $order[0];
        }
        return $order;
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
     * Display the specified resource.
     */
    public function show(Order $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Order $cart)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order === null) {
            return response()->json(['message' => 'Order not found'], 404);
        }
//        $order->orderProducts()->delete();
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
