<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternResource extends JsonResource
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
                'type' => 'Intern',
                'attributes' => [
                    'name' => $this->name,
                    'city' => $this->city,
                    'address' => $this->address,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'cv' => $this->cv,
                    'github' => $this->github,
                    'group' => $this->whenLoaded('group', $this->group),
                ]
        ];
    }

//    /**
//     * Customize the outgoing response for the resource.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Illuminate\Http\Response  $response
//     * @return void
//     */
//    public function withResponse($request, $response)
//    {
//        $response->header('Accept', 'application/json');
//    }
}
