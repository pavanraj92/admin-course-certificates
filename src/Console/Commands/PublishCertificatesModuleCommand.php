<?php

namespace admin\certificates\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishCertificatesModuleCommand extends Command
{
    protected $signature = 'certificates:publish {--force : Force overwrite existing files}';
    protected $description = 'Publish Certificates module files with proper namespace transformation';

    public function handle()
    {
        $this->info('Publishing Certificates module files...');

        // Check if module directory exists
        $moduleDir = base_path('Modules/Certificates');
        if (!File::exists($moduleDir)) {
            File::makeDirectory($moduleDir, 0755, true);
        }

        // Publish with namespace transformation
        $this->publishWithNamespaceTransformation();

        // Publish other files
        $this->call('vendor:publish', [
            '--tag' => 'certificate',
            '--force' => $this->option('force')
        ]);

        // Update composer autoload
        $this->updateComposerAutoload();

        $this->info('Certificates module published successfully!');
        $this->info('Please run: composer dump-autoload');
    }

    protected function publishWithNamespaceTransformation()
    {
        $basePath = dirname(dirname(__DIR__)); // Go up to packages/admin/certificates/src

        $filesWithNamespaces = [
            // Controllers
            $basePath . '/Controllers/CertificateController.php' => base_path('Modules/Certificates/app/Http/Controllers/Admin/CertificateController.php'),

            // Models
            $basePath . '/Models/Certificate.php' => base_path('Modules/Certificates/app/Models/Certificate.php'),

            // Requests
            $basePath . '/Requests/StoreCertificateRequest.php' => base_path('Modules/Certificates/app/Http/Requests/StoreCertificateRequest.php'),
            $basePath . '/Requests/UpdateCertificateRequest.php' => base_path('Modules/Certificates/app/Http/Requests/UpdateCertificateRequest.php'),

            // Routes
            $basePath . '/routes/web.php' => base_path('Modules/Certificates/routes/web.php'),
        ];

        foreach ($filesWithNamespaces as $source => $destination) {
            if (File::exists($source)) {
                File::ensureDirectoryExists(dirname($destination));

                $content = File::get($source);
                $content = $this->transformNamespaces($content, $source);

                File::put($destination, $content);
                $this->info("Published: " . basename($destination));
            } else {
                $this->warn("Source file not found: " . $source);
            }
        }
    }

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
            $content = str_replace('use admin\\certificates\\Models\\Certificate;', 'use Modules\\Certificates\\app\\Models\\Certificate;', $content);
            $content = str_replace('use admin\\certificates\\Requests\\StoreCertificateRequest;', 'use Modules\\Certificates\\app\\Http\\Requests\\StoreCertificateRequest;', $content);
            $content = str_replace('use admin\\certificates\\Requests\\UpdateCertificateRequest;', 'use Modules\\Certificates\\app\\Http\\Requests\\UpdateCertificateRequest;', $content);
        }

        return $content;
    }

    protected function updateComposerAutoload()
    {
        $composerFile = base_path('composer.json');
        $composer = json_decode(File::get($composerFile), true);

        // Add module namespace to autoload
        if (!isset($composer['autoload']['psr-4']['Modules\\Certificates\\'])) {
            $composer['autoload']['psr-4']['Modules\\Certificates\\'] = 'Modules/Certificates/app/';

            File::put($composerFile, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            $this->info('Updated composer.json autoload');
        }
    }
}
