@extends('admin::admin.layouts.master')

@section('title', 'Certificates Management')

@section('page-title', 'Manage Certificates')

@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page">Manage Certificates</li>
@endsection

@section('content')
<!-- Container fluid  -->
<div class="container-fluid">
    <!-- Start Certificate Content -->
    <div class="row">
        <div class="col-12">
            <div class="card card-body">
                <h4 class="card-title">Filter</h4>
                <form action="{{ route('admin.certificates.index') }}" method="GET" id="filterForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="keyword">Search</label>
                                <input type="text" name="keyword" id="keyword" class="form-control"
                                    value="{{ app('request')->query('keyword') }}" placeholder="Student name, email, course...">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    <option value="">All</option>
                                    <option value="active" {{ app('request')->query('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="expired" {{ app('request')->query('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="revoked" {{ app('request')->query('status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="course">Course</label>
                                <select name="course" id="course" class="form-control select2">
                                    <option value="">All Courses</option>
                                    @if(isset($courses))
                                    @foreach($courses as $course)
                                    <option value="{{ $course }}" {{ app('request')->query('course') == $course ? 'selected' : '' }}>
                                        {{ $course }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_from">From Date</label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                    value="{{ app('request')->query('date_from') }}">
                            </div>
                        </div>
                        <div class="col-auto mt-1 text-right">
                            <div class="form-group">
                                <button type="submit" form="filterForm" class="btn btn-primary mt-4">Filter</button>
                                <a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary mt-4">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @admincan('certificates_manager_create')
                    <div class="text-right">
                        <a href="{{ route('admin.certificates.create') }}" class="btn btn-primary mb-3">
                            <i class="mdi mdi-plus"></i> Create New Certificate
                        </a>
                    </div>
                    @endadmincan

                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">@sortablelink('certificate_number', 'Certificate #', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                    <th scope="col">@sortablelink('student_name', 'Student', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                    <th scope="col">@sortablelink('course_name', 'Course', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                    <th scope="col">Grade/Score</th>
                                    <th scope="col">@sortablelink('issue_date', 'Issue Date', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                    <th scope="col">@sortablelink('status', 'Status', [], ['style' => 'color: #4F5467; text-decoration: none;'])</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($certificates) && $certificates->count() > 0)
                                @php
                                $i = ($certificates->currentPage() - 1) * $certificates->perPage() + 1;
                                @endphp
                                @foreach ($certificates as $certificate)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>
                                        <strong>{{ $certificate->certificate_number }}</strong>
                                        <br><small class="text-muted">{{ $certificate->verification_code }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $certificate->student_name }}</strong>
                                        <br><small class="text-muted">{{ $certificate->student_email }}</small>
                                        @if($certificate->student_phone)
                                        <br><small class="text-muted">{{ $certificate->student_phone }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $certificate->course_name }}</strong>
                                        @if($certificate->course_code)
                                        <br><small class="text-muted">
                                            <i class="mdi mdi-code-tags"></i> {{ $certificate->course_code }}
                                        </small>
                                        @endif
                                        @if($certificate->instructor_name)
                                        <br><small class="text-muted">
                                            <i class="mdi mdi-account"></i> {{ $certificate->instructor_name }}
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($certificate->grade)
                                        <span class="badge badge-primary">{{ $certificate->grade }}</span>
                                        @endif
                                        @if($certificate->score)
                                        <br><small class="text-muted">{{ $certificate->score }}%</small>
                                        @endif
                                        @if(!$certificate->grade && !$certificate->score)
                                        <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                        try {
                                        $issueDate = $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date) : null;
                                        echo $issueDate ? $issueDate->format(config('GET.admin_date_time_format') ?? 'M d, Y') : '—';
                                        } catch (\Exception $e) {
                                        echo $certificate->issue_date ?? '—';
                                        }
                                        @endphp
                                        @if($certificate->expiry_date)
                                        @php
                                        try {
                                        $expiryDate = \Carbon\Carbon::parse($certificate->expiry_date);
                                        echo '<br><small class="text-muted">Expires: ' . $expiryDate->format('M d, Y') . '</small>';
                                        } catch (\Exception $e) {
                                        echo '<br><small class="text-muted">Expires: ' . $certificate->expiry_date . '</small>';
                                        }
                                        @endphp
                                        @endif
                                    </td>
                                    <td>
                                        @if ($certificate->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                        @elseif ($certificate->status == 'expired')
                                        <span class="badge badge-warning">Expired</span>
                                        @elseif ($certificate->status == 'revoked')
                                        <span class="badge badge-danger">Revoked</span>
                                        @else
                                        <span class="badge badge-secondary">{{ ucfirst($certificate->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($certificate->certificate_file)
                                        <a href="{{ route('admin.certificates.download', $certificate) }}"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Download certificate"
                                            class="btn btn-info btn-sm mr-1">
                                            <i class="mdi mdi-download"></i>
                                        </a>
                                        @endif
                                        @admincan('certificates_manager_view')
                                        <a href="{{ route('admin.certificates.show', $certificate) }}"
                                            data-toggle="tooltip" data-placement="top"
                                            title="View this record" class="btn btn-warning btn-sm mr-1"><i
                                                class="mdi mdi-eye"></i></a>
                                        @endadmincan
                                        @admincan('certificates_manager_edit')
                                        <a href="{{ route('admin.certificates.edit', $certificate) }}"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Edit this record" class="btn btn-success btn-sm mr-1"><i
                                                class="mdi mdi-pencil"></i></a>
                                        @endadmincan
                                        @admincan('certificates_manager_delete')
                                        <a href="javascript:void(0)" data-toggle="tooltip"
                                            data-placement="top" title="Delete this record"
                                            data-url="{{ route('admin.certificates.destroy', $certificate) }}"
                                            data-text="Are you sure you want to delete this certificate?"
                                            data-method="DELETE"
                                            class="btn btn-danger btn-sm delete-record"><i
                                                class="mdi mdi-delete"></i></a>
                                        @endadmincan
                                    </td>
                                </tr>
                                @php
                                $i++;
                                @endphp
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">No certificates found.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        @if (isset($certificates) && $certificates->count() > 0)
                        {{ $certificates->links('admin::pagination.custom-admin-pagination') }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Certificate Content -->
</div>
<!-- End Container fluid  -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips safely
        try {
            if (typeof $.fn.tooltip !== 'undefined') {
                $('[data-toggle="tooltip"]').tooltip();
            }
        } catch (error) {
            console.log('Tooltip error:', error);
        }

        // Initialize Select2 safely
        try {
            if (typeof $.fn.select2 !== 'undefined') {
                $('.select2').select2();
            }
        } catch (error) {
            console.log('Select2 error:', error);
        }

        // DON'T interfere with download buttons - let them work naturally!
        console.log('Certificate index page loaded');
    });
</script>
@endpush