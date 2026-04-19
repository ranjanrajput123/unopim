<?php

namespace Webkul\Measurement\Helpers\Importers;

use Webkul\DataTransfer\Helpers\Importers\FieldProcessor as CoreFieldProcessor;

class FieldProcessor extends CoreFieldProcessor
{
    protected $measurementHelper;

    public function __construct()
    {
        $this->measurementHelper = app(\Webkul\Measurement\Helpers\MeasurementHelper::class);
    }

    public function handleField($field, mixed $value, ?string $path = null)
    {
        $path = $path ?? '';
     
        if ($field->type === 'measurement' && ! empty($value)) {

            if (is_string($value)) {
                $value = str_replace('|', ',', $value);
                [$unit, $val] = array_map('trim', explode(',', $value, 2));

                return [
                    'value' => $val,
                    'unit'  => $unit,
                ];
            }

            if (is_array($value) && isset($value['value'], $value['unit'])) {
                return [
                    'value' => $value['value'],
                    'unit'  => $value['unit'],
                ];
            }

            return $value;
        }

        return parent::handleField($field, $value, $path);
    }
}
