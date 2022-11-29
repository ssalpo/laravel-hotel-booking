<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'room' => RoomResource::make($this->whenLoaded('room')),
            'user' => UserResource::make($this->whenLoaded('user')),
            'status' => $this->status,
            'check_in' => $this->check_in,
            'created_at' => $this->created_at,
        ];
    }
}
