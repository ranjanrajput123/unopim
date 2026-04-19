<?php

namespace Webkul\Measurement\Import;

use Webkul\Measurement\Helpers\MeasurementHelper;

class MeasurementProductImport
{
    protected $helper;

    public function __construct(MeasurementHelper $helper)
    {
        $this->helper = $helper;
    }

    public function handle($product, $row, $attribute)
    {
        if (! $this->helper->isMeasurementAttribute($attribute)) {
            return;
        }

        // Try to get value from the CSV export format (amount in main column, unit in (unit) column)
        $value = $row[$attribute->code] ?? null;
        $unit = $row[$attribute->code.'(unit)'] ?? null;

        // Fallback to the underscore format if the parentheses format is not available
        if (! $value || ! $unit) {
            $value = $row[$attribute->code.'_value'] ?? null;
            $unit = $row[$attribute->code.'_unit'] ?? null;
        }

        if (! $value || ! $unit) {
            return;
        }

        $json = $this->helper->getMeasurementValueStructure($value, $unit, $attribute);

        $product->attribute_values()->updateOrCreate(
            [
                'attribute_id' => $attribute->id,
                'channel'      => $row['channel'] ?? 'default',
                'locale'       => $row['locale'] ?? 'en_US',
            ],
            [
                'value' => json_encode($json),
            ]
        );
    }
}
