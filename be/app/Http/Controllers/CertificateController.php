<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Requests\UpdateCertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $certificates = Certificate::with('assessee')->get();
        return response()->json(
            ['success' => true, 'message' => 'Certificates retrieved successfully', 'data' => $certificates],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function getById(int $id)
    {
        $certificate = Certificate::find($id);
        if (!$certificate) {
            return response()->json(
                ['success' => false, 'message' => 'Certificate not found'],
                404
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'assessee_id' => 'required|exists:assessees,id',
                'certificate_number' => 'required|string|max:255',
                'certificate_file' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            // handle certificate file
            if ($request->hasFile('certificate_file')) {
                $file = $request->file('certificate_file');
                $folder = Certificate::FILE_PATH;
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($folder), $filename);
                $request['certificate_path'] = $folder . '/' . $filename;
            }


            $certificate = Certificate::create($request->all());
            return response()->json(
                ['success' => true, 'message' => 'Certificate created successfully', 'data' => $certificate],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to create certificate', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        try {
            $validator = Validator::make($request->all(), [
                'certificate_number' => 'required|string|max:255',
                'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            if ($request->hasFile('certificate_file')) {
                if ($certificate->certificate_path) {
                    $oldFile = public_path($certificate->certificate_path);
                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
                $file = $request->file('certificate_file');
                $folder = Certificate::FILE_PATH;
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($folder), $filename);

                $request['certificate_path'] = $folder . '/' . $filename;
            }


            $certificate->update($request->all());
            return response()->json(
                ['success' => true, 'message' => 'Certificate updated successfully', 'data' => $certificate],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to update certificate', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Download the certificate file
     */
    public function downloadCertificate(Certificate $certificate)
    {
        try {
            if (!$certificate || !$certificate->certificate_path) {
                return response()->json(
                    ['success' => false, 'message' => 'Certificate file not found'],
                    404
                );
            }

            $filePath = str_replace('storage/', '', $certificate->certificate_path);
            $fullPath = Storage::disk('public')->path($filePath);

            if (!Storage::disk('public')->exists($filePath)) {
                return response()->json(
                    ['success' => false, 'message' => 'Certificate file not found on server'],
                    404
                );
            }

            // Sanitasi nama file - menghilangkan karakter / dan \
            $sanitizedNumber = str_replace(['/', '\\'], '_', $certificate->certificate_number);
            $fileName = "Sertifikat_" . $sanitizedNumber . ".pdf";

            return response()->download($fullPath, $fileName);
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to download certificate', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        try {
            if ($certificate->certificate_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $certificate->certificate_path));
            }

            $certificate->delete();
            return response()->json(
                ['success' => true, 'message' => 'Certificate deleted successfully'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to delete certificate', 'error' => $e->getMessage()],
                500
            );
        }
    }
}
