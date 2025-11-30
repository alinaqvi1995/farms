<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalReproduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalReproductionController extends Controller
{
    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'type' => 'required|in:heat,mating,ai,pregnancy_check,calving',
            'event_date' => 'required|date',
            'male_animal_id' => 'nullable|exists:animals,id',
            'semen_batch' => 'nullable|string|max:255',
            'pregnancy_result' => 'nullable|in:positive,negative,unknown',
            'calf_tag' => 'nullable|string|max:255',
            'calf_gender' => 'nullable|in:male,female',
            'notes' => 'nullable|string',
        ]);

        $data['animal_id'] = $request->animal_id;
        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        AnimalReproduction::create($data);

        return redirect()->back()->with('success', 'Reproduction record added.');
    }

    public function update(Request $request, AnimalReproduction $reproduction)
    {
        $data = $request->validate([
            'type' => 'required|in:heat,mating,ai,pregnancy_check,calving',
            'event_date' => 'required|date',
            'male_animal_id' => 'nullable|exists:animals,id',
            'semen_batch' => 'nullable|string|max:255',
            'pregnancy_result' => 'nullable|in:positive,negative,unknown',
            'calf_tag' => 'nullable|string|max:255',
            'calf_gender' => 'nullable|in:male,female',
            'notes' => 'nullable|string',
        ]);

        $reproduction->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->back()->with('success', 'Reproduction record updated.');
    }

    public function destroy(AnimalReproduction $reproduction)
    {
        $reproduction->delete();
        return redirect()->back()->with('success', 'Reproduction record deleted.');
    }
}
