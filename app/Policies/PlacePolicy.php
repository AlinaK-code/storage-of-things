<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Place;
use Illuminate\Auth\Access\Response;

class PlacePolicy
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
        return true; // все могут видеть список
    }

    public function view(User $user, Place $place): bool
    {
        return true; // все могут просматривать
    }

    public function create(User $user): bool
    {
        return true; // все могут создавать
    }

    public function update(User $user, Place $place): bool
    {
        return $place->master === $user->id;
    }

    public function delete(User $user, Place $place): bool
    {
        return $place->master === $user->id;
    }
}