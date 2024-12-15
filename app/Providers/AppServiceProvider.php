<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }


    public function boot()
    {
        Blade::directive('access', function ($permissions) {
            // Convert the permissions argument to a comma-separated string
            return "<?php if (check() && user()->hasPermission(".$permissions.")): ?>";
        });

        Blade::directive('endaccess', function () {
            return '<?php endif; ?>';
        });
        Blade::directive('allow', function ($permissions) {
            // Convert the permissions argument to a comma-separated string
            return "<?php if (check() && user()->checkPermissionWithRoute(" . $permissions . ")): ?>";
        });

        Blade::directive('endallow', function () {
            return '<?php endif; ?>';
        });
    }
}
