<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => 'Mentor',
            'attributes' => [
                'name' => $this->name,
                'city' => $this->city,
                'skype' => $this->skype,
                'groups' => $this->whenLoaded('group'),
                'interns' => $this->whenLoaded('group:intern')
            ]
        ];
    }
}
