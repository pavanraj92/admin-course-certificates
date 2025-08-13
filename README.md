# Certificate Management Package
A comprehensive Laravel package for managing student certificates with verification capabilities.
---

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

## Requirements

- PHP >=8.2
- Laravel Framework >= 12.x

---
## Installation

1. **Add Git Repository to `composer.json`**:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/pavanraj92/admin-course-certificates.git"
    }
]
```

### 2. Require the package via Composer
    ```bash
    composer require admin/certificates:@dev
    ```

### 3. Publish assets
    ```bash
    php artisan certificates:publish --force
    ```
---

## Usage

The package provides the following routes:

### Admin Panel Routes
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET    | `/certificates` | List all certificates |
| GET    | `/certificates/create` | Create certificate form |
| POST   | `/certificates` | Store new certificate |
| GET    | `/certificates/{id}` | Show certificate details |
| GET    | `/certificates/{id}/edit` | Edit certificate form |
| PUT    | `/certificates/{id}` | Update certificate |
| DELETE | `/certificates/{id}` | Delete certificate |
---

## Protecting Admin Routes

Protect your routes using the provided middleware:

```php
Route::middleware(['web','admin.auth'])->group(function () {
    // Admin certificate routes here
});
```
---

## Database Tables
- `certificates` - Stores certificates details.
---

## License

This package is open-sourced software licensed under the MIT license.
