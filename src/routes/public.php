<?php

use Illuminate\Support\Facades\Route;
use admin\certificates\Controllers\CertificateController;

// Public verification route (no auth required)
Route::get('verify-certificate/{verificationCode}', [CertificateController::class, 'verify'])
    ->name('certificates.verify');
