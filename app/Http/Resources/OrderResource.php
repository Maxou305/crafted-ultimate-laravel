<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'created_at' => $this->created_at,
            'customer' => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'phone_number' => $this->user->phone_number,
                    'shipping_address' => $this->user->shipping_address,
                    'payment_address' => $this->user->payment_address,
                ];
            }),
            'products' => $this->whenLoaded('products', function () {
                return $this->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'shop_id' => $product->shop_id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $product->pivot->quantity,
                        'size' => $product->pivot->size,
                        'color' => $product->pivot->color,
                        'material' => $product->pivot->material,
                    ];
                });
            }),
        ];
    }
}
