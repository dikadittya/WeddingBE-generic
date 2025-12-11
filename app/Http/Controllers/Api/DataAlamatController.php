<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Models\DataAlamat;
use App\Http\Requests\DataAlamatRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DataAlamatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = DataAlamat::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('kode_alamat', 'like', "%{$search}%")
                  ->orWhere('nama_provinsi', 'like', "%{$search}%")
                  ->orWhere('nama_kabupaten', 'like', "%{$search}%")
                  ->orWhere('nama_kecamatan', 'like', "%{$search}%")
                  ->orWhere('nama_desa', 'like', "%{$search}%");
            });
        }

        // Filter by provinsi
        if ($request->has('kode_provinsi')) {
            $query->where('kode_provinsi', $request->get('kode_provinsi'));
        }

        // Filter by kabupaten
        if ($request->has('kode_kabupaten')) {
            $query->where('kode_kabupaten', $request->get('kode_kabupaten'));
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $dataAlamat = $query->paginate($perPage)->appends($request->query());
        
        return response()->json([
            'success' => true,
            'message' => 'Data alamat retrieved successfully',
            'data' => PaginationHelper::cleanPaginationUrls($dataAlamat)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DataAlamatRequest $request): JsonResponse
    {
        $dataAlamat = DataAlamat::create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data alamat created successfully',
            'data' => $dataAlamat
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $dataAlamat = DataAlamat::find($id);

        if (!$dataAlamat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data alamat not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data alamat retrieved successfully',
            'data' => $dataAlamat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DataAlamatRequest $request, string $id): JsonResponse
    {
        $dataAlamat = DataAlamat::find($id);

        if (!$dataAlamat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data alamat not found'
            ], 404);
        }

        $dataAlamat->update($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Data alamat updated successfully',
            'data' => $dataAlamat->fresh()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $dataAlamat = DataAlamat::find($id);

        if (!$dataAlamat) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data alamat not found'
            ], 404);
        }

        $dataAlamat->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data alamat deleted successfully'
        ]);
    }

}
