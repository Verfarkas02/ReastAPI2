<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Drink extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "drink"=>$this->drink,
            "amount"=>$this->amount,
            "type"=>$this->type->type,
            "package"=>$this->package->package,
        ];
    }
}
