<?php

namespace App\Http\Controllers;

use App\Models\Struktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StrukturController extends Controller
{
    public function index()
    {
        $galleries = Struktur::all();
        return response()->json(
            ['success' => true, 'message' => 'data retrieved successfully', 'data' => $galleries],
            200
        );
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'struktur_name' => 'required',
                'struktur_posis' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ],
                    422
                );
            }

            $image = $request->file('image');
            $folder = Struktur::IMAGE_URL_PATH;
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0755, true);
            }
            $image->move(public_path($folder), $imageName);
            $request['image_url'] = $folder . '/' . $imageName;


            $data = Struktur::create($request->all());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'data created successfully',
                    'data' => $data
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' =>
                        'Failed to create data',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ],
                    422
                );
            }
            $data = Struktur::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($data->image_url) {
                    $oldImagePath = public_path($data->image_url);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $image = $request->file('image');
                $folder = Struktur::IMAGE_URL_PATH;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $imageName);
                $request['image_url'] = $folder . '/' . $imageName;
            }

            $data->update($request->all());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Gallery updated successfully',
                    'data' => $data
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update gallery',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    public function destroy($id)
    {
        try {

            $data = Struktur::findOrFail($id);
            $data->delete();
            return response()->json(
                ['success' => true, 'message' => 'Gallery deleted successfully'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to delete gallery', 'error' => $e->getMessage()],
                500
            );
        }
    }

    public function getReferences()
    {
        $references = Struktur::all();
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $references],
            200
        );
    }
}
