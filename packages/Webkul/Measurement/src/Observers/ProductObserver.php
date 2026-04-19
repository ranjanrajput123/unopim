<?php

namespace Webkul\Measurement\Observers;

use Webkul\Measurement\Helpers\MeasurementHelper;
use Webkul\Measurement\Repository\AttributeMeasurementRepository;
use Webkul\Product\Models\Product;

class ProductObserver
{
    protected $helper;

    protected $attributeMeasurementRepository;

    public function __construct(
        MeasurementHelper $helper,
        AttributeMeasurementRepository $attributeMeasurementRepository
    ) {
        $this->helper = $helper;
        $this->attributeMeasurementRepository = $attributeMeasurementRepository;
    }

    public function saving(Product $product)
    {
        $values = $product->values;

        $this->processMeasurementValues($values);

        $product->values = $values;
    }

    protected function processMeasurementValues(array &$values)
    {
        foreach ($values as $scope => &$scopedValues) {
            if ($scope === 'common') {
                $this->processScope($scopedValues);
            } elseif ($scope === 'locale_specific') {
                foreach ($scopedValues as &$localeValues) {
                    $this->processScope($localeValues);
                }
            } elseif ($scope === 'channel_specific') {
                foreach ($scopedValues as &$channelValues) {
                    $this->processScope($channelValues);
                }
            } elseif ($scope === 'channel_locale_specific') {
                foreach ($scopedValues as &$channelValues) {
                    foreach ($channelValues as &$localeValues) {
                        $this->processScope($localeValues);
                    }
                }
            }
        }
    }

    protected function processScope(array &$scopedValues)
    {
        foreach ($scopedValues as $attributeCode => $value) { 
            $attribute = app(\Webkul\Attribute\Repositories\AttributeRepository::class)
                ->findOneByField('code', $attributeCode);

            if ($attribute && $attribute->type === 'measurement' && is_array($value)) {
                
                if (! isset($value['value']) || $value['value'] === '' || $value['value'] === null) {
                    unset($scopedValues[$attributeCode]);
                    continue;
                }

                $measurement = $this->attributeMeasurementRepository->getByAttributeId($attribute->id);

                if ($measurement && $measurement->family) {
                    $family = $measurement->family;
                    $baseUnit = $family->standard_unit;
                    $baseData = $this->calculateBaseData($value['value'], $value['unit'], $family);

                    $scopedValues[$attributeCode] = [
                        'unit'      => $value['unit'],
                        'amount'    => number_format((float) $value['value'], 4, '.', ''),
                        'family'    => $family->code,
                        'base_data' => number_format((float) $baseData, 6, '.', ''),
                        'base_unit' => $baseUnit,
                    ];
                }
            }
        }
    }

    protected function calculateBaseData($value, $unit, $family)
    {
        $units = collect($family->units);
        $unitData = $units->firstWhere('code', $unit);

        if (!$unitData) {
            return $value;
        }

        $conversions = $unitData['convert_from_standard'] ?? [];
        $baseValue = $value;

        foreach ($conversions as $conversion) {
            $op = $conversion['operator'];
            $val = $conversion['value'];

            if ($op === 'mul') {
                $baseValue *= $val;
            } elseif ($op === 'div') {
                $baseValue /= $val;
            } elseif ($op === 'add') {
                $baseValue += $val;
            } elseif ($op === 'sub') {
                $baseValue -= $val;
            }
        }

        return $baseValue;
    }
}