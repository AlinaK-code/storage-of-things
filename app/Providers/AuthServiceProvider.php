<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Place::class => \App\Policies\PlacePolicy::class,
        \App\Models\Thing::class => \App\Policies\ThingPolicy::class,];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin-access', function (User $user) {
            return $user->isAdmin();
        });
    }
}