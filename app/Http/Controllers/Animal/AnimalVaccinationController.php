<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalVaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalVaccinationController extends Controller
{
    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'date_given' => 'required|date',
            'next_due_date' => 'nullable|date',
            'dose' => 'nullable|string|max:255',
            'administered_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $data['animal_id'] = $request->animal_id;
        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        AnimalVaccination::create($data);

        return redirect()->back()->with('success', 'Vaccination added.');
    }

    public function update(Request $request, AnimalVaccination $vaccination)
    {
        $data = $request->validate([
            'vaccine_name' => 'required|string|max:255',
            'date_given' => 'required|date',
            'next_due_date' => 'nullable|date',
            'dose' => 'nullable|string|max:255',
            'administered_by' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $vaccination->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->back()->with('success', 'Vaccination updated.');
    }

    public function destroy(AnimalVaccination $vaccination)
    {
        $vaccination->delete();
        return redirect()->back()->with('success', 'Vaccination deleted.');
    }
}
