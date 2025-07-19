<?php

namespace App\Http\Controllers;

use App\Models\Schema;
use App\Http\Requests\Schema\StoreSchemaRequest;
use App\Http\Requests\Schema\UpdateSchemaRequest;
use App\Models\SchemaUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schemas = Schema::all();
        return response()->json(
            [
                'success' => true,
                'message' => 'Schemas retrieved successfully',
                'data' => $schemas
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function getSchema($id)
    {
        $schema = Schema::with('units')->find($id);

        if (!$schema) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Schema not found',
                    'data' => null
                ],
                404
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Schema retrieved successfully',
                'data' => $schema
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
                'type' => 'required|string|max:255',
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
                $image = $request->file('image');
                $folder = Schema::IMAGE_URL_PATH;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $imageName);
                $request['image_url'] = $folder . '/' . $imageName;
            }


            $schema = Schema::create($request->all());

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Schema created successfully',
                    'data' => $schema
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to create schema',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schema $schema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schema $schema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schema $schema)
    {
        DB::beginTransaction();

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'units' => 'nullable|array',
                'units.*.code' => 'required|string|max:255',
                'units.*.name' => 'required|string|max:255',
            ]);

            // Validasi tambahan untuk memastikan kode unit unik dalam skema yang sama
            if ($request->has('units')) {
                $codes = [];
                foreach ($request->units as $index => $unit) {
                    if (isset($unit['code'])) {
                        if (in_array($unit['code'], $codes)) {
                            $validator->errors()->add("units.{$index}.code", "Unit code '{$unit['code']}' is duplicated in the same schema.");
                            break;
                        }
                    }
                    $codes[] = $unit['code'];
                }
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $folder = Schema::IMAGE_URL_PATH;
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                if (!file_exists(public_path($folder))) {
                    mkdir(public_path($folder), 0755, true);
                }
                $image->move(public_path($folder), $imageName);
                $request['image_url'] = $folder . '/' . $imageName;
            }

            $schema->update($request->all());

            if ($request->has('units')) {
                $schema->units()->delete();
                foreach ($request->units as $unit) {
                    $schema->units()->create($unit);
                }
            }

            DB::commit();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Schema updated successfully',
                    'data' => $schema->with('units')->find($schema->id)
                ],
                200
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update schema',
                    'error' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schema $schema)
    {
        try {
            $schema->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Schema deleted successfully',
                    'data' => $schema
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to delete schema',
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
        $references = Schema::all();
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
     * Get units of the reference.
     */
    public function getReferenceDetails($id)
    {
        $schema = Schema::with('units')->find($id);
        if (!$schema) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Schema not found',
                    'data' => null
                ],
                404
            );
        }

        return response()->json(
            [
                'success' => true,
                'message' => 'Schema details retrieved successfully',
                'data' => $schema
            ],
            200
        );
    }
}
