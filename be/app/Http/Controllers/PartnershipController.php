<?php

namespace App\Http\Controllers;

use App\Models\Partnership;
use App\Http\Requests\StorePartnershipRequest;
use App\Http\Requests\UpdatePartnershipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PartnershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partnerships = Partnership::all();
        return response()->json(
            ['success' => true, 'message' => 'Partnerships retrieved successfully', 'data' => $partnerships],
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
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folder = Partnership::IMAGE_URL_PATH;
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path($folder), $filename);
                $request['image_url'] = $folder . '/' . $filename;
            }


            $partnership = Partnership::create($request->all());

            return response()->json(
                ['success' => true, 'message' => 'Partnership created successfully', 'data' => $partnership],
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(
                ['success' => false, 'message' => 'Failed to create partnership', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Partnership $partnership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partnership $partnership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partnership $partnership)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                if ($partnership->image_url) {
                    $oldImagePath = public_path($partnership->image_url);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                $image = $request->file('image');
                $folder = Partnership::IMAGE_URL_PATH;
                $filename = time() . '_' . $image->getClientOriginalName();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $filename);
                $request['image_url'] = $folder . '/' . $filename;
            }


            $partnership->update($request->all());

            return response()->json(
                ['success' => true, 'message' => 'Partnership updated successfully', 'data' => $partnership],
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(
                ['success' => false, 'message' => 'Failed to update partnership', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partnership $partnership)
    {
        try {
            if ($partnership->image_url) {
                $imagePath = public_path($partnership->image_url);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $partnership->delete();

            return response()->json(
                ['success' => true, 'message' => 'Partnership deleted successfully'],
                200
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(
                ['success' => false, 'message' => 'Failed to delete partnership', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Get references of the resource.
     */
    public function getReferences()
    {
        $references = Partnership::all();
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $references],
            200
        );
    }
}
