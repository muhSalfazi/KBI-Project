<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Part;
use App\Models\InnerPart;
use App\Models\OuterPart;

class PartControllerApi extends Controller
{
    /**
     * Display the list of parts
     */
    public function index(Request $request)
    {
        $parts = Part::with(['innerPart', 'outerPart'])->orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $parts,
        ], 200);
    }

}
