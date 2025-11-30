<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FarmResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'owner_name'          => $this->owner_name,
            'phone'               => $this->phone,
            'email'               => $this->email,
            'address'             => $this->address,
            'city'                => $this->city,
            'state'               => $this->state,
            'country'             => $this->country,
            'zipcode'             => $this->zipcode,
            'area'                => $this->area,
            'animals_count'       => $this->animals_count,
            'animal_types'        => $this->animal_types,
            'registration_number' => $this->registration_number,
            'established_at'      => $this->established_at,
            'status'              => $this->status,
            'notes'               => $this->notes,
            'users'               => $this->users,
        ];
    }
}
