<?php

namespace Webkul\Measurement\Http\Controllers;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Measurement\Repository\MeasurementFamilyRepository;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    protected $familyRepository;

    public function __construct(MeasurementFamilyRepository $familyRepository)
    {
        $this->familyRepository = $familyRepository;
    }

    /**
     * Get all measurement families for async select
     */
    public function getFamilies()
    {
        $families = $this->familyRepository->all();

        // Return in Unopim select format
        return response()->json($families->map(function ($family) {
            return [
                'code'  => $family->code,
                'label' => $family->code, // ya $family->name agar chaho
            ];
        }));
    }

    /**
     * Get all units of a family for async select
     */
    public function getUnits(Request $request)
    {
        $familyCode = $request->query('family');
        if (!$familyCode) {
            return response()->json([]);
        }

        $family = $this->familyRepository->findOneWhere(['code' => $familyCode]);
        if (!$family || !is_array($family->units)) {
            return response()->json([]);
        }

        $units = collect($family->units)->map(function ($unit) {
            return [
                'code'  => $unit['code'],
                'label' => $unit['labels']['en_US'] ?? $unit['code'],
            ];
        });

        return response()->json($units);
    }
}
