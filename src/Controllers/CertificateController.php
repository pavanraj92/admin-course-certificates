<?php

namespace admin\certificates\Controllers;

use App\Http\Controllers\Controller;
use admin\certificates\Models\Certificate;
use admin\certificates\Requests\StoreCertificateRequest;
use admin\certificates\Requests\UpdateCertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('admincan_permission:certificates_manager_list')->only(['index']);
        $this->middleware('admincan_permission:certificates_manager_create')->only(['create', 'store']);
        $this->middleware('admincan_permission:certificates_manager_edit')->only(['edit', 'update']);
        $this->middleware('admincan_permission:certificates_manager_view')->only(['show']);
        $this->middleware('admincan_permission:certificates_manager_delete')->only(['destroy']);
    }

    public function index(Request $request)
    {
        try {
            $certificates = Certificate::query()
                ->filter($request->query('keyword'))
                ->filterByStatus($request->query('status'))
                ->sortable()
                ->latest()
                ->paginate(Certificate::getPerPageLimit())
                ->withQueryString();

            return view('certificate::admin.index', compact('certificates'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load certificates: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('certificate::admin.createOrEdit');
    }

    public function store(StoreCertificateRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle file upload
            if ($request->hasFile('certificate_file')) {
                $file = $request->file('certificate_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $data['certificate_file'] = $file->storeAs('certificates', $filename, 'public');
            }

            $certificate = Certificate::create($data);

            // Check if it's an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certificate created successfully!',
                    'redirect' => route('admin.certificates.index')
                ]);
            }

            return redirect()->route('admin.certificates.index')
                ->with('success', 'Certificate created successfully!');
        } catch (\Exception $e) {
            Log::error('Certificate creation error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating certificate: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Error creating certificate: ' . $e->getMessage()]);
        }
    }

    public function show(Certificate $certificate)
    {
        return view('certificate::admin.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        return view('certificate::admin.createOrEdit', compact('certificate'));
    }

    public function update(UpdateCertificateRequest $request, Certificate $certificate)
    {
        try {
            $data = $request->validated();

            // Handle file upload
            if ($request->hasFile('certificate_file')) {
                // Delete old file if exists
                if ($certificate->certificate_file) {
                    Storage::disk('public')->delete($certificate->certificate_file);
                }

                $file = $request->file('certificate_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $data['certificate_file'] = $file->storeAs('certificates', $filename, 'public');
            }

            $certificate->update($data);

            // Check if it's an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Certificate updated successfully!',
                    'redirect' => route('admin.certificates.index')
                ]);
            }

            return redirect()->route('admin.certificates.index')
                ->with('success', 'Certificate updated successfully!');
        } catch (\Exception $e) {
            Log::error('Certificate update error: ' . $e->getMessage());

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating certificate: ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Error updating certificate: ' . $e->getMessage()]);
        }
    }

    public function destroy(Certificate $certificate)
    {
        // Delete certificate file if exists
        if ($certificate->certificate_file) {
            Storage::disk('public')->delete($certificate->certificate_file);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'Certificate deleted successfully!');
    }

    public function download(Certificate $certificate)
    {
        if (!$certificate->certificate_file || !Storage::disk('public')->exists($certificate->certificate_file)) {
            abort(404, 'Certificate file not found.');
        }

        $filePath = Storage::disk('public')->path($certificate->certificate_file);
        return response()->download($filePath, $certificate->certificate_number . '.pdf');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'certificate_ids' => 'required|array',
            'certificate_ids.*' => 'exists:certificates,id'
        ]);

        $certificates = Certificate::whereIn('id', $request->certificate_ids)->get();

        foreach ($certificates as $certificate) {
            if ($certificate->certificate_file) {
                Storage::disk('public')->delete($certificate->certificate_file);
            }
            $certificate->delete();
        }

        return redirect()->route('admin.certificates.index')
            ->with('success', count($request->certificate_ids) . ' certificates deleted successfully!');
    }

    public function export(Request $request)
    {
        // You can implement CSV/Excel export functionality here
        // For now, we'll just return a basic CSV export

        $query = Certificate::query();

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                    ->orWhere('student_email', 'like', "%{$search}%")
                    ->orWhere('course_name', 'like', "%{$search}%")
                    ->orWhere('certificate_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $certificates = $query->get();

        $filename = 'certificates_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($certificates) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Certificate Number',
                'Student Name',
                'Student Email',
                'Course Name',
                'Course Code',
                'Grade',
                'Score',
                'Issue Date',
                'Expiry Date',
                'Status',
                'Verification Code'
            ]);

            // Data
            foreach ($certificates as $certificate) {
                fputcsv($file, [
                    $certificate->certificate_number,
                    $certificate->student_name,
                    $certificate->student_email,
                    $certificate->course_name,
                    $certificate->course_code,
                    $certificate->grade,
                    $certificate->score,
                    $certificate->issue_date,
                    $certificate->expiry_date,
                    $certificate->status,
                    $certificate->verification_code
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:certificates,id',
            'status' => 'required|in:active,expired,revoked'
        ]);

        $certificate = Certificate::findOrFail($request->id);
        $certificate->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Certificate status updated successfully!',
            'status' => $certificate->status,
            'status_badge' => $certificate->status_badge
        ]);
    }
}
