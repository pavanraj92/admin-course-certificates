<?php

namespace admin\certificates;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CertificateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes, views, migrations from the package  
        $this->loadViewsFrom([
            base_path('Modules/Certificates/resources/views'), // Published module views first
            resource_path('views/admin/certificate'), // Published views second
            __DIR__ . '/../resources/views'      // Package views as fallback
        ], 'certificate');

        // Load published module config first (if it exists), then fallback to package config
        if (file_exists(base_path('Modules/Certificates/config/certificates.php'))) {
            $this->mergeConfigFrom(base_path('Modules/Certificates/config/certificates.php'), 'certificates.config');
        } else {
            // Fallback to package config if published config doesn't exist
            $this->mergeConfigFrom(__DIR__ . '/../config/certificates.php', 'certificates.config');
        }

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
            __DIR__ . '/../config/' => base_path('Modules/Certificates/config/'),
            __DIR__ . '/../database/migrations' => base_path('Modules/Certificates/database/migrations'),
            __DIR__ . '/../resources/views' => base_path('Modules/Certificates/resources/views/'),
        ], 'certificate');

        $this->registerAdminRoutes();
    }

    protected function registerAdminRoutes()
    {
        if (!Schema::hasTable('admins')) {
            return; // Avoid errors before migration
        }

        $slug = DB::table('admins')->latest()->value('website_slug') ?? 'admin';

        Route::middleware('web')
            ->prefix("{$slug}/admin") // dynamic prefix
            ->group(function () {
                // Load routes from published module first, then fallback to package
                if (file_exists(base_path('Modules/Certificates/routes/web.php'))) {
                    $this->loadRoutesFrom(base_path('Modules/Certificates/routes/web.php'));
                } else {
                    $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
                }
            });
    }

    public function register()
    {
        // Register the publish command
        if ($this->app->runningInConsole()) {
            $this->commands([
                \admin\certificates\Console\Commands\PublishCertificatesModuleCommand::class,
                \admin\certificates\Console\Commands\CheckModuleStatusCommand::class,
                \admin\certificates\Console\Commands\DebugCertificatesCommand::class,
                \admin\certificates\Console\Commands\TestViewResolutionCommand::class,
            ]);
        }
    }

    /**
     * Publish files with namespace transformation
     */
    protected function publishWithNamespaceTransformation()
    {
        // Define the files that need namespace transformation
        $filesWithNamespaces = [
            // Controllers
            __DIR__ . '/../src/Controllers/CertificateController.php' => base_path('Modules/Certificates/app/Http/Controllers/Admin/CertificateController.php'),

            // Models
            __DIR__ . '/../src/Models/Certificate.php' => base_path('Modules/Certificates/app/Models/Certificate.php'),

            // Requests
            __DIR__ . '/../src/Requests/StoreCertificateRequest.php' => base_path('Modules/Certificates/app/Http/Requests/StoreCertificateRequest.php'),
            __DIR__ . '/../src/Requests/UpdateCertificateRequest.php' => base_path('Modules/Certificates/app/Http/Requests/UpdateCertificateRequest.php'),

            // Routes
            __DIR__ . '/routes/web.php' => base_path('Modules/Certificates/routes/web.php'),
        ];

        foreach ($filesWithNamespaces as $source => $destination) {
            if (File::exists($source)) {
                // Create destination directory if it doesn't exist
                File::ensureDirectoryExists(dirname($destination));

                // Read the source file
                $content = File::get($source);

                // Transform namespaces based on file type
                $content = $this->transformNamespaces($content, $source);

                // Write the transformed content to destination
                File::put($destination, $content);
            }
        }
    }

    /**
     * Transform namespaces in PHP files
     */
    protected function transformNamespaces($content, $sourceFile)
    {
        // Define namespace mappings
        $namespaceTransforms = [
            // Main namespace transformations
            'namespace admin\\certificates\\Controllers;' => 'namespace Modules\\Certificates\\app\\Http\\Controllers\\Admin;',
            'namespace admin\\certificates\\Models;' => 'namespace Modules\\Certificates\\app\\Models;',
            'namespace admin\\certificates\\Requests;' => 'namespace Modules\\Certificates\\app\\Http\\Requests;',

            // Use statements transformations
            'use admin\\certificates\\Controllers\\' => 'use Modules\\Certificates\\app\\Http\\Controllers\\Admin\\',
            'use admin\\certificates\\Models\\' => 'use Modules\\Certificates\\app\\Models\\',
            'use admin\\certificates\\Requests\\' => 'use Modules\\Certificates\\app\\Http\\Requests\\',

            // Class references in routes
            'admin\\certificates\\Controllers\\CertificateController' => 'Modules\\Certificates\\app\\Http\\Controllers\\Admin\\CertificateController',
        ];

        // Apply transformations
        foreach ($namespaceTransforms as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }

        // Handle specific file types
        if (str_contains($sourceFile, 'Controllers')) {
            $content = $this->transformControllerNamespaces($content);
        } elseif (str_contains($sourceFile, 'Models')) {
            $content = $this->transformModelNamespaces($content);
        } elseif (str_contains($sourceFile, 'Requests')) {
            $content = $this->transformRequestNamespaces($content);
        } elseif (str_contains($sourceFile, 'routes')) {
            $content = $this->transformRouteNamespaces($content);
        }

        return $content;
    }

    /**
     * Transform controller-specific namespaces
     */
    protected function transformControllerNamespaces($content)
    {
        // Update use statements for models and requests
        $content = str_replace(
            'use admin\\certificates\\Models\\Certificate;',
            'use Modules\\Certificates\\app\\Models\\Certificate;',
            $content
        );

        $content = str_replace(
            'use admin\\certificates\\Requests\\StoreCertificateRequest;',
            'use Modules\\Certificates\\app\\Http\\Requests\\StoreCertificateRequest;',
            $content
        );

        $content = str_replace(
            'use admin\\certificates\\Requests\\UpdateCertificateRequest;',
            'use Modules\\Certificates\\app\\Http\\Requests\\UpdateCertificateRequest;',
            $content
        );

        return $content;
    }

    /**
     * Transform model-specific namespaces
     */
    protected function transformModelNamespaces($content)
    {
        // Any model-specific transformations
        return $content;
    }

    /**
     * Transform request-specific namespaces
     */
    protected function transformRequestNamespaces($content)
    {
        // Any request-specific transformations
        return $content;
    }

    /**
     * Transform route-specific namespaces
     */
    protected function transformRouteNamespaces($content)
    {
        // Update controller references in routes
        $content = str_replace(
            'admin\\certificates\\Controllers\\CertificateController',
            'Modules\\Certificates\\app\\Http\\Controllers\\Admin\\CertificateController',
            $content
        );

        return $content;
    }
}
