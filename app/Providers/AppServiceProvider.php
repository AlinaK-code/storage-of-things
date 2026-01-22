<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    // создала собственную директиву HighlightOwner она окрасит в цвет вещи текущего пользователя
    public function boot(): void
    {
        Blade::directive('highlightOwner', function ($thing) {
            return "<?php echo ({$thing}->master == auth()->id()) ? 'highlight-owner' : ''; ?>";
        });

        Blade::directive('activeTab', function ($routeName) {
            return "<?php echo request()->routeIs({$routeName}) ? 'active' : ''; ?>";
        });

        Blade::directive('highlightPlaceType', function ($place) {
            return "<?php
                \$classes = [];
                if ({$place}->repair) {
                    \$classes[] = 'highlight-repair';
                }
                if ({$place}->work) {
                    \$classes[] = 'highlight-work';
                }
                echo implode(' ', \$classes);
            ?>";
        });

        Broadcast::routes();
    }
}
