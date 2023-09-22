<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'amount' => $this->amount,
            'approved_amount' => $this->transaction->amount,
            'name' => $this->whenLoaded('agent', $this->agent->name),
            'items' => $this->items,
            'status' => $this->status,
            'info' => $this->info,
            'decline_reason' => $this->decline_reason,
            'reference' => $this->transaction->reference,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
