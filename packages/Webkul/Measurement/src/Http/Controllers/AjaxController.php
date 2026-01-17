<?php

namespace Webkul\Measurement\Http\Controllers;

use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Measurement\Repository\MeasurementFamilyRepository;

class MeasurementController extends Controller
{
    public function __construct(
        protected MeasurementFamilyRepository $measurementFamilyRepository
    ) {}

    // Family dropdown
    public function families()
    {
        dd("sdfsfs");
        return $this->measurementFamilyRepository
            ->all()
            ->map(fn ($family) => [
                'code'  => $family->code,
                'label' => $family->name,
            ])
            ->values();
    }

    // Units dropdown (family dependent)
    public function units()
    {
        $familyCode = request('family');

        $family = $this->measurementFamilyRepository
            ->findOneByField('code', $familyCode);

        if (! $family) {
            return [];
        }

        return collect($family->units)
            ->map(fn ($unit) => [
                'code'  => $unit['code'],
                'label' => $unit['labels']['en_US'] ?? $unit['code'],
            ])
            ->values();
    }
}
