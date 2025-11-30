<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\MilkProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilkProductionController extends Controller
{
    /**
     * Store a new milk production record
     */
    public function store(Request $request, Animal $animal)
    {
        $request->validate([
            'session' => 'required|in:morning,afternoon,evening,night',
            'litres' => 'required|numeric|min:0',
            'recorded_at' => 'required|date',
        ]);

        $milk = new MilkProduction($request->all());
        $milk->animal_id = $request->animal_id;
        $milk->farm_id = $request->farm_id;
        $milk->created_by = Auth::id();
        $milk->save();

        return redirect()->back()->with('success', 'Milk record added.');
    }

    /**
     * Update milk production record
     */
    public function update(Request $request, MilkProduction $milk_production)
    {
        $request->validate([
            'session' => 'required|in:morning,afternoon,evening,night',
            'litres' => 'required|numeric|min:0',
            'recorded_at' => 'required|date',
        ]);

        $milk_production->update(array_merge($request->all(), [
            'updated_by' => Auth::id()
        ]));

        return redirect()->back()->with('success', 'Milk record updated.');
    }

    /**
     * Destroy milk record
     */
    public function destroy(MilkProduction $milk_production)
    {
        $milk_production->delete();
        return redirect()->back()->with('success', 'Milk record deleted.');
    }
}