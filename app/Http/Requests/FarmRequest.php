<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FarmRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $farmId = $this->farm?->id;

        return [
            'name'                => 'required|string|max:255|unique:farms,name,' . $farmId,
            'owner_name'          => 'nullable|string|max:255',
            'phone'               => 'nullable|string|max:20',
            'email'               => 'nullable|email|max:255',
            'address'             => 'nullable|string|max:255',
            'city'                => 'nullable|string|max:255',
            'state'               => 'nullable|string|max:255',
            'country'             => 'nullable|string|max:255',
            'zipcode'             => 'nullable|string|max:20',
            'area'                => 'nullable|string|max:255',
            'description'         => 'nullable|string',
            'animals_count'       => 'nullable|integer|min:0',
            'animal_types'        => 'nullable|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'established_at'      => 'nullable|date',
            'status'              => 'required|in:0,1',
            'notes'               => 'nullable|string',
        ];
    }
}
