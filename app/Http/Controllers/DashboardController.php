<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farm;
use App\Models\Animal;
use App\Models\MilkProduction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // --- Superadmin: global stats ---
        if ($user->hasRole('super_admin')) {
            $userCount = User::count();
            $farmCount = Farm::count();
            $animalCount = Animal::count();

            // Milk Production
            $milkToday = MilkProduction::whereDate('recorded_at', $today)->sum('litres');
            $milkYesterday = MilkProduction::whereDate('recorded_at', $yesterday)->sum('litres');

            // Growth charts
            $usersLast7Days = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->pluck('count', 'date');

            $farmsLast7Days = Farm::selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->pluck('count', 'date');

            $milkLast7Days = MilkProduction::selectRaw('DATE(recorded_at) as date, SUM(litres) as litres')
                ->where('recorded_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('litres', 'date');
        } else {
            // --- Farm Admin: farm-specific stats ---
            $farm = $user->farm; // Assuming each user is linked to a farm
            $userCount = $farm->users()->count();
            $farmCount = null; // Not shown to farm admin
            $animalCount = $farm->animals()->count();

            $milkToday = MilkProduction::where('farm_id', $farm->id)
                ->whereDate('recorded_at', $today)
                ->sum('litres');
            $milkYesterday = MilkProduction::where('farm_id', $farm->id)
                ->whereDate('recorded_at', $yesterday)
                ->sum('litres');

            $usersLast7Days = $farm->users()
                ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
                ->where('created_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->pluck('count', 'date');

            $farmsLast7Days = collect(); // Not shown
            $milkLast7Days = MilkProduction::where('farm_id', $farm->id)
                ->selectRaw('DATE(recorded_at) as date, SUM(litres) as litres')
                ->where('recorded_at', '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('litres', 'date');
        }

        // Calculate milk change %
        if ($milkYesterday > 0) {
            $milkChangePercent = round((($milkToday - $milkYesterday) / $milkYesterday) * 100, 2);
        } else {
            $milkChangePercent = 0;
        }
        $milkTrend = $milkChangePercent > 0 ? 'up' : ($milkChangePercent < 0 ? 'down' : 'equal');

        return view('dashboard.index', compact(
            'userCount',
            'farmCount',
            'animalCount',
            'usersLast7Days',
            'farmsLast7Days',
            'milkToday',
            'milkYesterday',
            'milkChangePercent',
            'milkTrend',
            'milkLast7Days'
        ));
    }
}
