<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'effective_price' => $this->effective_price,
            'is_on_sale' => $this->is_on_sale,
            'stock' => $this->stock,
            'image' => $this->image,
            'is_featured' => $this->is_featured,
            'specifications' => $this->specifications,
            'category_id' => $this->category_id,
            'category' => $this->whenLoaded('category'),
            'brand_id' => $this->brand_id,
            'brand' => $this->whenLoaded('brand'),
            'compatible_models' => PrinterResource::collection($this->whenLoaded('compatibleModels')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
