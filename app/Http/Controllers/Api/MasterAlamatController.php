<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Models\DataAlamat;
use App\Http\Requests\DataAlamatRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MasterAlamatController extends Controller
{

    public function getProvinces(Request $request): JsonResponse
    {
        $query = \App\Models\RegProvinces::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $provinces = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $provinces
        ]);
    }

    public function getRegencies(Request $request): JsonResponse
    {
        $query = \App\Models\RegRegencies::query();

        // Filter by province_id
        if ($request->has('province_id')) {
            $query->where('province_id', $request->get('province_id'));
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $regencies = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $regencies
        ]);
    }

    public function getDistricts(Request $request): JsonResponse
    {
        $query = \App\Models\RegDistricts::query();

        // Filter by regency_id
        if ($request->has('regency_id')) {
            $query->where('regency_id', $request->get('regency_id'));
        }

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        $districts = $query->get();
        
        return response()->json([
            'success' => true,
            'data' => $districts
        ]);
    }
}