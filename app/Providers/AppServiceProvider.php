<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Permission;
use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;
use App\Repositories\Farm\FarmRepositoryInterface;
use App\Repositories\Farm\FarmRepository;
use App\Repositories\Animal\AnimalRepositoryInterface;
use App\Repositories\Animal\AnimalRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FarmRepositoryInterface::class, FarmRepository::class);
        $this->app->bind(AnimalRepositoryInterface::class, AnimalRepository::class);
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole('super_admin')) {
                return true;
            }
        });

        try {
            Permission::pluck('slug')->each(function ($slug) {
                Gate::define($slug, function (User $user) use ($slug) {
                    return $user->hasPermission($slug);
                });
            });
        } catch (\Exception $e) {
        }

        View::composer(['partials.admin.header', 'dashboard.includes.partial.nav'], function ($view) {
            if (auth()->check()) {
                $query = \App\Models\Activity::with('causer')->latest()->take(5);
                $user = auth()->user();

                if (!$user->hasRole('super_admin') && $user->farm) {
                    $farmUserIds = $user->farm->users()->pluck('id');
                    $query->where('causer_type', \App\Models\User::class)
                          ->whereIn('causer_id', $farmUserIds);
                }
                
                $view->with('recentActivities', $query->get());
            } else {
                $view->with('recentActivities', collect());
            }
        });
    }
}
