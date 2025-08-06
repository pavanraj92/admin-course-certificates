<?php

namespace admin\certificates\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateCertificateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can add authorization logic here
    }

    public function rules()
    {
        return [
            'student_name' => 'required|string|max:255',
            'student_email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    // Check if email exists in users table
                    $user = DB::table('users')
                        ->join('user_roles', 'users.role_id', '=', 'user_roles.id')
                        ->where('users.email', $value)
                        ->whereIn('user_roles.slug', ['student', 'customer']) // Accept both student and customer roles
                        ->where('users.status', 'active') // assuming you want active users only
                        ->first();
                    
                    if (!$user) {
                        $fail('This email must belong to a registered student/customer in the system.');
                    }
                }
            ],
            'student_phone' => 'nullable|string|max:20',
            'course_name' => 'required|string|max:255',
            'course_code' => 'nullable|string|max:50',
            'course_start_date' => 'required|date',
            'course_end_date' => 'required|date|after_or_equal:course_start_date',
            'course_duration' => 'required|integer|min:1',
            'instructor_name' => 'required|string|max:255',
            'grade' => 'nullable|string|max:10',
            'score' => 'nullable|numeric|min:0|max:100',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'description' => 'nullable|string',
            'certificate_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'status' => 'required|in:active,expired,revoked',
            'notes' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'student_name.required' => 'Student name is required.',
            'student_email.required' => 'Student email is required.',
            'student_email.email' => 'Please enter a valid email address.',
            'student_email.exists' => 'This email must belong to a registered student in the system.',
            'course_name.required' => 'Course name is required.',
            'course_start_date.required' => 'Course start date is required.',
            'course_end_date.required' => 'Course end date is required.',
            'course_end_date.after_or_equal' => 'Course end date must be after or equal to start date.',
            'course_duration.required' => 'Course duration is required.',
            'course_duration.min' => 'Course duration must be at least 1 hour.',
            'instructor_name.required' => 'Instructor name is required.',
            'issue_date.required' => 'Issue date is required.',
            'expiry_date.after' => 'Expiry date must be after issue date.',
            'certificate_file.mimes' => 'Certificate file must be a PDF.',
            'certificate_file.max' => 'Certificate file must not exceed 10MB.',
            'score.min' => 'Score must be at least 0.',
            'score.max' => 'Score must not exceed 100.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be active, expired, or revoked.'
        ];
    }
}
