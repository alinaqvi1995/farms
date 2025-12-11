<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use Illuminate\Http\Request;

class GlobalSettingController extends Controller
{
    /**
     * Display the settings form.
     */
    public function index()
    {
        // Ensure only SuperAdmin can access (middleware handle or check here)
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $milkPrice = GlobalSetting::where('key', 'milk_default_price')->value('value');

        return view('settings.index', compact('milkPrice'));
    }

    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        if (! auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'milk_default_price' => 'required|numeric|min:0',
        ]);

        GlobalSetting::updateOrCreate(
            ['key' => 'milk_default_price'],
            [
                'value' => $validated['milk_default_price'],
                'description' => 'Default price per liter for milk sales (Admin Price)',
            ]
        );

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
