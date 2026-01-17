<?php

namespace Webkul\Measurement\Http\Controllers;

use Webkul\Admin\Http\Controllers\VueJsSelect\AbstractOptionsController;
use Webkul\Measurement\Repository\MeasurementFamilyRepository;
use Webkul\Measurement\Repository\AttributeMeasurementRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeasurementFamilyOptionsController extends AbstractOptionsController
{
    protected $familyRepository;
    protected $attributeMeasurementRepository;

    public function __construct(
        MeasurementFamilyRepository $familyRepository,
        AttributeMeasurementRepository $attributeMeasurementRepository
    ) {
        $this->familyRepository = $familyRepository;
        $this->attributeMeasurementRepository = $attributeMeasurementRepository;
    }

    /**
     * Async endpoint for Measurement Families with units
     */
    public function getFamilies(Request $request): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);
        $query = $request->get('query', '');

        $families = $this->familyRepository
            ->where('name', 'like', "%$query%")
            ->orderBy('id')
            ->paginate($limit, ['*'], 'page', $page);

        $options = $families->map(function ($family) {
            return [
                'id' => $family->code,
                'label' => $family->name,
                'units' => collect($family->units ?? [])->map(fn($unit) => [
                    'id' => $unit['code'],
                    'label' => $unit['labels']['en_US'] ?? $unit['code'],
                ])->values()->toArray(),
            ];
        });

        return response()->json([
            'options'  => $options,  // MUST be 'options'
            'page'     => $families->currentPage(),
            'lastPage' => $families->lastPage(),
        ]);
    }

    /**
     * Get old saved values for attribute editing
     */
    public function getOldValues(Request $request): JsonResponse
    {
        $oldFamily = '';
        $oldUnit = '';

        if ($request->attribute_id) {
            $measurement = $this->attributeMeasurementRepository
                ->getByAttributeId($request->attribute_id);

            if ($measurement) {
                $oldFamily = $measurement->family_code;
                $oldUnit = $measurement->unit_code;
            }
        }

        return response()->json([
            'oldFamily' => $oldFamily,
            'oldUnit' => $oldUnit,
        ]);
    }
}
