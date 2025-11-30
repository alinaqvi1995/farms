<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $animalId = $this->animal?->id;

        return [
            'farm_id' => 'nullable|exists:farms,id',
            'tag_number' => 'nullable|string|max:255|unique:animals,tag_number,' . $animalId,
            'name' => 'nullable|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:255',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'vendor' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'health_status' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'created_by' => 'nullable|exists:users,id',
            'updated_by' => 'nullable|exists:users,id',
        ];
    }
}
