<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot() {
        // timestamp付与
        Blade::directive('asset', function ($file) {
            try {
                return "<?php echo '/'. $file . '?' . \File::lastModified(public_path() . '/' . $file) ?>";
            } catch (\Exception $ex) {
                return "<?php echo '/'. $file ?>";
            }
        });
    }

    /**
     * Register any application services.
     * @return void
     */
    public function register() {
        //
    }
}
