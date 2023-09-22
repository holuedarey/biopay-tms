<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'amount' => (float) $this->amount,
            'charge' => (float) $this->charge,
            'total_amount' => (float) $this->total_amount,
            'status' => $this->status,
            'reference' => $this->reference,
            'service_slug' => $this->whenLoaded('service', $this->service->slug),
            'service' => $this->whenLoaded('service', $this->service->name),
            'recipient' => $this->recipient,
            'info'  => $this->info,
            'stan' => $this->stan,
            'bank_name' => $this->bank_name,
            'account_number' => $this->account_number,
            'power_token' => $this->power_token,
            'wallet_credited' => $this->wallet_credited,
            'wallet_debited' => $this->wallet_debited,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
