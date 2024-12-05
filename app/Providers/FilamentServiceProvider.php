<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'danger' => Color::Red,
            'gray' => Color::Zinc,
            'info' => Color::Sky,
            'primary' => Color::Indigo,
            'success' => Color::Green,
            'warning' => Color::Amber,
        ]);
    }
}
