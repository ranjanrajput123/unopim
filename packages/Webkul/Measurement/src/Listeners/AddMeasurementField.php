<?php

namespace Webkul\Measurement\Listeners;

use Webkul\Measurement\Repository\MeasurementFamilyRepository;
use Webkul\Measurement\Repository\AttributeMeasurementRepository;
use Webkul\Attribute\Repositories\AttributeRepository;

class AddMeasurementField
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

    public function handle($manager): void
    {
        $attributeId = request()->route('id');
        if (! $attributeId) {
            return;
        }

        $attribute = app(AttributeRepository::class)->find($attributeId);

        if (! $attribute || $attribute->type !== 'measurement') {
            return;
        }

        $families = $this->familyRepository->all();

        $familyOptions = [];

        foreach ($families as $family) {
            $familyOptions[] = [
                'id'    => $family->code,
                'label' => $family->labels['en_US'] ?? $family->code,
                'units' => $family->units ?? [],
            ];
        }

        $measurement = $this->attributeMeasurementRepository
            ->getByAttributeId($attribute->id);

        // 🔑 IMPORTANT: second argument me blade ke liye data pass karo
        $manager->addTemplate(
            'measurement::admin.attributes.custom-filed',
            [
                'attribute'     => $attribute,
                'familyOptions' => json_encode($familyOptions),
                'oldFamily'     => $measurement?->family_code,
                'oldUnit'       => $measurement?->unit_code,
            ]
        );
    }
}
