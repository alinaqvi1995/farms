<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Farm;

class FarmPolicy
{
    /**
     * Only super admin can view list of all farms.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * View a single farm.
     * Super admin = can view all
     * Farm admin = only own farm
     */
    public function view(User $user, Farm $farm): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('farm_admin')) {
            return $user->farm_id === $farm->id;
        }
        

        return false;
    }

    /**
     * Only super admin can create farms.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    /**
     * Update farm:
     * - super admin: any farm
     * - farm admin: only their own farm
     */
    public function update(User $user, Farm $farm): bool
    {
        if ($user->hasRole('super_admin')) {
            return true;
        }

        if ($user->hasRole('farm_admin')) {
            return $user->farm_id === $farm->id;
        }

        return false;
    }

    /**
     * Only super admin can delete farms.
     */
    public function delete(User $user, Farm $farm): bool
    {
        return $user->hasRole('super_admin');
    }
}
