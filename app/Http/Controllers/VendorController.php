<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->isSuperAdmin()) {
            $vendors = Vendor::with('farms')->latest()->get();
        } elseif ($user->isFarmAdmin() && $user->farm) {
            $vendors = $user->farm->vendors()->latest()->get();
        } else {
            $vendors = collect();
        }

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Not used if using modal
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $farm = Farm::findOrFail($validated['farm_id']);

        // Check if vendor exists by phone
        $existingVendors = Vendor::where('phone', $validated['phone'])->get();
        $matchedVendor = null;

        foreach ($existingVendors as $vendor) {
            // Check if names are "alike" (substring match in either direction)
            // e.g. "P" in "Per", or "Per" in "Perry"
            if (
                str_contains(strtolower($vendor->name), strtolower($validated['name'])) ||
                str_contains(strtolower($validated['name']), strtolower($vendor->name))
            ) {
                $matchedVendor = $vendor;
                break;
            }
        }

        if ($matchedVendor) {
            // Associate existing vendor
            $farm->vendors()->syncWithoutDetaching($matchedVendor->id);
            $message = 'Existing vendor associated successfully.';
        } else {
            // Create new vendor
            $newVendor = Vendor::create([
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'address' => $validated['address'] ?? null,
            ]);
            $farm->vendors()->attach($newVendor->id);
            $message = 'New vendor created and associated successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        $vendor->update($validated);

        return redirect()->back()->with('success', 'Vendor updated successfully.');
    }
}
