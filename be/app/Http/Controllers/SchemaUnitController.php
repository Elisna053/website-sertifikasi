<?php

namespace App\Http\Controllers;

use App\Models\SchemaUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchemaUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
                'code' => 'required|string|max:255',
                'schema_id' => 'required|exists:schemas,id',
            ]);

            // ensure code is unique in the same schema
            $existingUnit = SchemaUnit::where('code', $request->code)->where('schema_id', $request->schema_id)->first();
            if ($existingUnit) {
                $validator->errors()->add('code', 'Code must be unique in the same schema');
            }
            
            if ($validator->errors()->count() > 0) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ],
                    422
                );
            }
            
            $schemaUnit = SchemaUnit::create($request->all());

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Schema unit created successfully',
                    'data' => $schemaUnit
                ],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to create schema unit',
                    'errors' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SchemaUnit $schemaUnit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchemaUnit $schemaUnit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchemaUnit $schemaUnit)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'schema_id' => 'required|exists:schemas,id',
            ]);

            // ensure code is unique in the same schema
            $existingUnit = SchemaUnit::where('code', $request->code)->where('schema_id', $request->schema_id)->first();
            if ($existingUnit) {
                $validator->errors()->add('code', 'Code must be unique in the same schema');
            }

            if ($validator->fails() || $validator->errors()->count() > 0) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ],
                    422
                );
            }

            $schemaUnit->update($request->all());

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Schema unit updated successfully',
                    'data' => $schemaUnit
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to update schema unit',
                    'errors' => $e->getMessage()
                ],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchemaUnit $schemaUnit)
    {
        try {
            $schemaUnit->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Schema unit deleted successfully'
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Failed to delete schema unit',
                    'errors' => $e->getMessage()
                ],
                500
            );
        }
    }
}
