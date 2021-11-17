<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'type' => 'Group',
            'attributes' => [
                'name' => $this->name,
                'mentors' => $this->whenLoaded('mentor'),
                'interns' => $this->whenLoaded('intern'),
                'assignments' => $this->whenLoaded('assignment'),
                ],
        ];
    }
}
