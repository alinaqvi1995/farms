<?php

namespace App\Http\Controllers\Animal;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\FeedInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedInventoryController extends Controller
{
    // Display feed inventory for a farm
    public function index(Farm $farm = null)
    {
        $user = Auth::user();

        if ($user->hasRole('super_admin')) {
            // Superadmin sees all feed records or for a specific farm
            $feedRecords = $farm
                ? FeedInventory::where('farm_id', $farm->id)->orderBy('date', 'desc')->paginate(10)
                : FeedInventory::orderBy('date', 'desc')->paginate(10);
        } else {
            // Farm admin sees only their own farm
            $feedRecords = FeedInventory::where('farm_id', $user->farm->id)
                ->orderBy('date', 'desc')
                ->paginate(10);
        }

        return view('feed_inventories.index', compact('feedRecords', 'farm', 'user'));
    }


    // Show form to create new feed entry
    public function create(Farm $farm)
    {
        return view('feed_inventories.create', compact('farm'));
    }

    // Store new feed inventory
    public function store(Request $request, Farm $farm)
    {
        $data = $request->validate([
            'entry_type' => 'required|in:stock_in,consumption',
            'quantity' => 'required|numeric|min:0',
            'feed_name' => 'nullable|string|max:255',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $data['farm_id'] = $request->farm_id;
        $data['created_by'] = Auth::id();

        FeedInventory::create($data);

        return redirect()->route('feed_inventories.index', $farm)->with('success', 'Feed record added.');
    }

    // Show form to edit feed entry
    public function edit(Farm $farm, FeedInventory $feedInventory)
    {
        return view('feed_inventories.edit', compact('farm', 'feedInventory'));
    }

    // Update feed inventory
    public function update(Request $request, Farm $farm, FeedInventory $feedInventory)
    {
        $data = $request->validate([
            'entry_type' => 'required|in:stock_in,consumption',
            'quantity' => 'required|numeric|min:0',
            'feed_name' => 'nullable|string|max:255',
            'cost_per_unit' => 'nullable|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $feedInventory->update(array_merge($data, ['updated_by' => Auth::id()]));

        return redirect()->route('feed_inventories.index', $farm)->with('success', 'Feed record updated.');
    }

    // Delete feed inventory
    public function destroy(Farm $farm, FeedInventory $feedInventory)
    {
        $feedInventory->delete();
        return redirect()->route('feed_inventories.index', $farm)->with('success', 'Feed record deleted.');
    }
}
