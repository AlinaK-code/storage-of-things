<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Thing;
use Illuminate\Auth\Access\Response;

class ThingPolicy
{
    public function before(User $user)
    {
        // Админ может всё
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Thing $thing): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Thing $thing): bool
    {
        return $thing->master === $user->id;
    }

    public function delete(User $user, Thing $thing): bool
    {
        return $thing->master === $user->id;
    }
}