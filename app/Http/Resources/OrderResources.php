<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_code' => $this->order_code,
            'customer_name' => $this->customer_name,
            'table_number' => $this->table_number,
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at->diffForHumans(),
            'order_items' => collect($this->orderItems)->each(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'product' => [
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                    ]
                ];
            })
        ];
    }
}
