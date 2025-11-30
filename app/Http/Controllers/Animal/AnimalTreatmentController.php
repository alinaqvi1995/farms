<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalTreatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalTreatmentController extends Controller
{
    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'treatment_type' => 'required|string|max:255',
            'treatment_date' => 'required|date',
            'given_by' => 'nullable|string|max:255',
            'medicine' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['animal_id'] = $request->animal_id;
        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        AnimalTreatment::create($data);

        return redirect()->back()->with('success', 'Treatment record added.');
    }

    public function update(Request $request, AnimalTreatment $treatment)
    {
        $data = $request->validate([
            'treatment_type' => 'required|string|max:255',
            'treatment_date' => 'required|date',
            'given_by' => 'nullable|string|max:255',
            'medicine' => 'nullable|string|max:255',
            'dosage' => 'nullable|string|max:255',
            'duration' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $treatment->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->back()->with('success', 'Treatment record updated.');
    }

    public function destroy(AnimalTreatment $treatment)
    {
        $treatment->delete();
        return redirect()->back()->with('success', 'Treatment record deleted.');
    }
}
