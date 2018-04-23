<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product->name,
            'customer' => $this->customer,
            'review' => $this->review,
            'star' => $this->star,
            'href' => [
                'link' => route('api.reviews.show', ['product' => $this->product->id, 'review' => $this->id]),
            ]
        ];
    }
}
