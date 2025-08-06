@extends('admin::admin.layouts.master')

@section('title', 'Certificates Management')

@section('page-title', isset($certificate) ? 'Edit Certificate' : 'Create Certificate')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.certificates.index') }}">Certificate Manager</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ isset($certificate) ? 'Edit Certificate' : 'Create Certificate' }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Start Certificate Content -->
    <form action="{{ isset($certificate) ? route('admin.certificates.update', $certificate) : route('admin.certificates.store') }}"
        method="POST" enctype="multipart/form-data" id="certificateForm">
        @csrf
        @if(isset($certificate))
        @method('PUT')
        @endif

        <div class="row">
            <div class="col-8">
                <!-- card section -->
                <div class="card bg-white">
                    <!--card header section -->
                    <div class="card-header bg-white border-bottom border-gray-200">
                        <h4 class="card-title">
                            Certificate Information
                        </h4>
                    </div>
                    <!--card body section -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Student Name <span class="text-danger">*</span></label>
                                    <input type="text" name="student_name" id="student_name" class="form-control"
                                        value="{{ old('student_name', $certificate->student_name ?? '') }}"
                                        placeholder="Enter student name" required>
                                    @error('student_name')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Student Email <span class="text-danger">*</span></label>
                                    <input type="email" name="student_email" id="student_email" class="form-control"
                                        value="{{ old('student_email', $certificate->student_email ?? '') }}"
                                        placeholder="Enter student email" required>
                                    @error('student_email')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Student Phone</label>
                                    <input type="text" name="student_phone" id="student_phone" class="form-control"
                                        value="{{ old('student_phone', $certificate->student_phone ?? '') }}"
                                        placeholder="Enter student phone">
                                    @error('student_phone')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Name <span class="text-danger">*</span></label>
                                    <input type="text" name="course_name" id="course_name" class="form-control"
                                        value="{{ old('course_name', $certificate->course_name ?? '') }}"
                                        placeholder="Enter course name" required>
                                    @error('course_name')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Code</label>
                                    <input type="text" name="course_code" id="course_code" class="form-control"
                                        value="{{ old('course_code', $certificate->course_code ?? '') }}"
                                        placeholder="Enter course code">
                                    @error('course_code')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Instructor Name <span class="text-danger">*</span></label>
                                    <input type="text" name="instructor_name" id="instructor_name" class="form-control"
                                        value="{{ old('instructor_name', $certificate->instructor_name ?? '') }}"
                                        placeholder="Enter instructor name" required>
                                    @error('instructor_name')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="course_start_date" id="course_start_date" class="form-control"
                                        value="{{ old('course_start_date', isset($certificate) ? ($certificate->course_start_date ? (is_string($certificate->course_start_date) ? $certificate->course_start_date : $certificate->course_start_date->format('Y-m-d')) : '') : '') }}" required>
                                    @error('course_start_date')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course End Date <span class="text-danger">*</span></label>
                                    <input type="date" name="course_end_date" id="course_end_date" class="form-control"
                                        value="{{ old('course_end_date', isset($certificate) ? ($certificate->course_end_date ? (is_string($certificate->course_end_date) ? $certificate->course_end_date : $certificate->course_end_date->format('Y-m-d')) : '') : '') }}" required>
                                    @error('course_end_date')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Duration (Hours) <span class="text-danger">*</span></label>
                                    <input type="number" name="course_duration" id="course_duration" class="form-control"
                                        value="{{ old('course_duration', $certificate->course_duration ?? '') }}"
                                        placeholder="Enter duration in hours" min="1" required>
                                    @error('course_duration')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Issue Date <span class="text-danger">*</span></label>
                                    <input type="date" name="issue_date" id="issue_date" class="form-control"
                                        value="{{ old('issue_date', isset($certificate) ? ($certificate->issue_date ? (is_string($certificate->issue_date) ? $certificate->issue_date : $certificate->issue_date->format('Y-m-d')) : date('Y-m-d')) : date('Y-m-d')) }}" required>
                                    @error('issue_date')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Grade</label>
                                    <input type="text" name="grade" id="grade" class="form-control"
                                        value="{{ old('grade', $certificate->grade ?? '') }}"
                                        placeholder="e.g., A+, B, Pass">
                                    @error('grade')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Score (%)</label>
                                    <input type="number" name="score" id="score" class="form-control"
                                        value="{{ old('score', $certificate->score ?? '') }}"
                                        placeholder="Enter score percentage" min="0" max="100" step="0.01">
                                    @error('score')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="description" class="form-control" rows="4"
                                placeholder="Additional certificate details...">{{ old('description', $certificate->description ?? '') }}</textarea>
                            @error('description')
                            <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="saveBtn">
                                <i class="mdi mdi-content-save"></i>
                                {{ isset($certificate) ? 'Update Certificate' : 'Save Certificate' }}
                            </button>
                            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->

            <div class="col-4">
                <!-- Status and Options Card -->
                <div class="card bg-white">
                    <!--card header section -->
                    <div class="card-header bg-white border-bottom border-gray-200">
                        <h4 class="card-title">
                            Status & Options
                        </h4>
                    </div>
                    <!--card body section -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ (old('status', $certificate->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                                <option value="expired" {{ (old('status', $certificate->status ?? '') == 'expired') ? 'selected' : '' }}>Expired</option>
                                <option value="revoked" {{ (old('status', $certificate->status ?? '') == 'revoked') ? 'selected' : '' }}>Revoked</option>
                            </select>
                            @error('status')
                            <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="date" name="expiry_date" id="expiry_date" class="form-control"
                                value="{{ old('expiry_date', isset($certificate) ? ($certificate->expiry_date ? (is_string($certificate->expiry_date) ? $certificate->expiry_date : $certificate->expiry_date->format('Y-m-d')) : '') : '') }}">
                            @error('expiry_date')
                            <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"
                                placeholder="Internal notes...">{{ old('notes', $certificate->notes ?? '') }}</textarea>
                            @error('notes')
                            <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Certificate File Card -->
                <div class="card bg-white">
                    <!--card header section -->
                    <div class="card-header bg-white border-bottom border-gray-200">
                        <h4 class="card-title">
                            Certificate File
                        </h4>
                    </div>
                    <!--card body section -->
                    <div class="card-body">
                        <div class="form-group">
                            <label>Certificate File (PDF)</label>
                            @if(isset($certificate) && $certificate->certificate_file)
                                <div class="mb-2">
                                    <div class="existing-file">
                                        <a href="{{ route('admin.certificates.download', $certificate) }}" 
                                           class="btn btn-sm btn-info download-link">
                                            <i class="mdi mdi-download"></i> Download Current File
                                        </a>
                                        <small class="text-muted d-block mt-1">{{ basename($certificate->certificate_file) }}</small>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="certificate_file" id="certificate_file" class="form-control"
                                accept=".pdf">
                            <div class="form-text">Maximum file size: 10MB. Only PDF files are allowed.{{ isset($certificate) ? ' Leave empty to keep current file.' : '' }}</div>
                            @error('certificate_file')
                            <div class="text-danger validation-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if(isset($certificate))
                <!-- Certificate Information Card -->
                <div class="card bg-white">
                    <!--card header section -->
                    <div class="card-header bg-white border-bottom border-gray-200">
                        <h4 class="card-title">
                            Certificate Info
                        </h4>
                    </div>
                    <!--card body section -->
                    <div class="card-body">
                        <div class="certificate-info">
                            <p class="mb-2"><strong>Certificate Number:</strong><br>{{ $certificate->certificate_number }}</p>
                            <p class="mb-2"><strong>Verification Code:</strong><br><code>{{ $certificate->verification_code }}</code></p>
                            <p class="mb-0"><strong>Verification URL:</strong><br>
                                <a href="{{ $certificate->verification_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="mdi mdi-open-in-new"></i> Verify Certificate
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </form>
    <!-- End Certificate Content -->
</div>
@endsection

@push('styles')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Custom CSS -->
<style>
    .existing-file {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }

    .certificate-info p {
        word-wrap: break-word;
    }

    .certificate-info code {
        background: #f8f9fa;
        padding: 2px 4px;
        border-radius: 3px;
        font-size: 12px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Simple form handling without conflicts
    console.log('Certificate form initialized');
    
    // Auto-calculate duration when dates change
    $('#course_start_date, #course_end_date').on('change', function() {
        const startDate = $('#course_start_date').val();
        const endDate = $('#course_end_date').val();
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            const estimatedHours = diffDays * 8;
            
            @if(!isset($certificate))
                if (!$('#course_duration').val()) {
                    $('#course_duration').val(estimatedHours);
                }
            @else
                if (confirm('Based on the dates, estimated duration is ' + estimatedHours + ' hours. Update the duration field?')) {
                    $('#course_duration').val(estimatedHours);
                }
            @endif
        }
    });

    // File validation
    $('#certificate_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                alert('Please select a PDF file.');
                $(this).val('');
                return;
            }
            
            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('File size must be less than 10MB.');
                $(this).val('');
                return;
            }
        }
    });

    // Download link handling
    $('.download-link').on('click', function(e) {
        e.stopPropagation();
        return true;
    });

    // Form submission handling
    $('#certificateForm').on('submit', function() {
        $('#saveBtn').prop('disabled', true)
                     .html('<i class="mdi mdi-loading mdi-spin"></i> Saving...');
    });
});
</script>
@endpush
