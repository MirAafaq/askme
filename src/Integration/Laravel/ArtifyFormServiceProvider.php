<?php

namespace ArtifyForm\Integration\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ArtifyFormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap integration services natively for Laravel Projects.
     */
    public function boot()
    {
        // 1. Blade Directive: @artifyform_css($formBuilder)
        Blade::directive('artifyform_css', function ($expression) {
            return "<?php echo {$expression}->generateCss(); ?>";
        });

        // 2. Blade Directive: @artifyform_form($formBuilder)
        Blade::directive('artifyform_form', function ($expression) {
            return "<?php echo {$expression}->generateForm(); ?>";
        });

        // 3. Optional Configuration File Publishing (if needed in the future)
        // $this->publishes([
        //     __DIR__.'/config/artifyform.php' => config_path('artifyform.php'),
        // ]);
    }

    public function register()
    {
        // Bind singletons or generic facades here if the package extends
    }
}
