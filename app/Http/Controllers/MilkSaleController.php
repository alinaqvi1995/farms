<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\GlobalSetting;
use App\Models\MilkProduction;
use App\Models\MilkSale;
use App\Models\Vendor;
use Illuminate\Http\Request;

class MilkSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $todayProductionTotal = 0;
        $todaySalesTotal = 0;

        if ($user->isSuperAdmin()) {
            $sales = MilkSale::with(['farm', 'vendor'])->latest()->get();
            $vendors = Vendor::all();
            $farms = Farm::all();

            $todayProductionTotal = MilkProduction::whereDate('recorded_at', today())->sum('litres');
            $todaySalesTotal = MilkSale::whereDate('sold_at', today())->sum('quantity');

        } elseif ($user->isFarmAdmin() && $user->farm) {
            $sales = $user->farm->milkSales()->with(['vendor'])->latest()->get();
            $vendors = $user->farm->vendors;
            $farms = collect([$user->farm]);

            $todayProductionTotal = MilkProduction::where('farm_id', $user->farm->id)
                ->whereDate('recorded_at', today())
                ->sum('litres');
            $todaySalesTotal = MilkSale::where('farm_id', $user->farm->id)
                ->whereDate('sold_at', today())
                ->sum('quantity');
        } else {
            $sales = collect();
            $vendors = collect();
            $farms = collect();
        }

        $remainingStock = $todayProductionTotal - $todaySalesTotal;

        return view('milk_sales.index', compact('sales', 'vendors', 'farms', 'todayProductionTotal', 'todaySalesTotal', 'remainingStock'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $farms = Farm::all(); // Or filter by user permissions
        $vendors = Vendor::all(); // Should actully be farm specific vendors

        return view('milk_sales.create', compact('farms', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'vendor_id' => 'required|exists:vendors,id',
            'quantity' => 'required|numeric|min:0',
            'price_type' => 'required|in:admin,custom',
            'custom_price' => 'nullable|numeric|required_if:price_type,custom',
            'sold_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $pricePerUnit = 0;

        if ($validated['price_type'] === 'admin') {
            $globalPrice = GlobalSetting::where('key', 'milk_default_price')->value('value');
            $pricePerUnit = $globalPrice ? (float) $globalPrice : 0;
        } else {
            $pricePerUnit = (float) $validated['custom_price'];
        }

        $totalAmount = $validated['quantity'] * $pricePerUnit;

        MilkSale::create([
            'farm_id' => $validated['farm_id'],
            'vendor_id' => $validated['vendor_id'],
            'quantity' => $validated['quantity'],
            'price_type' => $validated['price_type'],
            'price_per_unit' => $pricePerUnit,
            'total_amount' => $totalAmount,
            'sold_at' => $validated['sold_at'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Milk sale recorded successfully.');
    }
}
