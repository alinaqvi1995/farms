<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Animal;

class AnimalPolicy
{
    /**
     * Determine if the user can view an animal.
     */
    public function view(User $user, Animal $animal): bool
    {
        // Super admin can view all
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Farm admin can view only animals in their farm
        if ($user->hasRole('farm_admin')) {
            return $user->farm_id === $animal->farm_id;
        }

        // Regular users cannot view
        return false;
    }

    /**
     * Determine if the user can create a new animal.
     */
    public function create(User $user, ?int $farmId = null): bool
    {
        // Super admins can create anywhere
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Farm admins can create only in their farm
        if ($user->hasRole('farm_admin') && $farmId !== null) {
            return $user->farm_id === $farmId;
        }

        return false;
    }

    /**
     * Determine if the user can update an animal.
     */
    public function update(User $user, Animal $animal): bool
    {
        // Super admin can update all
        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Farm admin can update only animals in their farm
        if ($user->hasRole('farm_admin')) {
            return $user->farm_id === $animal->farm_id;
        }

        return false;
    }

    /**
     * Determine if the user can delete an animal.
     */
    public function delete(User $user, Animal $animal): bool
    {
        // Same rules as update
        return $this->update($user, $animal);
    }
}
