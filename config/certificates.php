<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Certificate Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the certificate
    | management package.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Certificate Number Format
    |--------------------------------------------------------------------------
    |
    | Configure how certificate numbers are generated.
    |
    */
    'certificate_number' => [
        'prefix' => 'CERT',
        'year_format' => 'Y', // Y for 4-digit year, y for 2-digit
        'padding' => 6, // Number of digits for sequential number
        'separator' => '-',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configure file upload restrictions and storage.
    |
    */
    'file_upload' => [
        'max_size' => 10240, // Maximum file size in KB (10MB)
        'allowed_types' => ['pdf'],
        'storage_disk' => 'public',
        'storage_path' => 'certificates',
    ],

    /*
    |--------------------------------------------------------------------------
    | Verification Settings
    |--------------------------------------------------------------------------
    |
    | Configure certificate verification options.
    |
    */
    'verification' => [
        'code_length' => 32,
        'public_route_enabled' => true,
        'cache_verification_results' => true,
        'cache_duration' => 3600, // 1 hour in seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Settings
    |--------------------------------------------------------------------------
    |
    | Configure pagination for certificate listings.
    |
    */
    'pagination' => [
        'per_page' => 15,
        'show_pagination_info' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Export Settings
    |--------------------------------------------------------------------------
    |
    | Configure export functionality.
    |
    */
    'export' => [
        'formats' => ['csv'],
        'filename_prefix' => 'certificates',
        'include_timestamp' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Status Options
    |--------------------------------------------------------------------------
    |
    | Define available certificate statuses.
    |
    */
    'statuses' => [
        'active' => 'Active',
        'expired' => 'Expired',
        'revoked' => 'Revoked',
    ],

    /*
    |--------------------------------------------------------------------------
    | Grade Options
    |--------------------------------------------------------------------------
    |
    | Define common grade options for certificates.
    |
    */
    'grades' => [
        'A+' => 'A+',
        'A' => 'A',
        'A-' => 'A-',
        'B+' => 'B+',
        'B' => 'B',
        'B-' => 'B-',
        'C+' => 'C+',
        'C' => 'C',
        'C-' => 'C-',
        'D' => 'D',
        'F' => 'F',
        'Pass' => 'Pass',
        'Fail' => 'Fail',
        'Distinction' => 'Distinction',
        'Merit' => 'Merit',
        'Credit' => 'Credit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Values
    |--------------------------------------------------------------------------
    |
    | Default values for new certificates.
    |
    */
    'defaults' => [
        'status' => 'active',
        'course_duration' => 40, // Default course duration in hours
        'score_passing' => 70, // Minimum passing score
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    |
    | Configure UI elements and styling.
    |
    */
    'ui' => [
        'theme_color' => 'primary',
        'show_verification_qr' => false,
        'show_student_photos' => false,
        'enable_bulk_operations' => true,
        'enable_advanced_search' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Notifications
    |--------------------------------------------------------------------------
    |
    | Configure email notifications for certificates.
    |
    */
    'notifications' => [
        'enabled' => false,
        'send_on_create' => false,
        'send_on_update' => false,
        'send_expiry_reminders' => false,
        'expiry_reminder_days' => [30, 7, 1], // Days before expiry to send reminders
    ],

    /*
    |--------------------------------------------------------------------------
    | Integration Settings
    |--------------------------------------------------------------------------
    |
    | Configure integrations with other systems.
    |
    */
    'integrations' => [
        'spatie_permission' => true, // Enable Spatie Laravel Permission integration
        'course_management' => false, // Enable course management integration
        'student_management' => false, // Enable student management integration
    ],
];
