<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ExpenseSharingGroup;

class GroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list participant');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExpenseSharingGroup $group): bool
    {
        return $user->hasPermissionTo('view participant');
    }

    /**
     * Determine whether the user can create models.
     */
    public function sendInvitation(User $user, ExpenseSharingGroup $group)
    {
        return $user->id === $group->user_id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExpenseSharingGroup $group): bool
    {
        return $user->hasPermissionTo('edit participant');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExpenseSharingGroup $group): bool
    {
        return $user->hasPermissionTo('remove participant');
    }
}
