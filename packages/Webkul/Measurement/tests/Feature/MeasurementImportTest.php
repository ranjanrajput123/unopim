<?php

use Webkul\Attribute\Models\Attribute;
use Webkul\Measurement\Models\AttributeMeasurement;
use Webkul\Measurement\Models\MeasurementFamily;
use Webkul\Measurement\Tests\MeasurementTestCase;

uses(
    Webkul\Measurement\Tests\MeasurementTestCase::class
)->group('measurement', 'admin');

it('allows measurement product import headers with unit columns', function () {
    $attribute = Attribute::factory()->create([
        'type' => 'measurement',
    ]);

    $family = MeasurementFamily::factory()->create([
        'code' => 'speed',
        'units' => [
            [
                'code' => 'knot',
                'labels' => ['en_US' => 'Knot'],
            ],
        ],
    ]);

    AttributeMeasurement::create([
        'attribute_id' => $attribute->id,
        'family_code' => $family->code,
        'unit_code' => 'knot',
    ]);

    $importer = app(\Webkul\DataTransfer\Helpers\Importers\Product\Importer::class);

    expect($importer->getValidColumnNames())->toContain($attribute->code);
    expect($importer->getValidColumnNames())->toContain($attribute->code.'(unit)');
    expect($importer->getValidColumnNames())->toContain($attribute->code.'_value');
    expect($importer->getValidColumnNames())->toContain($attribute->code.'_unit');
});

it('uses conditional validation for measurement unit columns', function () {
    $importer = app(\Webkul\DataTransfer\Helpers\Importers\Product\Importer::class);

    $reflection = new ReflectionMethod($importer, 'getMeasurementUnitValidationRules');
    $reflection->setAccessible(true);

    expect($reflection->invoke($importer, 'dummy'))->toEqual(['nullable', 'required_with:dummy_value']);
});

it('allows measurement underscore value columns to be optional when main measurement field is used', function () {
    $importer = app(\Webkul\DataTransfer\Helpers\Importers\Product\Importer::class);

    $reflection = new ReflectionMethod($importer, 'getMeasurementValueValidationRules');
    $reflection->setAccessible(true);

    expect($reflection->invoke($importer, ['required']))->toEqual(['nullable']);
});

it('keeps measurement import values as raw value/unit arrays for saving', function () {
    $attribute = Attribute::factory()->create([
        'type' => 'measurement',
    ]);

    $fieldProcessor = app(\Webkul\DataTransfer\Helpers\Importers\FieldProcessor::class);

    expect($fieldProcessor->handleField($attribute, ['value' => 10, 'unit' => 'kg']))->toEqual([
        'value' => 10,
        'unit'  => 'kg',
    ]);

    expect($fieldProcessor->handleField($attribute, 'kg, 10'))->toEqual([
        'value' => '10',
        'unit'  => 'kg',
    ]);
});
