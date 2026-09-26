<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PrinterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'brand_id'   => $this->brand_id,
            'brand'      => $this->brand,
            'model_name'          => $this->model_name,
            'slug'                => $this->slug,
            'compatible_products' => ProductResource::collection($this->whenLoaded('compatibleProducts')),
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at,
        ];
    }
}
