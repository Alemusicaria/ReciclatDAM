<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, User $model): bool
    {
        return $user->isAdmin() || (int) $user->id === (int) $model->id;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $model): bool
    {
        return $user->isAdmin() || (int) $user->id === (int) $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin() && (int) $user->id !== (int) $model->id;
    }
}
