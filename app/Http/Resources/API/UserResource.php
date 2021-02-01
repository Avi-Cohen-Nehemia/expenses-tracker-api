<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\TransactionResource;
use App\Utility\Balance;
use App\Utility\FormatToCurrency;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $balance = Balance::calculateBalance($this->transactions);
        $formattedBalance = FormatToCurrency::toCurrency($balance);

        $collection = collect($this->transactions);
        $sorted = $collection->sortByDesc('created_at');

        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "balance" => $formattedBalance,
            "transactions" => TransactionResource::collection($sorted),
        ];
    }
}
