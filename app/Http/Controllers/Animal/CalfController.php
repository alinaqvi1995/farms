<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Calf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalfController extends Controller
{
    public function store(Request $request, Animal $animal)
    {
        $data = $request->validate([
            'tag_number' => 'required|string|max:255|unique:calves,tag_number',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'birth_weight' => 'nullable|numeric|min:0',
            'current_weight' => 'nullable|numeric|min:0',
            'weaning_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $data['mother_id'] = $request->mother_id;
        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        Calf::create($data);

        return redirect()->back()->with('success', 'Calf added.');
    }

    public function update(Request $request, Calf $calf)
    {
        $data = $request->validate([
            'tag_number' => 'required|string|max:255|unique:calves,tag_number,' . $calf->id,
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'birth_weight' => 'nullable|numeric|min:0',
            'current_weight' => 'nullable|numeric|min:0',
            'weaning_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $calf->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->back()->with('success', 'Calf updated.');
    }

    public function destroy(Calf $calf)
    {
        $calf->delete();
        return redirect()->back()->with('success', 'Calf deleted.');
    }
}
