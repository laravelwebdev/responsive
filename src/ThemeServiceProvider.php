<?php

namespace Laravelwebdev\Responsive;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    const NOVA_VIEWS_PATH = __DIR__ . '/../resources/views';
    const CONFIG_FILE = __DIR__ . '/../config/responsive.php';

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // JS for Responsive design
        Nova::serving(function (ServingNova $event) {
            Nova::style('responsive',  __DIR__ . '/../dist/css/responsive.css');
            Nova::script('responsive', __DIR__ . '/../dist/js/theme.js');
            Nova::provideToScript([
                'mmns' => config('responsive'),
            ]);

        });

        // Publishes Config
        $this->publishes([
            self::CONFIG_FILE => config_path('responsive.php'),
        ], 'config');

        // Views
        $this->publishes([
            self::NOVA_VIEWS_PATH => resource_path('views/vendor/nova'),
        ], 'views');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_FILE,
            'responsive'
        );
    }
}
