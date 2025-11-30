<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalHealthCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalHealthCheckController extends Controller
{
    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'check_date' => 'required|date',
            'checked_by' => 'nullable|string|max:255',
            'body_temperature' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'respiration_rate' => 'nullable|string',
            'overall_condition' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data['animal_id'] = $request->animal_id;
        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        AnimalHealthCheck::create($data);

        return redirect()->back()->with('success', 'Health check added.');
    }

    public function update(Request $request, AnimalHealthCheck $healthCheck)
    {
        $data = $request->validate([
            'check_date' => 'required|date',
            'checked_by' => 'nullable|string|max:255',
            'body_temperature' => 'nullable|string',
            'heart_rate' => 'nullable|string',
            'respiration_rate' => 'nullable|string',
            'overall_condition' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $healthCheck->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->back()->with('success', 'Health check updated.');
    }

    public function destroy(AnimalHealthCheck $healthCheck)
    {
        $healthCheck->delete();
        return redirect()->back()->with('success', 'Health check deleted.');
    }
}
