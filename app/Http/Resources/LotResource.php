<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LotResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
          'id' => $this->id,
          'title' => $this->title,
          'description'=> $this->description,
          'start_price'=> $this->start_price,
          'auction_price' => $this->auction_price,
          'sold' => $this->sold,
          'auction_active' => $this->auction_active,
          'categories' => CategoryResource::collection($this->whenLoaded('categories')),
          'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
