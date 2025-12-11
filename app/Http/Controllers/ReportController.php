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
    public function milkProduction(Request $request)
    {
        $user = auth()->user();
        if (! $user->isFarmAdmin() || ! $user->farm) {
            // For SuperAdmin, we might want to show all or select farm, but requirement was "esp for farm admins"
            // Lets stick to current farm logic for now, or empty if no farm.
            if ($user->isSuperAdmin()) {
                // Future: Allow SuperAdmin to select farm. For now, show empty or all if desired.
                // Let's return empty to avoid confusion unless we add a farm selector.
                // OR we can just show all stats for superadmin. Let's redirect or show error for now if strictly for farm admins.
                // But better, let's just use empty collection if no farm context.
            }
        }

        $farmId = $user->farm_id; // Assumes Farm Admin has farm_id or we get it from $user->farm->id

        // Defaults
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query
        $productionQuery = MilkProduction::with('animal');

        if ($user->isFarmAdmin() && $user->farm) {
            $productionQuery->where('farm_id', $user->farm->id);
        }

        $productionData = $productionQuery->whereBetween('recorded_at', [$startDate, $endDate])
            ->orderBy('recorded_at', 'desc')
            ->get();

        // Summary Stats
        $totalProduction = $productionData->sum('litres');
        $daysCount = $productionData->groupBy(function ($item) {
            return Carbon::parse($item->recorded_at)->format('Y-m-d');
        })->count();

        $avgDailyProduction = $daysCount > 0 ? $totalProduction / $daysCount : 0;

        return view('reports.production', compact('productionData', 'totalProduction', 'avgDailyProduction', 'startDate', 'endDate'));
    }

    /**
     * Milk Sales & Finance Report
     */
    public function milkSales(Request $request)
    {
        $user = auth()->user();
        $farmId = $user->farm_id;

        // Defaults
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $vendorId = $request->input('vendor_id');

        // Query
        $salesQuery = MilkSale::with('vendor');

        if ($user->isFarmAdmin() && $user->farm) {
            $salesQuery->where('farm_id', $user->farm->id);
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
        $vendors = $user->isFarmAdmin() && $user->farm ? $user->farm->vendors : Vendor::all();

        return view('reports.sales', compact('salesData', 'totalSold', 'totalRevenue', 'avgPrice', 'vendors', 'startDate', 'endDate', 'vendorId'));
    }
}
