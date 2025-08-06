<?php

namespace admin\certificates;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CertificateServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge package config with application config
        $this->mergeConfigFrom(__DIR__.'/../config/certificates.php', 'certificates.constants');
    }

    public function boot()
    {
        // Load routes, views, migrations from the package  
        $this->loadViewsFrom([
            base_path('Modules/Certificates/resources/views'), // Published module views first
            resource_path('views/admin/certificate'), // Published views second
            __DIR__ . '/../resources/views'      // Package views as fallback
        ], 'certificate');

        // Also register module views with a specific namespace for explicit usage
        if (is_dir(base_path('Modules/Certificates/resources/views'))) {
            $this->loadViewsFrom(base_path('Modules/Certificates/resources/views'), 'certificates-module');
        }
        
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // Also load migrations from published module if they exist
        if (is_dir(base_path('Modules/Certificates/database/migrations'))) {
            $this->loadMigrationsFrom(base_path('Modules/Certificates/database/migrations'));
        }

        // Standard publishing for non-PHP files
        $this->publishes([
            __DIR__ . '/../database/migrations' => base_path('Modules/Certificates/database/migrations'),
            __DIR__ . '/../resources/views' => base_path('Modules/Certificates/resources/views/'),
        ], 'certificate');

        // Publish config
        $this->publishes([
            __DIR__.'/../config/certificates.php' => config_path('certificates.php'),
        ], 'certificates-config');

        // Publish seeders
        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'certificates-seeders');

        $this->registerAdminRoutes();
    }

    protected function registerAdminRoutes()
    {
        Route::group([
            'prefix' => 'admin',
            'namespace' => 'admin\certificates\Controllers',
            'middleware' => ['web', 'admin.auth'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
    }
}
