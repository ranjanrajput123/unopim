<?php

namespace Webkul\Measurement\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Webkul\Measurement\Models\MeasurementFamily;

class MeasurementController extends Controller
{
    public function index()
    {
        dd("dsfds");
        return response()->json([
            'success' => true,
            'data'    => MeasurementFamily::all(),
        ]);
    }
}
