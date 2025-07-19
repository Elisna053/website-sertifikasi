<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::all();
        return response()->json(
            ['success' => true, 'message' => 'Galleries retrieved successfully', 'data' => $galleries],
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
            $folder = Gallery::IMAGE_URL_PATH;
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0755, true);
            }
            $image->move(public_path($folder), $imageName);
            $request['image_url'] = $folder . '/' . $imageName;


            $gallery = Gallery::create($request->all());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Gallery created successfully',
                    'data' => $gallery
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' =>
                        'Failed to create gallery',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
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

            if ($request->hasFile('image')) {
                if ($gallery->image_url) {
                    $oldImagePath = public_path($gallery->image_url);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $image = $request->file('image');
                $folder = Gallery::IMAGE_URL_PATH;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $imageName);
                $request['image_url'] = $folder . '/' . $imageName;
            }

            $gallery->update($request->all());
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Gallery updated successfully',
                    'data' => $gallery
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        try {
            if ($gallery->image_url) {
                Storage::disk('public')->delete(str_replace('storage/', '', $gallery->image_url));
            }

            $gallery->delete();
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
        $references = Gallery::all();
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $references],
            200
        );
    }
}
