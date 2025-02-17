<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'          => $this->uuid,
            'name'          => $this->name,
            'phone'         => $this->phone,
            'email'         => $this->email,
            'address'       => $this->address,
            'product'       => $this->product,
            'model'         => $this->model,
            'serial_number' => $this->serial_number,
            'memo_number'   => $this->memo_number,
        ];
    }
}
