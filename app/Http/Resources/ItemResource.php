<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'item_name' => $this->name,
            'details' => $this->description,
            'category' => $this->whenLoaded('category',function(){
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                ];
            }),
            'current_stock' => (int)$this->stock_level,
            'unit_price'=> number_format((float)$this->price,2),
            'added_on' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
