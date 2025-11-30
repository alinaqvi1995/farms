<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalDisease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalDiseaseController extends Controller
{
    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'disease_name' => 'required|string|max:255',
            'diagnosed_date' => 'required|date',
            'recovered_date' => 'nullable|date',
            'status' => 'required|in:sick,recovering,recovered',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['animal_id'] = $request->animal_id;
        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        AnimalDisease::create($data);

        return redirect()->back()->with('success', 'Disease record added.');
    }

    public function update(Request $request, AnimalDisease $disease)
    {
        $data = $request->validate([
            'disease_name' => 'required|string|max:255',
            'diagnosed_date' => 'required|date',
            'recovered_date' => 'nullable|date',
            'status' => 'required|in:sick,recovering,recovered',
            'symptoms' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $disease->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->back()->with('success', 'Disease record updated.');
    }

    public function destroy(AnimalDisease $disease)
    {
        $disease->delete();
        return redirect()->back()->with('success', 'Disease record deleted.');
    }
}
