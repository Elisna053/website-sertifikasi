<?php

namespace App\Http\Controllers;

use App\Models\Assessee;
use App\Http\Requests\StoreAssesseeRequest;
use App\Http\Requests\UpdateAssesseeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AssesseeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assessees = Assessee::with('instance', 'schema', 'certificate')
            ->when(Auth::user()->role === 'user', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->get();

        $assessees->each(function ($assessee) {
            $assessee['hasCompletedDocuments'] = $assessee->hasCompletedDocuments();
        });

        return response()->json(
            ['success' => true, 'message' => 'Assessees retrieved successfully', 'data' => $assessees],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function getById(int $id)
    {
        $assessee = Assessee::find($id);
        if (!$assessee) {
            return response()->json(
                ['success' => false, 'message' => 'Assessee not found'],
                404
            );
        }

        return response()->json(
            ['success' => true, 'message' => 'Assessee retrieved successfully', 'data' => $assessee],
            200
        );
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
                'instance_id' => 'nullable|exists:instances,id',
                'name' => 'nullable|string',
                'email' => 'nullable|email',
                'phone_number' => 'nullable|string',
                'address' => 'nullable|string',
                'identity_number' => 'nullable|string',
                'birth_date' => 'nullable|date',
                'birth_place' => 'nullable|string',
                'last_education_level' => 'nullable|string',
                'schema_id' => 'nullable|exists:schemas,id',
                'method' => 'nullable|string',
                'assessment_date' => 'nullable|date',

                'last_education_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'identity_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'family_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'self_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'apl01' => 'nullable|file|mimes:pdf|max:2048',
                'apl02' => 'nullable|file|mimes:pdf|max:2048',

                'supporting_documents' => 'nullable|array',
                'supporting_documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $data = $request->except([
                'last_education_certificate',
                'identity_card',
                'family_card',
                'self_photo',
                'apl01',
                'apl02',
                'supporting_documents'
            ]);

            $data['user_id'] = Auth::id();
            $data['status'] = 'requested';

            $fileFields = [
                'last_education_certificate',
                'identity_card',
                'family_card',
                'self_photo',
                'apl01',
                'apl02',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $folder = Assessee::FILE_PATH;
                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();

                    if (!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }

                    $file->move(public_path($folder), $filename);
                    $data["{$field}_path"] = $folder . '/' . $filename;
                }
            }

            if ($request->hasFile('supporting_documents')) {
                $paths = [];
                foreach ($request->file('supporting_documents') as $file) {
                    $folder = Assessee::FILE_PATH;
                    if (!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }

                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path($folder), $filename);
                    $paths[] = $folder . '/' . $filename;
                }
                $data['supporting_documents_path'] = json_encode($paths);
            }

            $assessee = Assessee::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Assessee created successfully',
                'data' => $assessee,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create assessee',
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Assessee $assessee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assessee $assessee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'instance_id' => 'nullable|exists:instances,id',
                'name' => 'nullable|string',
                // 'email' => 'nullable|email|unique:assessees,email,' . $id,
                'phone_number' => 'nullable|string',
                'address' => 'nullable|string',
                'identity_number' => 'nullable|string',
                'birth_date' => 'nullable|date',
                'birth_place' => 'nullable|string',
                'last_education_level' => 'nullable|string',
                'schema_id' => 'nullable|exists:schemas,id',
                'method' => 'nullable|string',
                'assessment_date' => 'nullable|date',

                'last_education_certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'identity_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'family_card' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'self_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
                'apl01' => 'nullable|file|mimes:pdf|max:2048',
                'apl02' => 'nullable|file|mimes:pdf|max:2048',

                'supporting_documents' => 'nullable|array',
                'supporting_documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $assessee = Assessee::find($id);
            if (!$assessee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Assessee not found',
                ], 404);
            }

            $data = $request->except([
                'last_education_certificate',
                'identity_card',
                'family_card',
                'self_photo',
                'apl01',
                'apl02',
                'supporting_documents',
            ]);

            $fileFields = [
                'last_education_certificate',
                'identity_card',
                'family_card',
                'self_photo',
                'apl01',
                'apl02',
            ];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $existingPath = $assessee["{$field}_path"];
                    if ($existingPath) {
                        $oldFile = public_path($existingPath);
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }

                    $file = $request->file($field);
                    $folder = Assessee::FILE_PATH;
                    if (!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }

                    $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path($folder), $filename);
                    $data["{$field}_path"] = $folder . '/' . $filename;
                }
            }

            if ($request->hasFile('supporting_documents')) {
                if ($assessee->supporting_documents_path) {
                    $oldPaths = json_decode($assessee->supporting_documents_path, true);
                    if (is_array($oldPaths)) {
                        foreach ($oldPaths as $oldPath) {
                            $oldFile = public_path($oldPath);
                            if (file_exists($oldFile)) {
                                unlink($oldFile);
                            }
                        }
                    }
                }

                $paths = [];
                foreach ($request->file('supporting_documents') as $file) {
                    $folder = Assessee::FILE_PATH;
                    if (!file_exists(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }

                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path($folder), $filename);
                    $paths[] = $folder . '/' . $filename;
                }
                $data['supporting_documents_path'] = json_encode($paths);
            }

            $assessee->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Assessee updated successfully',
                'data' => $assessee,
            ], 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update assessee',
                'error' => $e->getMessage(),
            ], 500);
        }

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $assessee = Assessee::find($id);
            if (!$assessee) {
                return response()->json(
                    ['success' => false, 'message' => 'Assessee not found'],
                    404
                );
            }

            $fileFields = [
                'last_education_certificate_path',
                'identity_card_path',
                'family_card_path',
                'self_photo_path',
                'apl01_path',
                'apl02_path',
            ];

            // Hapus file tunggal
            foreach ($fileFields as $field) {
                if ($assessee->$field) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $assessee->$field));
                }
            }

            // Hapus file multiple (supporting_documents_path)
            if ($assessee->supporting_documents_path) {
                $paths = json_decode($assessee->supporting_documents_path, true);
                if (is_array($paths)) {
                    foreach ($paths as $path) {
                        Storage::disk('public')->delete(str_replace('storage/', '', $path));
                    }
                }
            }

            $assessee->delete();

            return response()->json(
                ['success' => true, 'message' => 'Assessee deleted successfully'],
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(
                ['success' => false, 'message' => 'Failed to delete assessee', 'error' => $e->getMessage()],
                500
            );
        }
    }


    /**
     * Get the statistic detail.
     */
    public function statisticDetail()
    {
        $assessees = Assessee::with('instance', 'schema')
            ->when(Auth::user()->role === 'user', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
            ->get();

        $data['total_assessees'] = $assessees->count();
        $data['total_assessees_by_instance'] = $assessees->groupBy('instance_id')->count();
        $data['total_assessees_by_schema'] = $assessees->groupBy('schema_id')->count();
        $data['total_requested_assessees'] = $assessees->where('status', 'requested')->count();
        $data['total_approved_assessees'] = $assessees->where('status', 'approved')->count();
        $data['total_completed_assessees'] = $assessees->where('status', 'completed')->count();

        return response()->json(
            ['success' => true, 'message' => 'Statistic detail retrieved successfully', 'data' => $data],
            200
        );
    }

    /**
     * Get the approved assessee.
     */
    public function approvedAssessee()
    {
        $assessees = Assessee::with('instance', 'schema', 'user', 'certificate')->where('assessment_status', 'approved')->get();
        return response()->json(
            ['success' => true, 'message' => 'Approved assessee retrieved successfully', 'data' => $assessees],
            200
        );
    }

    /**
     * Download APL-01 template document
     */
    public function downloadApl01Template()
    {
        try {
            $filePath = public_path('assets/documents/apl01_template.pdf');

            if (!file_exists($filePath)) {
                return response()->json(
                    ['success' => false, 'message' => 'Template APL-01 tidak ditemukan'],
                    404
                );
            }

            return response()->download($filePath, 'APL-01_Template.pdf');
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Gagal mengunduh template APL-01', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Download APL-02 template document
     */
    public function downloadApl02Template(Request $request)
    {
        $type = $request->type;

        try {
            if ($type === 'observation') {
                $filePath = public_path('assets/documents/apl02_observation_template.pdf');
            } else if ($type === 'portofolio') {
                $filePath = public_path('assets/documents/apl02_portofolio_template.pdf');
            } else {
                return response()->json(
                    ['success' => false, 'message' => 'Tipe template tidak valid'],
                    400
                );
            }

            if (!file_exists($filePath)) {
                return response()->json(
                    ['success' => false, 'message' => 'Template APL-02 tidak ditemukan'],
                    404
                );
            }

            return response()->download($filePath, 'APL-02_Template.pdf');
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Gagal mengunduh template APL-02', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Update the status of the assessee
     */
    public function updateStatus(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                422
            );
        }

        $assessee = Assessee::find($id);
        if (!$assessee) {
            return response()->json(
                ['success' => false, 'message' => 'Assessee not found'],
                404
            );
        }

        // Update status
        $assessee->assessment_status = $request->status;

        // Simpan perubahan
        $assessee->save();

        return response()->json(
            ['success' => true, 'message' => 'Assessee status updated successfully', 'data' => $assessee],
            200
        );
    }
}
