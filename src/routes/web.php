<?php

use Illuminate\Support\Facades\Route;
use admin\certificates\Controllers\CertificateController;

// Admin routes - these will be prefixed with 'admin' and use 'admin.auth' middleware
Route::name('admin.')->middleware(['web', 'admin.auth'])->group(function () {
    Route::resource('certificates', CertificateController::class);
    Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])
        ->name('certificates.download');
    Route::post('certificates/bulk-delete', [CertificateController::class, 'bulkDelete'])
        ->name('certificates.bulk-delete');
    Route::get('certificates-export', [CertificateController::class, 'export'])
        ->name('certificates.export');
    Route::post('certificates/updateStatus', [CertificateController::class, 'updateStatus'])
        ->name('certificates.updateStatus');
});
