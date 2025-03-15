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
        $data = [
            'uuid'         => $this->uuid,
            'name'         => $this->name,
            'type'         => $this->type,
            'model_number' => $this->model_number,
            'status'       => $this->status,
        ];

        if ($this->relationLoaded('bike_model') && $this->bike_model->isNotEmpty()) {
            $data['bike_model'] = new PermissionResource($this->bike_model);
        }

        return $data;
    }

}
