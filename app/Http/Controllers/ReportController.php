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

        // Base Query
        $query = MilkProduction::query();
        if ($farmId) {
            $query->where('farm_id', $farmId);
        }
        $query->whereBetween('recorded_at', [$startDate, $endDate]);

        // Summary Stats (Direct DB Aggregation)
        // Clone query for stats so we don't affect main pagination query
        $statsQuery = clone $query;
        $totalProduction = $statsQuery->sum('litres');

        // Efficient way to count distinct days
        $statsQueryForDays = clone $query;
        $daysCount = $statsQueryForDays->selectRaw('count(distinct date(recorded_at)) as days_count')->value('days_count');

        $avgDailyProduction = $daysCount > 0 ? $totalProduction / $daysCount : 0;

        // Pagination Data
        // Order by recorded_at DESC
        $productionData = $query->with(['animal', 'animal.farm'])
            ->orderBy('recorded_at', 'desc')
            ->paginate(20); // 50 items per page

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

        // Base Query
        $query = MilkSale::query();

        if ($filterFarmId) {
            $query->where('farm_id', $filterFarmId);
        }

        $query->whereBetween('sold_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);

        if ($vendorId) {
            $query->where('vendor_id', $vendorId);
        }

        // Summary Stats (Direct DB Aggregation)
        $statsQuery = clone $query;
        $totalSold = $statsQuery->sum('quantity');
        $totalRevenue = $statsQuery->sum('total_amount');
        $avgPrice = $totalSold > 0 ? $totalRevenue / $totalSold : 0;

        // Pagination Data
        $salesData = $query->with(['vendor', 'farm'])
            ->orderBy('sold_at', 'desc')
            ->paginate(20);

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
