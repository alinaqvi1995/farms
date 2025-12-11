<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $permissions = [
            // 'activityLogs' => 'view-activityLogs',
        ];

        foreach ($permissions as $method => $permission) {
            $this->middleware("permission:{$permission}")->only($method);
        }
    }

    public function activityLogs(Request $request)
    {
        $search = $request->input('search');

        $query = Activity::with(['causer', 'subject']);

        $user = auth()->user();
        if (! $user->hasRole('super_admin') && $user->farm) {
            $farmUserIds = $user->farm->users()->pluck('id');
            $query->where('causer_type', \App\Models\User::class)
                ->whereIn('causer_id', $farmUserIds);
        }

        $logs = $query->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('log_name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->orWhere('causer_type', 'LIKE', "%{$search}%")
                    ->orWhere('subject_type', 'LIKE', "%{$search}%")
                    ->orWhere('properties', 'LIKE', "%{$search}%")
                    ->orWhere('created_at', 'LIKE', "%{$search}%");
            });
        })
            ->latest()
            ->paginate(20)
            ->appends(['search' => $search]);

        return view('dashboard.pages.activity_logs', compact('logs', 'search'));
    }
    // public function activityLogs(Request $request)
    // {
    //     $search = $request->input('search');

    //     $logs = Activity::when($search, function ($query) use ($search) {
    //         $query->where(function ($q) use ($search) {
    //             $q->where('log_name', 'LIKE', "%{$search}%")
    //                 ->orWhere('description', 'LIKE', "%{$search}%")
    //                 ->orWhere('causer_type', 'LIKE', "%{$search}%")
    //                 ->orWhere('subject_type', 'LIKE', "%{$search}%")
    //                 ->orWhere('properties', 'LIKE', "%{$search}%")
    //                 ->orWhere('created_at', 'LIKE', "%{$search}%");
    //         });
    //     })
    //         ->latest()
    //         ->paginate(20)
    //         ->appends(['search' => $search]);

    //     return view('dashboard.pages.activity_logs', compact('logs', 'search'));
    // }
}
