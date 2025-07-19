<?php

namespace App\Http\Controllers;

use App\Models\Assessee;
use App\Models\Jadwal;
use App\Helpers\Fungsi;
use App\Models\BerkasApl;
use App\Models\Instance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instances = Instance::all();
        return response()->json(
            ['success' => true, 'message' => 'Instances retrieved successfully', 'data' => $instances],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function getById(int $id)
    {
        $instance = Instance::find($id);

        if (!$instance) {
            return response()->json(
                ['success' => false, 'message' => 'Instance not found'],
                404
            );
        }

        return response()->json(
            ['success' => true, 'message' => 'Instance retrieved successfully', 'data' => $instance],
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
                'name' => 'required|string|max:255|unique:instances,name',
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            // Generate slug from name
            $request['slug'] = Str::slug($request->name);

            $instance = Instance::create($request->all());
            return response()->json(
                ['success' => true, 'message' => 'Instance created successfully', 'data' => $instance],
                201
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to create instance', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Instance $instance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instance $instance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instance $instance)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:instances,name,' . $instance->id,
            ]);

            if ($validator->fails()) {
                return response()->json(
                    ['success' => false, 'message' => 'Validation errors', 'errors' => $validator->errors()],
                    422
                );
            }

            // Generate slug from name
            $request['slug'] = Str::slug($request->name);

            $instance->update($request->all());
            return response()->json(
                ['success' => true, 'message' => 'Instance updated successfully', 'data' => $instance],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to update instance', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instance $instance)
    {
        try {
            $instance->delete();
            return response()->json(
                ['success' => true, 'message' => 'Instance deleted successfully'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to delete instance', 'error' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Get references for the specified resource.
     */
    public function getReferences()
    {
        $references = Instance::all();
        return response()->json(
            ['success' => true, 'message' => 'References retrieved successfully', 'data' => $references],
            200
        );
    }

    /**
     * Get instance by slug.
     */
    public function getBySlug($slug)
    {
        $instance = Instance::where('slug', $slug)->first();

        if (!$instance) {
            return response()->json(
                ['success' => false, 'message' => 'Instance not found'],
                404
            );
        }

        return response()->json(
            ['success' => true, 'message' => 'Instance retrieved successfully', 'data' => $instance],
            200
        );
    }

    /**
     * Get instances reference.
     */
    public function getInstancesReference()
    {
        $instances = Instance::with('jadwal')->latest()->get();
        return response()->json(
            ['success' => true, 'message' => 'Instances retrieved successfully', 'data' => $instances],
            200
        );
    }
    public function jadwalIndex($instanceId)
    {
        $data = Instance::with('jadwal')->find($instanceId);

        foreach ($data->jadwal as $jadwalItem) {
            $jadwalItem->date = Fungsi::format_tgl($jadwalItem->date);
        }

        return response()->json(
            ['success' => true, 'message' => 'Get data successfully', 'data' => $data],
            200
        );
    }

    public function jadwalStore(Request $request)
    {

        $data = $request->all();

        try {
            if (!empty($request->id)) {
                $dataUpate = Jadwal::findOrFail($request->id);
                $dataUpate->update($data);
            } else {
                Jadwal::create($data);
            }
            return response()->json(
                ['success' => true, 'message' => 'Data saved successfully'],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => 'Failed to save data', 'error' => $e->getMessage()],
                500
            );
        }
    }

    public function jadwalDestroy($id)
    {
        $data = Jadwal::findOrFail($id);
        $data->delete();
    }

    public function getJadwalRefrences($instanceId)
    {

        $data = Jadwal::where('instance_id', $instanceId)->latest()->get();

        $data->transform(function ($item) {
            $item->formatted_date = Fungsi::format_tgl($item->date);
            return $item;
        });

        return response()->json(
            ['success' => true, 'message' => 'Get data successfully', 'data' => $data],
            200
        );
    }

    public function getUnitByIdAss($id)
    {
        $data = Assessee::where('id', $id)->with(['schema.units', 'berkasApl'])->first();

        return response()->json(
            [
                'success' => true,
                'message' => 'Get data successfully',
                'data' => $data
            ],
            200
        );
    }

    public function storeAplUpload(Request $request)
    {
        $userLogin = Auth::user();

        $data = $request->all();
        $data['user_id'] = $userLogin->id;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                $extension = $file->getClientOriginalExtension();
                $newFileName = 'apl_' . $userLogin->name . '_unit_' . $request->input('schema_unit_id') . '_' . now()->format('YmdHis') . '.' . $extension;
                $file->move(public_path('file'), $newFileName);
                $data['file'] = $newFileName;
                $data['file_path'] = 'file/' . $newFileName;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid',
                ], 400);
            }
        }

        try {
            if (!empty($request->id)) {
                $dataUpdate = BerkasApl::findOrFail($request->id);
                $dataUpdate->update($data);
            } else {
                BerkasApl::create($data);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getEditApl($id)
    {
        $assess_id = $id;

        $assessees = Assessee::with('instance', 'berkasApl', 'schema', 'certificate')->where('id', $assess_id)
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



}
