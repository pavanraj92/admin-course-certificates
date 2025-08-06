<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .certificate-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin: 50px auto;
            max-width: 800px;
        }
        
        .certificate-header {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }
        
        .certificate-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.1)" points="0,0 1000,300 1000,1000 0,700"/></svg>');
            background-size: cover;
        }
        
        .certificate-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }
        
        .verification-badge {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin-top: 15px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .info-row {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
        }
        
        .grade-display {
            font-size: 2rem;
            font-weight: bold;
            color: #28a745;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .progress-custom {
            height: 25px;
            border-radius: 15px;
            background: #f8f9fa;
            overflow: hidden;
        }
        
        .progress-bar-custom {
            background: linear-gradient(45deg, #28a745, #20c997);
            border-radius: 15px;
            text-align: center;
            line-height: 25px;
            color: white;
            font-weight: bold;
            transition: width 2s ease-in-out;
        }
        
        .certificate-seal {
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, #ffd700, #ffed4e);
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #b8860b;
            position: absolute;
            top: -40px;
            right: 30px;
        }
        
        .footer-section {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 3px solid #dee2e6;
        }
        
        .download-btn {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
            margin: 10px;
        }
        
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,123,255,0.4);
            color: white;
            text-decoration: none;
        }
        
        .expiry-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .expired-notice {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .revoked-notice {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate-card">
            <!-- Certificate Header -->
            <div class="certificate-header position-relative">
                <div class="certificate-seal">
                    <i class="fas fa-medal"></i>
                </div>
                <div style="position: relative; z-index: 2;">
                    <div class="certificate-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h1 class="mb-3">Certificate Verification</h1>
                    <p class="mb-0 fs-5">Certificate Number: <strong>{{ $certificate->certificate_number }}</strong></p>
                    
                    @if($certificate->status === 'active')
                        <div class="verification-badge">
                            <i class="fas fa-check-circle me-2"></i>VERIFIED & VALID
                        </div>
                    @elseif($certificate->status === 'expired')
                        <div class="verification-badge" style="background: #ffc107;">
                            <i class="fas fa-exclamation-triangle me-2"></i>EXPIRED
                        </div>
                    @else
                        <div class="verification-badge" style="background: #dc3545;">
                            <i class="fas fa-times-circle me-2"></i>REVOKED
                        </div>
                    @endif
                </div>
            </div>

            @if($certificate->status === 'revoked')
                <div class="revoked-notice">
                    <h4><i class="fas fa-ban me-2"></i>Certificate Revoked</h4>
                    <p class="mb-0">This certificate has been revoked and is no longer valid. Please contact the issuing institution for more information.</p>
                </div>
            @else
                <!-- Certificate Body -->
                <div class="p-4">
                    @php
                        $expiryDate = null;
                        $isExpired = false;
                        $isExpiringSoon = false;
                        
                        if ($certificate->expiry_date) {
                            try {
                                $expiryDate = \Carbon\Carbon::parse($certificate->expiry_date);
                                $isExpired = $expiryDate->isPast();
                                $isExpiringSoon = !$isExpired && $expiryDate->diffInDays(now()) <= 30;
                            } catch (\Exception $e) {
                                // Handle invalid date format
                                $expiryDate = null;
                            }
                        }
                    @endphp
                    
                    @if($isExpired && $expiryDate)
                        <div class="expired-notice">
                            <strong><i class="fas fa-exclamation-triangle me-2"></i>Notice:</strong>
                            This certificate has expired on {{ $expiryDate->format('F j, Y') }}.
                        </div>
                    @elseif($isExpiringSoon && $expiryDate)
                        <div class="expiry-warning">
                            <strong><i class="fas fa-clock me-2"></i>Notice:</strong>
                            This certificate will expire on {{ $expiryDate->format('F j, Y') }}.
                        </div>
                    @endif

                    <div class="row">
                        <!-- Student Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-user-graduate me-2"></i>Student Information
                            </h5>
                            
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Name:</span>
                                <span class="info-value">{{ $certificate->student_name }}</span>
                            </div>
                            
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Email:</span>
                                <span class="info-value">{{ $certificate->student_email }}</span>
                            </div>
                            
                            @if($certificate->student_phone)
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Phone:</span>
                                <span class="info-value">{{ $certificate->student_phone }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Course Information -->
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">
                                <i class="fas fa-book me-2"></i>Course Information
                            </h5>
                            
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Course:</span>
                                <span class="info-value">{{ $certificate->course_name }}</span>
                            </div>
                            
                            @if($certificate->course_code)
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Course Code:</span>
                                <span class="info-value">
                                    <span class="badge bg-info">{{ $certificate->course_code }}</span>
                                </span>
                            </div>
                            @endif
                            
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Duration:</span>
                                <span class="info-value">{{ $certificate->course_duration }} hours</span>
                            </div>
                            
                            <div class="info-row d-flex justify-content-between">
                                <span class="info-label">Instructor:</span>
                                <span class="info-value">{{ $certificate->instructor_name }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Course Period -->
                    <div class="mt-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-calendar-alt me-2"></i>Course Period
                        </h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <strong>Start Date</strong><br>
                                    <span class="text-primary">
                                        @php
                                            try {
                                                echo $certificate->course_start_date ? \Carbon\Carbon::parse($certificate->course_start_date)->format('M j, Y') : 'N/A';
                                            } catch (\Exception $e) {
                                                echo $certificate->course_start_date ?? 'N/A';
                                            }
                                        @endphp
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <strong>End Date</strong><br>
                                    <span class="text-primary">
                                        @php
                                            try {
                                                echo $certificate->course_end_date ? \Carbon\Carbon::parse($certificate->course_end_date)->format('M j, Y') : 'N/A';
                                            } catch (\Exception $e) {
                                                echo $certificate->course_end_date ?? 'N/A';
                                            }
                                        @endphp
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3 bg-light rounded">
                                    <strong>Issue Date</strong><br>
                                    <span class="text-primary">
                                        @php
                                            try {
                                                echo $certificate->issue_date ? \Carbon\Carbon::parse($certificate->issue_date)->format('M j, Y') : 'N/A';
                                            } catch (\Exception $e) {
                                                echo $certificate->issue_date ?? 'N/A';
                                            }
                                        @endphp
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Assessment Results -->
                    @if($certificate->grade || $certificate->score)
                    <div class="mt-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-trophy me-2"></i>Assessment Results
                        </h5>
                        
                        <div class="row align-items-center">
                            @if($certificate->grade)
                            <div class="col-md-6 text-center">
                                <div class="p-3 bg-light rounded">
                                    <strong>Grade Achieved</strong><br>
                                    <div class="grade-display">{{ $certificate->grade }}</div>
                                </div>
                            </div>
                            @endif
                            
                            @if($certificate->score)
                            <div class="col-md-{{ $certificate->grade ? '6' : '12' }}">
                                <div class="p-3 bg-light rounded">
                                    <strong class="d-block mb-2">Score: {{ $certificate->score }}%</strong>
                                    <div class="progress-custom">
                                        <div class="progress-bar-custom" style="width: {{ $certificate->score }}%">
                                            {{ $certificate->score }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Additional Information -->
                    @if($certificate->description)
                    <div class="mt-4">
                        <h5 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>Description
                        </h5>
                        <div class="p-3 bg-light rounded">
                            {{ $certificate->description }}
                        </div>
                    </div>
                    @endif
                </div>
            @endif

            <!-- Footer -->
            <div class="footer-section">
                <h6 class="mb-3">Certificate Verification</h6>
                <p class="text-muted mb-3">
                    This certificate can be verified using the verification code: 
                    <strong>{{ $certificate->verification_code }}</strong>
                </p>
                
                @if($certificate->certificate_file && $certificate->status === 'active')
                    <a href="{{ route('certificates.download', $certificate) }}" class="download-btn">
                        <i class="fas fa-download me-2"></i>Download Certificate
                    </a>
                @endif
                
                <div class="mt-3">
                    <small class="text-muted">
                        Verified on {{ now()->format('F j, Y \a\t g:i A') }} | 
                        Certificate issued by Your Institution Name
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animate progress bar on load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBar = document.querySelector('.progress-bar-custom');
            if (progressBar) {
                // Reset width to 0 first
                progressBar.style.width = '0%';
                
                // Animate to actual width after a small delay
                setTimeout(() => {
                    progressBar.style.width = '{{ $certificate->score ?? 0 }}%';
                }, 500);
            }
        });
    </script>
</body>
</html>
