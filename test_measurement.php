<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$app->register(\Webkul\Measurement\Providers\MeasurementServiceProvider::class);

$importer = app(\Webkul\DataTransfer\Helpers\Importers\Product\Importer::class);
echo "Importer class: " . get_class($importer) . "\n";

if (method_exists($importer, 'addMeasurementAttributesColumns')) {
    echo "Measurement methods available: YES\n";
} else {
    echo "Measurement methods available: NO\n";
}