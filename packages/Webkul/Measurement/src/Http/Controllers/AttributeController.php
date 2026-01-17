<?php

namespace Webkul\Measurement\Http\Controllers;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Measurement\Repository\AttributeMeasurementRepository;
use Webkul\Measurement\Repository\MeasurementFamilyRepository;

class AttributeController extends Controller
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

    public function getAttributeMeasurement($attributeId)
    {
        $families = $this->familyRepository->all();

        $familyOptions = $families->map(function ($f) {
            return [
                'id'    => $f->code,
                'label' => $f->name,
                'units' => collect($f->units ?? [])
                    ->map(function ($u) {
                        return [
                            'id'    => $u['code'],
                            'label' => $u['labels']['en_US'] ?? $u['code'],
                        ];
                    })
                    ->values()
                    ->toArray(),
            ];
        })
        ->values()
        ->toArray();

        $measurement = $this->attributeMeasurementRepository
            ->getByAttributeId($attributeId);

        return response()->json([
            'familyOptions' => $familyOptions,
            'oldFamily'     => $measurement->family_code ?? '',
            'oldUnit'       => $measurement->unit_code ?? '',
        ]);
    }
}
