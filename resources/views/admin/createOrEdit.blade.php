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
                                        placeholder="Enter student name">
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
                                        placeholder="Enter student email">
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
                                        placeholder="Enter course name">
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
                                        placeholder="Enter instructor name">
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
                                    <input type="text" name="course_start_date" id="course_start_date" class="form-control"
                                        value="{{ old('course_start_date', isset($certificate) ? ($certificate->course_start_date ? (is_string($certificate->course_start_date) ? $certificate->course_start_date : $certificate->course_start_date->format('Y-m-d')) : '') : '') }}"
                                        placeholder="Select course start date">
                                    @error('course_start_date')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Course End Date <span class="text-danger">*</span></label>
                                    <input type="text" name="course_end_date" id="course_end_date" class="form-control"
                                        value="{{ old('course_end_date', isset($certificate) ? ($certificate->course_end_date ? (is_string($certificate->course_end_date) ? $certificate->course_end_date : $certificate->course_end_date->format('Y-m-d')) : '') : '') }}"
                                        placeholder="Select course end date">
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
                                        placeholder="Enter duration in hours" min="1">
                                    @error('course_duration')
                                    <div class="text-danger validation-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Issue Date <span class="text-danger">*</span></label>
                                    <input type="text" name="issue_date" id="issue_date" class="form-control"
                                        value="{{ old('issue_date', isset($certificate) ? ($certificate->issue_date ? (is_string($certificate->issue_date) ? $certificate->issue_date : $certificate->issue_date->format('Y-m-d')) : date('Y-m-d')) : date('Y-m-d')) }}"
                                        placeholder="Select issue date">
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
                                {{ isset($certificate) ? 'Update' : 'Save' }}
                            </button>
                            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">
                                Back
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
                            <select name="status" id="status" class="form-control">
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
                            <input type="text" name="expiry_date" id="expiry_date" class="form-control"
                                value="{{ old('expiry_date', isset($certificate) ? ($certificate->expiry_date ? (is_string($certificate->expiry_date) ? $certificate->expiry_date : $certificate->expiry_date->format('Y-m-d')) : '') : '') }}"
                                placeholder="Select expiry date">
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
<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
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
    
    .client-validation-error {
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(document).ready(function() {    
    // Open datepicker on click for all date fields
    $('#course_start_date, #course_end_date, #issue_date, #expiry_date').on('focus click', function() {
        $(this).datepicker('show');
    });
    // Client-side validation functions
    function showError(inputId, message) {
        const input = $('#' + inputId);
        const errorDiv = input.next('.client-validation-error');
        
        if (errorDiv.length) {
            errorDiv.text(message);
        } else {
            input.after('<div class="text-danger client-validation-error mt-1" style="font-size: 12px;">' + message + '</div>');
        }
    }

    // Initialize jQuery UI datepicker for all date fields, disabling dates before today
    var today = new Date();
    var minDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    function customizeDatepickerButtons(input, inst) {
        setTimeout(function() {
            var buttonPane = $(inst.dpDiv).find('.ui-datepicker-buttonpane');
            buttonPane.find('.ui-datepicker-close').hide();
            buttonPane.find('.ui-datepicker-current').hide(); // Hide Today button
            // Remove any existing clear buttons to avoid duplicates
            buttonPane.find('.ui-datepicker-clear').remove();
            $('<button type="button" class="ui-datepicker-clear ui-state-default ui-priority-primary ui-corner-all" style="margin-left:8px;">Clear</button>')
                .appendTo(buttonPane)
                .on('click', function() {
                    $(input).val('');
                    $(input).datepicker('hide');
                });
        }, 1);
    }

    $('#course_start_date, #course_end_date, #issue_date, #expiry_date').datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        autoclose: true,
        minDate: minDate,
        beforeShow: customizeDatepickerButtons,
        onChangeMonthYear: function(year, month, inst) {
            var input = inst.input ? inst.input[0] : null;
            if (input) customizeDatepickerButtons(input, inst);
        },
        onSelect: function(dateText, inst) {
            var input = inst.input ? inst.input[0] : null;
            if (input) customizeDatepickerButtons(input, inst);
        }
    });
    
    function clearError(inputId) {
        const input = $('#' + inputId);
        input.next('.client-validation-error').remove();
    }
    
    // Real-time validation for Student Name
    $('#student_name').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value === '') {
            showError('student_name', 'Student name is required.');
        } else if (value.length < 2) {
            showError('student_name', 'Student name must be at least 2 characters.');
        } else if (value.length > 255) {
            showError('student_name', 'Student name must not exceed 255 characters.');
        } else {
            clearError('student_name');
        }
    });
    
    // Real-time validation for Student Email
    $('#student_email').on('blur keyup', function() {
        const value = $(this).val().trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (value === '') {
            showError('student_email', 'Student email is required.');
        } else if (!emailRegex.test(value)) {
            showError('student_email', 'Please enter a valid email address.');
        } else if (value.length > 255) {
            showError('student_email', 'Email must not exceed 255 characters.');
        } else {
            clearError('student_email');
        }
    });
    
    // Real-time validation for Student Phone
    $('#student_phone').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value !== '' && value.length > 20) {
            showError('student_phone', 'Phone number must not exceed 20 characters.');
        } else {
            clearError('student_phone');
        }
    });
    
    // Real-time validation for Course Name
    $('#course_name').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value === '') {
            showError('course_name', 'Course name is required.');
        } else if (value.length < 2) {
            showError('course_name', 'Course name must be at least 2 characters.');
        } else if (value.length > 255) {
            showError('course_name', 'Course name must not exceed 255 characters.');
        } else {
            clearError('course_name');
        }
    });
    
    // Real-time validation for Course Code
    $('#course_code').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value !== '' && value.length > 50) {
            showError('course_code', 'Course code must not exceed 50 characters.');
        } else {
            clearError('course_code');
        }
    });
    
    // Real-time validation for Instructor Name
    $('#instructor_name').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value === '') {
            showError('instructor_name', 'Instructor name is required.');
        } else if (value.length < 2) {
            showError('instructor_name', 'Instructor name must be at least 2 characters.');
        } else if (value.length > 255) {
            showError('instructor_name', 'Instructor name must not exceed 255 characters.');
        } else {
            clearError('instructor_name');
        }
    });
    
    // Real-time validation for Course Start Date
    $('#course_start_date').on('blur change', function() {
        const value = $(this).val();
        if (value === '') {
            showError('course_start_date', 'Course start date is required.');
        } else {
            clearError('course_start_date');
            // Check end date if it exists
            validateDateRange();
        }
    });
    
    // Real-time validation for Course End Date
    $('#course_end_date').on('blur change', function() {
        const value = $(this).val();
        if (value === '') {
            showError('course_end_date', 'Course end date is required.');
        } else {
            clearError('course_end_date');
            validateDateRange();
        }
    });
    
    // Validate date range
    function validateDateRange() {
        const startDate = $('#course_start_date').val();
        const endDate = $('#course_end_date').val();
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            
            if (end < start) {
                showError('course_end_date', 'Course end date must be after or equal to start date.');
            } else {
                clearError('course_end_date');
            }
        }
    }
    
    // Real-time validation for Course Duration
    $('#course_duration').on('blur keyup', function() {
        const value = $(this).val();
        if (value === '') {
            showError('course_duration', 'Course duration is required.');
        } else if (parseInt(value) < 1) {
            showError('course_duration', 'Course duration must be at least 1 hour.');
        } else if (parseInt(value) > 10000) {
            showError('course_duration', 'Course duration seems to high. Please check.');
        } else {
            clearError('course_duration');
        }
    });
    
    // Real-time validation for Issue Date
    $('#issue_date').on('blur change', function() {
        const value = $(this).val();
        if (value === '') {
            showError('issue_date', 'Issue date is required.');
        } else {
            clearError('issue_date');
            validateExpiryDate();
        }
    });
    
    // Real-time validation for Expiry Date
    $('#expiry_date').on('blur change', function() {
        validateExpiryDate();
    });
    
    // Validate expiry date
    function validateExpiryDate() {
        const issueDate = $('#issue_date').val();
        const expiryDate = $('#expiry_date').val();
        
        if (issueDate && expiryDate) {
            const issue = new Date(issueDate);
            const expiry = new Date(expiryDate);
            
            if (expiry <= issue) {
                showError('expiry_date', 'Expiry date must be after issue date.');
            } else {
                clearError('expiry_date');
            }
        } else if (expiryDate) {
            clearError('expiry_date');
        }
    }
    
    // Real-time validation for Grade
    $('#grade').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value !== '' && value.length > 10) {
            showError('grade', 'Grade must not exceed 10 characters.');
        } else {
            clearError('grade');
        }
    });
    
    // Real-time validation for Score
    $('#score').on('blur keyup', function() {
        const value = $(this).val();
        if (value !== '') {
            const score = parseFloat(value);
            if (isNaN(score)) {
                showError('score', 'Score must be a valid number.');
            } else if (score < 0) {
                showError('score', 'Score must be at least 0.');
            } else if (score > 100) {
                showError('score', 'Score must not exceed 100.');
            } else {
                clearError('score');
            }
        } else {
            clearError('score');
        }
    });
    
    // Real-time validation for Status
    $('#status').on('blur change', function() {
        const value = $(this).val();
        if (value === '') {
            showError('status', 'Status is required.');
        } else {
            clearError('status');
        }
    });
    
    // Real-time validation for Description
    $('#description').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value.length > 1000) {
            showError('description', 'Description must not exceed 1000 characters.');
        } else {
            clearError('description');
        }
    });
    
    // Real-time validation for Notes
    $('#notes').on('blur keyup', function() {
        const value = $(this).val().trim();
        if (value.length > 500) {
            showError('notes', 'Notes must not exceed 500 characters.');
        } else {
            clearError('notes');
        }
    });
    
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
            
            var isEditMode = {{ isset($certificate) ? 'true' : 'false' }};
            // Fix: Output as JS boolean, not raw Blade
            var isEditMode = @json(isset($certificate));
            
            if (!isEditMode) {
                if (!$('#course_duration').val()) {
                    $('#course_duration').val(estimatedHours);
                }
            } else {
                if (confirm('Based on the dates, estimated duration is ' + estimatedHours + ' hours. Update the duration field?')) {
                    $('#course_duration').val(estimatedHours);
                }
            }
        }
    });

    // File validation
    $('#certificate_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            if (file.type !== 'application/pdf') {
                showError('certificate_file', 'Please select a PDF file.');
                $(this).val('');
                return;
            }
            
            if (file.size > 10 * 1024 * 1024) { // 10MB
                showError('certificate_file', 'File size must be less than 10MB.');
                $(this).val('');
                return;
            }
            
            clearError('certificate_file');
        }
    });

    // Download link handling
    $('.download-link').on('click', function(e) {
        e.stopPropagation();
        return true;
    });

    // Form submission handling with validation
    $('#certificateForm').on('submit', function(e) {
        // Clear all previous errors
        $('.client-validation-error').remove();
        
        var hasErrors = false;
        
        // Validate all required fields on submit
        if ($('#student_name').val().trim() === '') {
            showError('student_name', 'Student name is required.');
            hasErrors = true;
        }
        
        if ($('#student_email').val().trim() === '') {
            showError('student_email', 'Student email is required.');
            hasErrors = true;
        }
        
        if ($('#course_name').val().trim() === '') {
            showError('course_name', 'Course name is required.');
            hasErrors = true;
        }
        
        if ($('#instructor_name').val().trim() === '') {
            showError('instructor_name', 'Instructor name is required.');
            hasErrors = true;
        }
        
        if ($('#course_start_date').val() === '') {
            showError('course_start_date', 'Course start date is required.');
            hasErrors = true;
        }
        
        if ($('#course_end_date').val() === '') {
            showError('course_end_date', 'Course end date is required.');
            hasErrors = true;
        }
        
        if ($('#course_duration').val() === '') {
            showError('course_duration', 'Course duration is required.');
            hasErrors = true;
        }
        
        if ($('#issue_date').val() === '') {
            showError('issue_date', 'Issue date is required.');
            hasErrors = true;
        }
        
        if ($('#status').val() === '') {
            showError('status', 'Status is required.');
            hasErrors = true;
        }
        
        if (hasErrors) {
            e.preventDefault();
            // Scroll to first error
            $('html, body').animate({
                scrollTop: $('.client-validation-error').first().offset().top - 100
            }, 500);
            return false;
        }
        
        $('#saveBtn').prop('disabled', true)
                     .html('<i class="mdi mdi-loading mdi-spin"></i> Saving...');
    });
});
</script>
@endpush
