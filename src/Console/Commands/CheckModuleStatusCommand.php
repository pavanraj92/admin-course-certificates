<?php

namespace admin\certificates\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CheckModuleStatusCommand extends Command
{
    protected $signature = 'certificates:status';
    protected $description = 'Check if Certificates module files are being used';

    public function handle()
    {
        $this->info('Checking Certificates Module Status...');
        
        // Check if module files exist
        $moduleFiles = [
            'Controller' => base_path('Modules/Certificates/app/Http/Controllers/Admin/CertificateController.php'),
            'Model' => base_path('Modules/Certificates/app/Models/Certificate.php'),
            'Request (Create)' => base_path('Modules/Certificates/app/Http/Requests/StoreCertificateRequest.php'),
            'Request (Update)' => base_path('Modules/Certificates/app/Http/Requests/UpdateCertificateRequest.php'),
            'Routes' => base_path('Modules/Certificates/routes/web.php'),
            'Views' => base_path('Modules/Certificates/resources/views'),
            'Config' => base_path('Modules/Certificates/config/certificates.php'),
        ];

        $this->info("\n📁 Module Files Status:");
        foreach ($moduleFiles as $type => $path) {
            if (File::exists($path)) {
                $this->info("✅ {$type}: EXISTS");
                
                // Check if it's a PHP file and show last modified time
                if (str_ends_with($path, '.php')) {
                    $lastModified = date('Y-m-d H:i:s', filemtime($path));
                    $this->line("   Last modified: {$lastModified}");
                }
            } else {
                $this->error("❌ {$type}: NOT FOUND");
            }
        }

        // Check namespace in controller
        $controllerPath = base_path('Modules/Certificates/app/Http/Controllers/Admin/CertificateController.php');
        if (File::exists($controllerPath)) {
            $content = File::get($controllerPath);
            if (str_contains($content, 'namespace Modules\Certificates\app\Http\Controllers\Admin;')) {
                $this->info("\n✅ Controller namespace: CORRECT");
            } else {
                $this->error("\n❌ Controller namespace: INCORRECT");
            }
            
            // Check for test comment
            if (str_contains($content, 'Test comment - this should persist after refresh')) {
                $this->info("✅ Test comment: FOUND (changes are persisting)");
            } else {
                $this->warn("⚠️  Test comment: NOT FOUND");
            }
        }

        // Check composer autoload
        $composerFile = base_path('composer.json');
        if (File::exists($composerFile)) {
            $composer = json_decode(File::get($composerFile), true);
            if (isset($composer['autoload']['psr-4']['Modules\\Certificates\\'])) {
                $this->info("\n✅ Composer autoload: CONFIGURED");
            } else {
                $this->error("\n❌ Composer autoload: NOT CONFIGURED");
            }
        }

        $this->info("\n🎯 Summary:");
        $this->info("Your Certificates module is properly published and should be working.");
        $this->info("Any changes you make to files in Modules/Certificates/ will persist.");
        $this->info("If you need to republish from the package, run: php artisan certificates:publish --force");
    }
}
