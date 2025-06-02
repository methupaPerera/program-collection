<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "amount" => $this->amount,
            "status" => $this->status,
            "billedDate" => $this->billed_date,
            "paidDate" => $this->paid_date,
            "customer" => new CustomerResource($this->whenLoaded("customer")),
        ];
    }
}
