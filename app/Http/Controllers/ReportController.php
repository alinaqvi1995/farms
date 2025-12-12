<?php

namespace App\Http\Controllers;

use App\Models\MilkProduction;
use App\Models\MilkSale;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Milk Production Report
     */
    /**
     * Milk Production Report
     */
    public function milkProduction(Request $request)
    {
        $user = auth()->user();
        
        // Defaults
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        // Farm Filter Logic
        $farms = [];
        $farmId = null;

        if ($user->isSuperAdmin()) {
            $farms = \App\Models\Farm::all();
            $farmId = $request->input('farm_id'); // Optional filter for SuperAdmin
        } elseif ($user->isFarmAdmin() && $user->farm) {
            $farmId = $user->farm->id; // Forced filter for FarmAdmin
        }

        // Query
        $productionQuery = MilkProduction::with(['animal', 'animal.farm']);

        if ($farmId) {
            $productionQuery->where('farm_id', $farmId);
        }

        $productionData = $productionQuery->whereBetween('recorded_at', [$startDate, $endDate])
            ->orderBy('recorded_at', 'desc')
            ->get();

        // Summary Stats
        $totalProduction = $productionData->sum('litres');
        
        // Group by date to count active days. 
        // Note: multiple records per day exist. We want number of distinct days recorded.
        $daysCount = $productionData->groupBy(function ($item) {
            return Carbon::parse($item->recorded_at)->format('Y-m-d');
        })->count();

        $avgDailyProduction = $daysCount > 0 ? $totalProduction / $daysCount : 0;

        return view('reports.production', compact('productionData', 'totalProduction', 'avgDailyProduction', 'startDate', 'endDate', 'farms', 'farmId'));
    }

    /**
     * Milk Sales & Finance Report
     */
    public function milkSales(Request $request)
    {
        $user = auth()->user();

        // Defaults
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $vendorId = $request->input('vendor_id');

        // Farm Filter Logic
        $farms = [];
        $filterFarmId = null;

        if ($user->isSuperAdmin()) {
            $farms = \App\Models\Farm::all();
            $filterFarmId = $request->input('farm_id');
        } elseif ($user->isFarmAdmin() && $user->farm) {
            $filterFarmId = $user->farm->id;
        }

        // Query
        $salesQuery = MilkSale::with(['vendor', 'farm']);

        if ($filterFarmId) {
            $salesQuery->where('farm_id', $filterFarmId);
        }

        $salesQuery->whereBetween('sold_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);

        if ($vendorId) {
            $salesQuery->where('vendor_id', $vendorId);
        }

        $salesData = $salesQuery->orderBy('sold_at', 'desc')->get();

        // Summary Stats
        $totalSold = $salesData->sum('quantity');
        $totalRevenue = $salesData->sum('total_amount');
        $avgPrice = $totalSold > 0 ? $totalRevenue / $totalSold : 0;

        // Unique Vendors for Filter
        // If Farm Admin, only show their vendors. If Super Admin, show vendors relevant to selection or all.
        // Simplified: if SuperAdmin and filtered by farm, show that farm's vendors. Else all.
        if ($user->isFarmAdmin() && $user->farm) {
            $vendors = $user->farm->vendors;
        } elseif ($filterFarmId) {
             // If super admin selected a farm, try to get vendors for that farm
             $selectedFarm = \App\Models\Farm::find($filterFarmId);
             $vendors = $selectedFarm ? $selectedFarm->vendors : Vendor::all();
        } else {
            $vendors = Vendor::all();
        }

        return view('reports.sales', compact('salesData', 'totalSold', 'totalRevenue', 'avgPrice', 'vendors', 'startDate', 'endDate', 'vendorId', 'farms', 'filterFarmId'));
    }
}
