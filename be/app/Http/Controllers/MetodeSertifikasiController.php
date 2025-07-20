<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodeSertifikasi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class MetodeSertifikasiController extends Controller
{
    public function index()
    {
        $data = MetodeSertifikasi::all();
        return response()->json(
            ['success' => true, 'message' => 'Data retrieved successfully', 'data' => $data],
            200
        );
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|file|mimes:pdf,jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $request->all();
            $file = $request->file('file');
            $folder = MetodeSertifikasi::IMAGE_URL_PATH;
            $fileName = time() . '.' . $file->getClientOriginalExtension();

            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0755, true);
            }

            $file->move(public_path($folder), $fileName);
            $data['file'] = $folder . '/' . $fileName;
            $data['file_path'] = asset($data['file']);

            if (!empty($request->id)) {
                $existing = MetodeSertifikasi::findOrFail($request->id);
                $existing->update($data);
                $message = 'Data updated successfully';
            } else {
                MetodeSertifikasi::create($data);
                $message = 'Data created successfully';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create/update data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $data = MetodeSertifikasi::findOrFail($id);

            if (!empty($data->file_path) && File::exists(public_path($data->file_path))) {
                File::delete(public_path($data->file_path));
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data deleted successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getReferences()
    {
        $data = MetodeSertifikasi::all();
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $data],
            200
        );
    }
    public function getDataById($id)
    {
        $data = MetodeSertifikasi::findOrFail($id);
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $data],
            200
        );
    }
    public function getReferencesById($id)
    {
        $data = MetodeSertifikasi::findOrFail($id);
        $path = public_path($data->file);

        if (!file_exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak ditemukan.'
            ], 404);
        }

        $filename = basename($data->nama_metode);

        return response()->download($path, $filename);
    }

}
