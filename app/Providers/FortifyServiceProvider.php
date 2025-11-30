<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Animal;
use App\Policies\UserPolicy;
use App\Policies\AnimalPolicy;
use App\Policies\FarmPolicy;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies individually
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Animal::class, AnimalPolicy::class);
        Gate::policy(Farm::class, FarmPolicy::class);
    }
}
