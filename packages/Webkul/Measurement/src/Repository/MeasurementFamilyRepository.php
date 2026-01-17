<?php

namespace Webkul\Measurement\Repository;

use Webkul\Core\Eloquent\Repository;
use Webkul\Measurement\Models\MeasurementFamily;

class MeasurementFamilyRepository extends Repository
{
    public function model(): string
    {
        return MeasurementFamily::class;
    }
}
