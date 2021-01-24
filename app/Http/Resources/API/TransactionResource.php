<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            "amount" => $this->amount,
            "type" => $this->type,
            "category" => $this->category,
            "created_at" => $this->created_at
        ];
    }
}
