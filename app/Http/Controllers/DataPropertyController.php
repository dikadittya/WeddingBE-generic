<?php

namespace App\Http\Controllers;

use App\Models\DataProperty;
use Illuminate\Http\Request;

class DataPropertyController extends Controller
{
    /**
     * Get list of all properties without pagination
     */
    public function listProperty()
    {
        $properties = DataProperty::all();

        return response()->json([
            'success' => true,
            'data' => $properties
        ], 200);
    }
}
