<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Blog;
use App\Models\User;
use App\Models\Farm;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class SidebarComposer
{
    public function compose(View $view): void
    {
        $currentUser = Auth::user();

        $usersQuery = User::query();
        $farmsQuery = Farm::query();
        $animalsQuery = Animal::query();

        if ($currentUser && $currentUser->hasRole('farm_admin')) {
            $usersQuery->where('farm_id', $currentUser->farm_id);
            $farmsQuery->where('id', $currentUser->farm_id);
            $animalsQuery->where('farm_id', $currentUser->farm_id);
        }

        $view->with([
            'usersCount' => $usersQuery->count(),
            'blogsCount' => Blog::count(),
            'categoriesCount' => Category::count(),
            'subcategoriesCount' => Subcategory::count(),
            'farmsCount' => $farmsQuery->count(),
            'animalsCount' => $animalsQuery->count(),
        ]);
    }
}
