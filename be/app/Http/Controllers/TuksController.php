<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTuksRequest;
use App\Http\Requests\UpdateTuksRequest;
use App\Models\Tuks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TuksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tuks = Tuks::all();
        return response()->json(
            [
                'success' => true,
                'message' => 'TUKS retrieved successfully',
                'data' => $tuks
            ],
            200
        );
    }

    /**
     * Get the specified resource.
     */
    public function getTuks($id)
    {
        $tuks = Tuks::find($id);
        return response()->json(
            [
                'success' => true,
                'message' => 'TUKS retrieved successfully',
                'data' => $tuks
            ],
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
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'type' => 'required|string|max:255',
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

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folder = Tuks::IMAGE_URL_PATH;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $imageName);
                $request['image_url'] = $folder . '/' . $imageName;
            }


            $tuks = Tuks::create($request->all());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'TUKS created successfully',
                    'data' => $tuks
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to create TUKS',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tuks $tuks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tuks $tuks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tuks $tuks)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'address' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'type' => 'required|string|max:255',
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

            if ($request->hasFile('image')) {
                if ($tuks->image_url) {
                    $oldImagePath = public_path($tuks->image_url);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $image = $request->file('image');
                $folder = Tuks::IMAGE_URL_PATH;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $imageName);
                $request['image_url'] = $folder . '/' . $imageName;
            }


            $tuks->update($request->all());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'TUKS updated successfully',
                    'data' => $tuks
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update TUKS',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tuks $tuks)
    {
        try {
            if ($tuks->image_url) {
                Storage::disk('public')->delete(str_replace('storage/', '', $tuks->image_url));
            }

            $tuks->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'TUKS deleted successfully'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to delete TUKS',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Get references of the resource.
     */
    public function getReferences()
    {
        $references = Tuks::all();
        return response()->json(
            [
                'success' => true,
                'message' => 'References retrieved successfully',
                'data' => $references
            ],
            200
        );
    }

    /**
     * Get details of the reference.
     */
    public function getReferenceDetails($id)
    {
        $tuks = Tuks::with('units')->find($id);
        if (!$tuks) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'TUKS not found',
                    'data' => null
                ],
                404
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'TUKS details retrieved successfully',
                'data' => $tuks
            ],
            200
        );
    }
}
