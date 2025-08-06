# Certificate Management Package

A comprehensive Laravel package for managing student certificates with verification capabilities.

## Features

- **Complete CRUD Operations**: Create, read, update, and delete certificates
- **Student Management**: Store student information with contact details
- **Course Information**: Track course details, duration, and instructor information
- **Assessment Results**: Record grades and scores with visual progress indicators
- **Certificate Verification**: Public verification system with unique codes
- **File Management**: Upload and download PDF certificates
- **Status Tracking**: Active, expired, and revoked certificate statuses
- **Bulk Operations**: Select and delete multiple certificates
- **Export Functionality**: Export certificate data to CSV
- **Search & Filter**: Advanced filtering by status, course, date range
- **Responsive Design**: Mobile-friendly interface with Bootstrap
- **Permission System**: Role-based access control integration

## Installation

1. **Add to composer.json**:
```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/admin/certificates"
        }
    ],
    "require": {
        "admin/certificates": "*"
    }
}
```

2. **Install the package**:
```bash
composer update
```

3. **Register the service provider** in `config/app.php`:
```php
'providers' => [
    // ...
    admin\certificates\CertificateServiceProvider::class,
],
```

4. **Publish and run migrations**:
```bash
php artisan vendor:publish --tag=certificate
php artisan migrate
```

5. **Publish config (optional)**:
```bash
php artisan vendor:publish --tag=certificates-config
```

## Usage

### Routes

The package provides the following routes:

**Admin Routes (requires authentication):**
- `GET /admin/certificates` - List all certificates
- `GET /admin/certificates/create` - Create new certificate form
- `POST /admin/certificates` - Store new certificate
- `GET /admin/certificates/{certificate}` - View certificate details
- `GET /admin/certificates/{certificate}/edit` - Edit certificate form
- `PUT /admin/certificates/{certificate}` - Update certificate
- `DELETE /admin/certificates/{certificate}` - Delete certificate
- `GET /admin/certificates/{certificate}/download` - Download certificate PDF
- `POST /admin/certificates/bulk-delete` - Bulk delete certificates
- `GET /admin/certificates-export` - Export certificates to CSV

**Public Routes:**
- `GET /verify-certificate/{verificationCode}` - Public certificate verification

### Models

**Certificate Model:**
```php
use admin\certificates\Models\Certificate;

// Create a certificate
$certificate = Certificate::create([
    'student_name' => 'John Doe',
    'student_email' => 'john@example.com',
    'course_name' => 'Laravel Development',
    'course_start_date' => '2024-01-01',
    'course_end_date' => '2024-01-31',
    'course_duration' => 120,
    'instructor_name' => 'Jane Smith',
    'grade' => 'A+',
    'score' => 95.5,
    'issue_date' => '2024-02-01',
    'status' => 'active'
]);

// The certificate_number and verification_code are auto-generated
```

### Database Schema

The certificates table includes:
- `id` - Primary key
- `certificate_number` - Unique certificate identifier (auto-generated)
- `student_name` - Student's full name
- `student_email` - Student's email address
- `student_phone` - Student's phone number (optional)
- `course_name` - Name of the course
- `course_code` - Course code identifier (optional)
- `course_start_date` - Course start date
- `course_end_date` - Course end date
- `course_duration` - Course duration in hours
- `instructor_name` - Name of the instructor
- `grade` - Grade achieved (optional)
- `score` - Numerical score (0-100, optional)
- `issue_date` - Certificate issue date
- `expiry_date` - Certificate expiry date (optional)
- `description` - Additional description (optional)
- `certificate_file` - Path to uploaded PDF certificate
- `verification_code` - Unique verification code (auto-generated)
- `status` - Certificate status (active, expired, revoked)
- `notes` - Internal notes (optional)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Configuration

**File Storage:**
The package uses Laravel's storage system. Ensure your `filesystems.php` is configured properly:

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

Run `php artisan storage:link` to create the symbolic link.

### Customization

**Views:**
All views can be customized by publishing them:
```bash
php artisan vendor:publish --tag=certificate
```

Views will be published to `Modules/Certificates/resources/views/`

**Layouts:**
The package assumes you have an admin layout at `admin.layouts.master`. Update the `@extends` directive in published views if your layout path is different.

**Permissions:**
The package integrates with Spatie Laravel Permission. Customize the permissions in the seeder as needed.

## API

### Certificate Model Methods

```php
// Check if certificate is active
$certificate->isActive(); // returns boolean

// Check if certificate is expired
$certificate->isExpired(); // returns boolean

// Get formatted status badge (HTML)
$certificate->status_badge; // returns HTML badge

// Get public verification URL
$certificate->verification_url; // returns full URL

// Scopes
Certificate::active()->get(); // Get active certificates
Certificate::byStudent('john@example.com')->get(); // Get certificates for student
Certificate::byCourse('LARAVEL-101')->get(); // Get certificates for course
```

### Certificate Controller Methods

The controller provides standard CRUD operations plus:
- `download()` - Download certificate PDF
- `verify()` - Public verification page
- `bulkDelete()` - Delete multiple certificates
- `export()` - Export to CSV

## Security

- File uploads are restricted to PDF files only (max 10MB)
- Verification codes are cryptographically secure random strings
- Public verification pages don't expose sensitive information
- Admin routes require authentication middleware
- Permission-based access control (when using Spatie Permission)

## Requirements

- PHP >= 7.4
- Laravel >= 8.0
- Bootstrap 5.x (for styling)
- Font Awesome 6.x (for icons)

## License

This package is open-sourced software licensed under the MIT license.

## Support

For support, please contact your system administrator or create an issue in the project repository.
