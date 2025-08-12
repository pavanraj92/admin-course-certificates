<?php

namespace admin\certificates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Config;


class Certificate extends Model
{
    use HasFactory, Sortable, SoftDeletes;

    protected $fillable = [
        'certificate_number',
        'student_name',
        'student_email',
        'student_phone',
        'course_name',
        'course_code',
        'course_start_date',
        'course_end_date',
        'course_duration',
        'instructor_name',
        'grade',
        'score',
        'issue_date',
        'expiry_date',
        'description',
        'certificate_file',
        'verification_code',
        'status',
        'notes',
        'deleted_at'
    ];

    protected $dates = [
        'course_start_date',
        'course_end_date',
        'issue_date',
        'expiry_date',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'course_duration' => 'integer',
        'score' => 'decimal:2',
        'status' => 'string',
        'issue_date'  => 'datetime',
        'expiry_date' => 'datetime',
        'course_start_date' => 'datetime',
        'course_end_date' => 'datetime',
    ];

    protected $sortable = [
        'certificate_number',
        'student_name',
        'student_email',
        'course_name',
        'issue_date',
        'expiry_date',
        'created_at',
        'updated_at',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($certificate) {
            if (empty($certificate->certificate_number)) {
                $certificate->certificate_number = 'CERT-' . date('Y') . '-' . str_pad(static::count() + 1, 6, '0', STR_PAD_LEFT);
            }

            if (empty($certificate->verification_code)) {
                $certificate->verification_code = Str::random(32);
            }
        });
    }

    public function scopeFilter($query, $keyword)
    {
        if ($keyword) {
            return $query->where('student_name', 'like', "%{$keyword}%")
                ->orWhere('student_email', 'like', "%{$keyword}%")
                ->orWhere('course_name', 'like', "%{$keyword}%")
                ->orWhere('certificate_number', 'like', "%{$keyword}%");
        }
        return $query;
    }

    public function scopeFilterByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    public static function getPerPageLimit(): int
    {
        return Config::has('get.admin_page_limit')
            ? Config::get('get.admin_page_limit')
            : 10;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="badge bg-success">Active</span>',
            'expired' => '<span class="badge bg-warning">Expired</span>',
            'revoked' => '<span class="badge bg-danger">Revoked</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    public function getVerificationUrlAttribute()
    {
        return url('/verify-certificate/' . $this->verification_code);
    }

    public function isActive()
    {
        return $this->status === 'active' &&
            (!$this->expiry_date || $this->expiry_date >= now());
    }

    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date < now();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByStudent($query, $email)
    {
        return $query->where('student_email', $email);
    }

    public function scopeByCourse($query, $courseCode)
    {
        return $query->where('course_code', $courseCode);
    }
}
