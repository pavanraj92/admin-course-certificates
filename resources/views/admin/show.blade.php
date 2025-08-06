@extends('admin::admin.layouts.master')

@section('title', 'View Certificate - ' . $certificate->student_name)

@section('page-title', 'Certificate Details')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.certificates.index') }}">Certificates</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $certificate->student_name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 class="card-title mb-0">{{ $certificate->student_name }} - {{ $certificate->certificate_number }}</h4>
                        <div>
                            <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary ml-2">
                                <i class="mdi mdi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white font-bold">Certificate Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Certificate Number:</label>
                                                <p><strong>{{ $certificate->certificate_number }}</strong></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Verification Code:</label>
                                                <p><code>{{ $certificate->verification_code }}</code></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Issue Date:</label>
                                                <p>
                                                    @php
                                                    try {
                                                    echo $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date)->format('F d, Y') : 'N/A';
                                                    } catch (\Exception $e) {
                                                    echo $certificate->issue_date ?? 'N/A';
                                                    }
                                                    @endphp
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @if($certificate->expiry_date)
                                            <div class="form-group">
                                                <label class="font-weight-bold">Expiry Date:</label>
                                                <p>
                                                    @php
                                                    try {
                                                    echo $certificate->expiry_date ? \Carbon\Carbon::parse($certificate->expiry_date)->format('F d, Y') : 'N/A';
                                                    } catch (\Exception $e) {
                                                    echo $certificate->expiry_date ?? 'N/A';
                                                    }
                                                    @endphp
                                                </p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Name:</label>
                                                <p>{{ $certificate->student_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Student Email:</label>
                                                <p>{{ $certificate->student_email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if($certificate->course_name)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Course Name:</label>
                                        <p>{{ $certificate->course_name }}</p>
                                    </div>
                                    @endif

                                    @if($certificate->description)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description:</label>
                                        <p>{!! $certificate->description !!}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white font-bold">Course Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if($certificate->course_code)
                                            <div class="form-group">
                                                <label class="font-weight-bold">Course Code:</label>
                                                <p><code>{{ $certificate->course_code }}</code></p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Duration:</label>
                                                <p>{{ $certificate->course_duration }} hours</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Date:</label>
                                                <p>
                                                    @php
                                                    try {
                                                    echo $certificate->course_start_date ? \Carbon\Carbon::parse($certificate->course_start_date)->format('F d, Y') : 'N/A';
                                                    } catch (\Exception $e) {
                                                    echo $certificate->course_start_date ?? 'N/A';
                                                    }
                                                    @endphp
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Date:</label>
                                                <p>
                                                    @php
                                                    try {
                                                    echo $certificate->course_end_date ? \Carbon\Carbon::parse($certificate->course_end_date)->format('F d, Y') : 'N/A';
                                                    } catch (\Exception $e) {
                                                    echo $certificate->course_end_date ?? 'N/A';
                                                    }
                                                    @endphp
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Instructor:</label>
                                                <p>{{ $certificate->instructor_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            @if($certificate->instructor_email)
                                            <div class="form-group">
                                                <label class="font-weight-bold">Instructor Email:</label>
                                                <p>{{ $certificate->instructor_email }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($certificate->score || $certificate->grade || $certificate->certificate_file)
                            <div class="card mt-3">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white font-bold">Assessment & Files</h5>
                                </div>
                                <div class="card-body">
                                    @if($certificate->score)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Score:</label>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height: 20px;">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: {{ $certificate->score }}%"></div>
                                            </div>
                                            <span class="font-weight-bold">{{ $certificate->score }}%</span>
                                        </div>
                                    </div>
                                    @endif

                                    @if($certificate->grade)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Grade:</label>
                                        <p><span class="badge badge-success">{{ $certificate->grade }}</span></p>
                                    </div>
                                    @endif

                                    @if($certificate->certificate_file)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Certificate File:</label>
                                        <div>
                                            <a href="{{ route('admin.certificates.download', $certificate) }}" class="btn btn-outline-success">
                                                <i class="mdi mdi-download"></i> Download Certificate
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white font-bold">Certificate Settings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Status:</label>
                                        <p>
                                            <span class="badge {{ $certificate->status == 'active' ? 'badge-success' : ($certificate->status == 'expired' ? 'badge-warning' : 'badge-danger') }}">
                                                {{ ucfirst($certificate->status) }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Type:</label>
                                        <p>
                                            <span class="badge badge-info">
                                                {{ ucfirst($certificate->type ?? 'Certificate') }}
                                            </span>
                                        </p>
                                    </div>

                                    @if($certificate->student_id)
                                    <div class="form-group">
                                        <label class="font-weight-bold">Student ID:</label>
                                        <p>{{ $certificate->student_id }}</p>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label class="font-weight-bold">Created:</label>
                                        <p>{{ $certificate->created_at->format('M d, Y \a\t g:i A') }}</p>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Last Updated:</label>
                                        <p>{{ $certificate->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header bg-primary">
                                    <h5 class="mb-0 text-white font-bold">Quick Actions</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.certificates.edit', $certificate) }}" class="btn btn-warning mb-2">
                                            <i class="mdi mdi-pencil"></i> Edit Certificate
                                        </a>

                                        @if($certificate->certificate_file)
                                        <a href="{{ route('admin.certificates.download', $certificate) }}" class="btn btn-success mb-2">
                                            <i class="mdi mdi-download"></i> Download File
                                        </a>
                                        @endif

                                        @admincan('certificates_delete')
                                        <button type="button" class="btn btn-danger delete-btn"
                                            data-url="{{ route('admin.certificates.destroy', $certificate) }}">
                                            <i class="mdi mdi-delete"></i> Delete Certificate
                                        </button>
                                        @endadmincan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Delete functionality
        $('.delete-btn').on('click', function(e) {
            e.preventDefault();

            let url = $(this).data('url');

            if (confirm('Are you sure you want to delete this certificate? This action cannot be undone.')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '{{ route("admin.certificates.index") }}';
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function() {
                        toastr.error('Something went wrong!');
                    }
                });
            }
        });
    });
</script>
@endpush