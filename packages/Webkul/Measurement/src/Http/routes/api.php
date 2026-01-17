<?php

use Illuminate\Support\Facades\Route;
use Webkul\Measurement\Http\Controllers\Api\MeasurementController;

Route::group([
    'prefix'     => 'api/admin/measurement',
    'middleware' => ['api', 'admin'],
], function () {
    Route::get('/families', [MeasurementController::class, 'index']);
});
