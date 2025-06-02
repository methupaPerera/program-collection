<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "type" => $this->type,
            "address" => $this->address,
            "city" => $this->city,
            "state" => $this->state,
            "postalCode" => $this->postal_code,
            "invoices" => InvoiceResource::collection($this->whenLoaded("invoices")),
        ];
    }
}
