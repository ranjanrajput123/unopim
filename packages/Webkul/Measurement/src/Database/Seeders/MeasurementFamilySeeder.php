<?php

namespace Webkul\Measurement\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Measurement\Models\MeasurementFamily;

class MeasurementFamilySeeder extends Seeder
{
    public function run($parameters = [])
    {
        $parameters     = $parameters ?? [];
        $defaultLocale  = $parameters['default_locale'] ?? config('app.locale');
        $locales        = $parameters['allowed_locales'] ?? [$defaultLocale];

        $makeLabels = function ($value) use ($locales) {
            $labels = [];

            foreach ($locales as $locale) {
                $labels[$locale] = ucfirst($value);
            }

            return $labels;
        };

        /*
        |--------------------------------------------------------------------------
        | 1. LENGTH
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'length'],
            [
                'name'          => 'Length',
                'labels'        => $makeLabels('length'),
                'standard_unit' => 'meter',
                'symbol'        => 'm',
                'units'         => [
                    ['code' => 'meter',       'labels' => $makeLabels('meter'),       'symbol' => 'm', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'centimeter',  'labels' => $makeLabels('centimeter'),  'symbol' => 'cm', 'convert_from_standard' => [['value' => '100', 'operator' => 'mul']]],
                    ['code' => 'millimeter',  'labels' => $makeLabels('millimeter'),  'symbol' => 'mm', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'kilometer',   'labels' => $makeLabels('kilometer'),   'symbol' => 'km', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'inch',        'labels' => $makeLabels('inch'),        'symbol' => 'in', 'convert_from_standard' => [['value' => '39.3701', 'operator' => 'mul']]],
                    ['code' => 'foot',        'labels' => $makeLabels('foot'),        'symbol' => 'ft', 'convert_from_standard' => [['value' => '3.28084', 'operator' => 'mul']]],
                    ['code' => 'yard',        'labels' => $makeLabels('yard'),        'symbol' => 'yd', 'convert_from_standard' => [['value' => '1.09361', 'operator' => 'mul']]],
                    ['code' => 'mile',        'labels' => $makeLabels('mile'),        'symbol' => 'mi', 'convert_from_standard' => [['value' => '0.000621371', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. AREA
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'area'],
            [
                'name'          => 'Area',
                'labels'        => $makeLabels('area'),
                'standard_unit' => 'square_meter',
                'symbol'        => 'm²',
                'units'         => [
                    ['code' => 'square_meter',      'labels' => $makeLabels('square meter'),      'symbol' => 'm²', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'square_centimeter', 'labels' => $makeLabels('square centimeter'), 'symbol' => 'cm²', 'convert_from_standard' => [['value' => '10000', 'operator' => 'mul']]],
                    ['code' => 'square_kilometer',  'labels' => $makeLabels('square kilometer'),  'symbol' => 'km²', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                    ['code' => 'square_foot',       'labels' => $makeLabels('square foot'),       'symbol' => 'ft²', 'convert_from_standard' => [['value' => '10.7639', 'operator' => 'mul']]],
                    ['code' => 'square_inch',       'labels' => $makeLabels('square inch'),       'symbol' => 'in²', 'convert_from_standard' => [['value' => '1550', 'operator' => 'mul']]],
                    ['code' => 'square_yard',       'labels' => $makeLabels('square yard'),       'symbol' => 'yd²', 'convert_from_standard' => [['value' => '1.19599', 'operator' => 'mul']]],
                    ['code' => 'hectare',           'labels' => $makeLabels('hectare'),           'symbol' => 'ha', 'convert_from_standard' => [['value' => '10000', 'operator' => 'div']]],
                    ['code' => 'acre',              'labels' => $makeLabels('acre'),              'symbol' => 'ac', 'convert_from_standard' => [['value' => '0.000247105', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 3. WEIGHT
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'weight'],
            [
                'name'          => 'Weight',
                'labels'        => $makeLabels('weight'),
                'standard_unit' => 'kilogram',
                'symbol'        => 'kg',
                'units'         => [
                    ['code' => 'milligram', 'labels' => $makeLabels('milligram'), 'symbol' => 'mg', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'mul']]],
                    ['code' => 'gram',      'labels' => $makeLabels('gram'),      'symbol' => 'g', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'kilogram',  'labels' => $makeLabels('kilogram'),  'symbol' => 'kg', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'tonne',     'labels' => $makeLabels('tonne'),     'symbol' => 't', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'pound',     'labels' => $makeLabels('pound'),     'symbol' => 'lb', 'convert_from_standard' => [['value' => '2.20462', 'operator' => 'mul']]],
                    ['code' => 'ounce',     'labels' => $makeLabels('ounce'),     'symbol' => 'oz', 'convert_from_standard' => [['value' => '35.274', 'operator' => 'mul']]],
                    ['code' => 'stone',     'labels' => $makeLabels('stone'),     'symbol' => 'st', 'convert_from_standard' => [['value' => '0.157473', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 4. VOLUME
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'volume'],
            [
                'name'          => 'Volume',
                'labels'        => $makeLabels('volume'),
                'standard_unit' => 'liter',
                'symbol'        => 'L',
                'units'         => [
                    ['code' => 'milliliter',  'labels' => $makeLabels('milliliter'),  'symbol' => 'ml', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'centiliter',  'labels' => $makeLabels('centiliter'),  'symbol' => 'cl', 'convert_from_standard' => [['value' => '100', 'operator' => 'mul']]],
                    ['code' => 'liter',       'labels' => $makeLabels('liter'),       'symbol' => 'L', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'cubic_meter', 'labels' => $makeLabels('cubic meter'), 'symbol' => 'm³', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'cubic_inch',  'labels' => $makeLabels('cubic inch'),  'symbol' => 'in³', 'convert_from_standard' => [['value' => '61.0237', 'operator' => 'mul']]],
                    ['code' => 'cubic_foot',  'labels' => $makeLabels('cubic foot'),  'symbol' => 'ft³', 'convert_from_standard' => [['value' => '0.0353147', 'operator' => 'mul']]],
                    ['code' => 'gallon',      'labels' => $makeLabels('gallon'),      'symbol' => 'gal', 'convert_from_standard' => [['value' => '0.264172', 'operator' => 'mul']]],
                    ['code' => 'fluid_ounce', 'labels' => $makeLabels('fluid ounce'), 'symbol' => 'fl oz', 'convert_from_standard' => [['value' => '33.814', 'operator' => 'mul']]],
                    ['code' => 'pint',        'labels' => $makeLabels('pint'),        'symbol' => 'pt', 'convert_from_standard' => [['value' => '2.11338', 'operator' => 'mul']]],
                    ['code' => 'quart',       'labels' => $makeLabels('quart'),       'symbol' => 'qt', 'convert_from_standard' => [['value' => '1.05669', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 5. TEMPERATURE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'temperature'],
            [
                'name'          => 'Temperature',
                'labels'        => $makeLabels('temperature'),
                'standard_unit' => 'celsius',
                'symbol'        => '°C',
                'units'         => [
                    ['code' => 'celsius',    'labels' => $makeLabels('celsius'),    'symbol' => '°C', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'fahrenheit', 'labels' => $makeLabels('fahrenheit'), 'symbol' => '°F', 'convert_from_standard' => [['value' => '9', 'operator' => 'mul'], ['value' => '5', 'operator' => 'div'], ['value' => '32', 'operator' => 'add']]],
                    ['code' => 'kelvin',     'labels' => $makeLabels('kelvin'),     'symbol' => 'K', 'convert_from_standard' => [['value' => '273.15', 'operator' => 'add']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 6. SPEED
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'speed'],
            [
                'name'          => 'Speed',
                'labels'        => $makeLabels('speed'),
                'standard_unit' => 'meter_per_second',
                'symbol'        => 'm/s',
                'units'         => [
                    ['code' => 'meter_per_second',     'labels' => $makeLabels('meter per second'),     'symbol' => 'm/s', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilometer_per_hour',   'labels' => $makeLabels('kilometer per hour'),   'symbol' => 'km/h', 'convert_from_standard' => [['value' => '3.6', 'operator' => 'mul']]],
                    ['code' => 'mile_per_hour',        'labels' => $makeLabels('mile per hour'),        'symbol' => 'mph', 'convert_from_standard' => [['value' => '2.23694', 'operator' => 'mul']]],
                    ['code' => 'knot',                 'labels' => $makeLabels('knot'),                 'symbol' => 'kn', 'convert_from_standard' => [['value' => '1.94384', 'operator' => 'mul']]],
                    ['code' => 'foot_per_second',      'labels' => $makeLabels('foot per second'),      'symbol' => 'ft/s', 'convert_from_standard' => [['value' => '3.28084', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 7. TIME
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'time'],
            [
                'name'          => 'Time',
                'labels'        => $makeLabels('time'),
                'standard_unit' => 'second',
                'symbol'        => 's',
                'units'         => [
                    ['code' => 'millisecond', 'labels' => $makeLabels('millisecond'), 'symbol' => 'ms', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'second',      'labels' => $makeLabels('second'),      'symbol' => 's', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'minute',      'labels' => $makeLabels('minute'),      'symbol' => 'min', 'convert_from_standard' => [['value' => '60', 'operator' => 'div']]],
                    ['code' => 'hour',        'labels' => $makeLabels('hour'),        'symbol' => 'h', 'convert_from_standard' => [['value' => '3600', 'operator' => 'div']]],
                    ['code' => 'day',         'labels' => $makeLabels('day'),         'symbol' => 'd', 'convert_from_standard' => [['value' => '86400', 'operator' => 'div']]],
                    ['code' => 'week',        'labels' => $makeLabels('week'),        'symbol' => 'wk', 'convert_from_standard' => [['value' => '604800', 'operator' => 'div']]],
                    ['code' => 'month',       'labels' => $makeLabels('month'),       'symbol' => 'mo', 'convert_from_standard' => [['value' => '2592000', 'operator' => 'div']]],
                    ['code' => 'year',        'labels' => $makeLabels('year'),        'symbol' => 'yr', 'convert_from_standard' => [['value' => '31536000', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 8. PRESSURE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'pressure'],
            [
                'name'          => 'Pressure',
                'labels'        => $makeLabels('pressure'),
                'standard_unit' => 'pascal',
                'symbol'        => 'Pa',
                'units'         => [
                    ['code' => 'pascal',      'labels' => $makeLabels('pascal'),      'symbol' => 'Pa', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilopascal',  'labels' => $makeLabels('kilopascal'),  'symbol' => 'kPa', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'megapascal',  'labels' => $makeLabels('megapascal'),  'symbol' => 'MPa', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                    ['code' => 'bar',         'labels' => $makeLabels('bar'),         'symbol' => 'bar', 'convert_from_standard' => [['value' => '100000', 'operator' => 'div']]],
                    ['code' => 'millibar',    'labels' => $makeLabels('millibar'),    'symbol' => 'mbar', 'convert_from_standard' => [['value' => '100', 'operator' => 'div']]],
                    ['code' => 'atmosphere',  'labels' => $makeLabels('atmosphere'),  'symbol' => 'atm', 'convert_from_standard' => [['value' => '101325', 'operator' => 'div']]],
                    ['code' => 'psi',         'labels' => $makeLabels('psi'),         'symbol' => 'psi', 'convert_from_standard' => [['value' => '6894.76', 'operator' => 'div']]],
                    ['code' => 'torr',        'labels' => $makeLabels('torr'),        'symbol' => 'Torr', 'convert_from_standard' => [['value' => '133.322', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 9. ENERGY
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'energy'],
            [
                'name'          => 'Energy',
                'labels'        => $makeLabels('energy'),
                'standard_unit' => 'joule',
                'symbol'        => 'J',
                'units'         => [
                    ['code' => 'joule',           'labels' => $makeLabels('joule'),           'symbol' => 'J', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilojoule',       'labels' => $makeLabels('kilojoule'),       'symbol' => 'kJ', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'calorie',         'labels' => $makeLabels('calorie'),         'symbol' => 'cal', 'convert_from_standard' => [['value' => '4.184', 'operator' => 'div']]],
                    ['code' => 'kilocalorie',     'labels' => $makeLabels('kilocalorie'),     'symbol' => 'kcal', 'convert_from_standard' => [['value' => '4184', 'operator' => 'div']]],
                    ['code' => 'watt_hour',       'labels' => $makeLabels('watt hour'),       'symbol' => 'Wh', 'convert_from_standard' => [['value' => '3600', 'operator' => 'div']]],
                    ['code' => 'kilowatt_hour',   'labels' => $makeLabels('kilowatt hour'),   'symbol' => 'kWh', 'convert_from_standard' => [['value' => '3600000', 'operator' => 'div']]],
                    ['code' => 'electronvolt',    'labels' => $makeLabels('electronvolt'),    'symbol' => 'eV', 'convert_from_standard' => [['value' => '1.60218e-19', 'operator' => 'div']]],
                    ['code' => 'british_thermal_unit', 'labels' => $makeLabels('british thermal unit'), 'symbol' => 'BTU', 'convert_from_standard' => [['value' => '1055.06', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 10. POWER
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'power'],
            [
                'name'          => 'Power',
                'labels'        => $makeLabels('power'),
                'standard_unit' => 'watt',
                'symbol'        => 'W',
                'units'         => [
                    ['code' => 'milliwatt',  'labels' => $makeLabels('milliwatt'),  'symbol' => 'mW', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'watt',       'labels' => $makeLabels('watt'),       'symbol' => 'W', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilowatt',   'labels' => $makeLabels('kilowatt'),   'symbol' => 'kW', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'megawatt',   'labels' => $makeLabels('megawatt'),   'symbol' => 'MW', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                    ['code' => 'gigawatt',   'labels' => $makeLabels('gigawatt'),   'symbol' => 'GW', 'convert_from_standard' => [['value' => '1000000000', 'operator' => 'div']]],
                    ['code' => 'horsepower', 'labels' => $makeLabels('horsepower'), 'symbol' => 'hp', 'convert_from_standard' => [['value' => '745.7', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 11. FREQUENCY
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'frequency'],
            [
                'name'          => 'Frequency',
                'labels'        => $makeLabels('frequency'),
                'standard_unit' => 'hertz',
                'symbol'        => 'Hz',
                'units'         => [
                    ['code' => 'hertz',     'labels' => $makeLabels('hertz'),     'symbol' => 'Hz', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilohertz', 'labels' => $makeLabels('kilohertz'), 'symbol' => 'kHz', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'megahertz', 'labels' => $makeLabels('megahertz'), 'symbol' => 'MHz', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                    ['code' => 'gigahertz', 'labels' => $makeLabels('gigahertz'), 'symbol' => 'GHz', 'convert_from_standard' => [['value' => '1000000000', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 12. DIGITAL STORAGE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'digital_storage'],
            [
                'name'          => 'Digital Storage',
                'labels'        => $makeLabels('digital storage'),
                'standard_unit' => 'byte',
                'symbol'        => 'B',
                'units'         => [
                    ['code' => 'bit',      'labels' => $makeLabels('bit'),      'symbol' => 'b', 'convert_from_standard' => [['value' => '8', 'operator' => 'mul']]],
                    ['code' => 'byte',     'labels' => $makeLabels('byte'),     'symbol' => 'B', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilobyte', 'labels' => $makeLabels('kilobyte'), 'symbol' => 'KB', 'convert_from_standard' => [['value' => '1024', 'operator' => 'div']]],
                    ['code' => 'megabyte', 'labels' => $makeLabels('megabyte'), 'symbol' => 'MB', 'convert_from_standard' => [['value' => '1048576', 'operator' => 'div']]],
                    ['code' => 'gigabyte', 'labels' => $makeLabels('gigabyte'), 'symbol' => 'GB', 'convert_from_standard' => [['value' => '1073741824', 'operator' => 'div']]],
                    ['code' => 'terabyte', 'labels' => $makeLabels('terabyte'), 'symbol' => 'TB', 'convert_from_standard' => [['value' => '1099511627776', 'operator' => 'div']]],
                    ['code' => 'petabyte', 'labels' => $makeLabels('petabyte'), 'symbol' => 'PB', 'convert_from_standard' => [['value' => '1125899906842624', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 13. ANGLE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'angle'],
            [
                'name'          => 'Angle',
                'labels'        => $makeLabels('angle'),
                'standard_unit' => 'degree',
                'symbol'        => '°',
                'units'         => [
                    ['code' => 'degree',     'labels' => $makeLabels('degree'),     'symbol' => '°', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'radian',     'labels' => $makeLabels('radian'),     'symbol' => 'rad', 'convert_from_standard' => [['value' => '57.2958', 'operator' => 'mul']]],
                    ['code' => 'gradian',    'labels' => $makeLabels('gradian'),    'symbol' => 'grad', 'convert_from_standard' => [['value' => '1.11111', 'operator' => 'mul']]],
                    ['code' => 'arcminute',  'labels' => $makeLabels('arcminute'),  'symbol' => '\'', 'convert_from_standard' => [['value' => '60', 'operator' => 'mul']]],
                    ['code' => 'arcsecond',  'labels' => $makeLabels('arcsecond'),  'symbol' => '"', 'convert_from_standard' => [['value' => '3600', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 14. ELECTRIC CURRENT
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'electric_current'],
            [
                'name'          => 'Electric Current',
                'labels'        => $makeLabels('electric current'),
                'standard_unit' => 'ampere',
                'symbol'        => 'A',
                'units'         => [
                    ['code' => 'microampere', 'labels' => $makeLabels('microampere'), 'symbol' => 'µA', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'mul']]],
                    ['code' => 'milliampere', 'labels' => $makeLabels('milliampere'), 'symbol' => 'mA', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'ampere',      'labels' => $makeLabels('ampere'),      'symbol' => 'A', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kiloampere',  'labels' => $makeLabels('kiloampere'),  'symbol' => 'kA', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 15. VOLTAGE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'voltage'],
            [
                'name'          => 'Voltage',
                'labels'        => $makeLabels('voltage'),
                'standard_unit' => 'volt',
                'symbol'        => 'V',
                'units'         => [
                    ['code' => 'microvolt',  'labels' => $makeLabels('microvolt'),  'symbol' => 'µV', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'mul']]],
                    ['code' => 'millivolt',  'labels' => $makeLabels('millivolt'),  'symbol' => 'mV', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'volt',       'labels' => $makeLabels('volt'),       'symbol' => 'V', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilovolt',   'labels' => $makeLabels('kilovolt'),   'symbol' => 'kV', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'megavolt',   'labels' => $makeLabels('megavolt'),   'symbol' => 'MV', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 16. RESISTANCE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'resistance'],
            [
                'name'          => 'Resistance',
                'labels'        => $makeLabels('resistance'),
                'standard_unit' => 'ohm',
                'symbol'        => 'Ω',
                'units'         => [
                    ['code' => 'milliohm', 'labels' => $makeLabels('milliohm'), 'symbol' => 'mΩ', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'ohm',      'labels' => $makeLabels('ohm'),      'symbol' => 'Ω', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilohm',   'labels' => $makeLabels('kilohm'),   'symbol' => 'kΩ', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'megaohm',  'labels' => $makeLabels('megaohm'),  'symbol' => 'MΩ', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 17. FORCE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'force'],
            [
                'name'          => 'Force',
                'labels'        => $makeLabels('force'),
                'standard_unit' => 'newton',
                'symbol'        => 'N',
                'units'         => [
                    ['code' => 'newton',      'labels' => $makeLabels('newton'),      'symbol' => 'N', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilonewton',  'labels' => $makeLabels('kilonewton'),  'symbol' => 'kN', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'meganewton',  'labels' => $makeLabels('meganewton'),  'symbol' => 'MN', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                    ['code' => 'dyne',        'labels' => $makeLabels('dyne'),        'symbol' => 'dyn', 'convert_from_standard' => [['value' => '100000', 'operator' => 'mul']]],
                    ['code' => 'pound_force', 'labels' => $makeLabels('pound force'), 'symbol' => 'lbf', 'convert_from_standard' => [['value' => '0.224809', 'operator' => 'mul']]],
                    ['code' => 'kilogram_force', 'labels' => $makeLabels('kilogram force'), 'symbol' => 'kgf', 'convert_from_standard' => [['value' => '0.101972', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 18. DENSITY
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'density'],
            [
                'name'          => 'Density',
                'labels'        => $makeLabels('density'),
                'standard_unit' => 'kilogram_per_cubic_meter',
                'symbol'        => 'kg/m³',
                'units'         => [
                    ['code' => 'kilogram_per_cubic_meter', 'labels' => $makeLabels('kilogram per cubic meter'), 'symbol' => 'kg/m³', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'gram_per_cubic_centimeter', 'labels' => $makeLabels('gram per cubic centimeter'), 'symbol' => 'g/cm³', 'convert_from_standard' => [['value' => '0.001', 'operator' => 'mul']]],
                    ['code' => 'gram_per_liter',           'labels' => $makeLabels('gram per liter'),           'symbol' => 'g/L', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilogram_per_liter',       'labels' => $makeLabels('kilogram per liter'),       'symbol' => 'kg/L', 'convert_from_standard' => [['value' => '0.001', 'operator' => 'mul']]],
                    ['code' => 'pound_per_cubic_foot',     'labels' => $makeLabels('pound per cubic foot'),     'symbol' => 'lb/ft³', 'convert_from_standard' => [['value' => '0.0624279', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 19. LUMINANCE / ILLUMINANCE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'illuminance'],
            [
                'name'          => 'Illuminance',
                'labels'        => $makeLabels('illuminance'),
                'standard_unit' => 'lux',
                'symbol'        => 'lx',
                'units'         => [
                    ['code' => 'lux',       'labels' => $makeLabels('lux'),       'symbol' => 'lx', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'footcandle', 'labels' => $makeLabels('footcandle'), 'symbol' => 'fc', 'convert_from_standard' => [['value' => '0.0929', 'operator' => 'mul']]],
                    ['code' => 'phot',      'labels' => $makeLabels('phot'),      'symbol' => 'ph', 'convert_from_standard' => [['value' => '0.0001', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 20. RADIOACTIVITY
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'radioactivity'],
            [
                'name'          => 'Radioactivity',
                'labels'        => $makeLabels('radioactivity'),
                'standard_unit' => 'becquerel',
                'symbol'        => 'Bq',
                'units'         => [
                    ['code' => 'becquerel',  'labels' => $makeLabels('becquerel'),  'symbol' => 'Bq', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilobecquerel', 'labels' => $makeLabels('kilobecquerel'), 'symbol' => 'kBq', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'megabecquerel', 'labels' => $makeLabels('megabecquerel'), 'symbol' => 'MBq', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'div']]],
                    ['code' => 'curie',      'labels' => $makeLabels('curie'),      'symbol' => 'Ci', 'convert_from_standard' => [['value' => '3.7e10', 'operator' => 'div']]],
                    ['code' => 'millicurie', 'labels' => $makeLabels('millicurie'), 'symbol' => 'mCi', 'convert_from_standard' => [['value' => '3.7e7', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 21. FUEL CONSUMPTION
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'fuel_consumption'],
            [
                'name'          => 'Fuel Consumption',
                'labels'        => $makeLabels('fuel consumption'),
                'standard_unit' => 'liter_per_100km',
                'symbol'        => 'L/100km',
                'units'         => [
                    ['code' => 'liter_per_100km',      'labels' => $makeLabels('liter per 100km'),      'symbol' => 'L/100km', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilometer_per_liter',  'labels' => $makeLabels('kilometer per liter'),  'symbol' => 'km/L', 'convert_from_standard' => [['value' => '100', 'operator' => 'div']]],
                    ['code' => 'mile_per_gallon',      'labels' => $makeLabels('mile per gallon'),      'symbol' => 'mpg', 'convert_from_standard' => [['value' => '235.214', 'operator' => 'div']]],
                    ['code' => 'mile_per_liter',       'labels' => $makeLabels('mile per liter'),       'symbol' => 'mi/L', 'convert_from_standard' => [['value' => '62.1371', 'operator' => 'div']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 22. CONCENTRATION
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'concentration'],
            [
                'name'          => 'Concentration',
                'labels'        => $makeLabels('concentration'),
                'standard_unit' => 'mole_per_liter',
                'symbol'        => 'mol/L',
                'units'         => [
                    ['code' => 'mole_per_liter',        'labels' => $makeLabels('mole per liter'),        'symbol' => 'mol/L', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'millimole_per_liter',   'labels' => $makeLabels('millimole per liter'),   'symbol' => 'mmol/L', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'microgram_per_liter',   'labels' => $makeLabels('microgram per liter'),   'symbol' => 'µg/L', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'mul']]],
                    ['code' => 'milligram_per_liter',   'labels' => $makeLabels('milligram per liter'),   'symbol' => 'mg/L', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'gram_per_liter_conc',   'labels' => $makeLabels('gram per liter'),        'symbol' => 'g/L', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'parts_per_million',     'labels' => $makeLabels('parts per million'),     'symbol' => 'ppm', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'parts_per_billion',     'labels' => $makeLabels('parts per billion'),     'symbol' => 'ppb', 'convert_from_standard' => [['value' => '1000000', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 23. TORQUE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'torque'],
            [
                'name'          => 'Torque',
                'labels'        => $makeLabels('torque'),
                'standard_unit' => 'newton_meter',
                'symbol'        => 'N·m',
                'units'         => [
                    ['code' => 'newton_meter',         'labels' => $makeLabels('newton meter'),         'symbol' => 'N·m', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'newton_centimeter',    'labels' => $makeLabels('newton centimeter'),    'symbol' => 'N·cm', 'convert_from_standard' => [['value' => '100', 'operator' => 'mul']]],
                    ['code' => 'kilonewton_meter',     'labels' => $makeLabels('kilonewton meter'),     'symbol' => 'kN·m', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'pound_foot',           'labels' => $makeLabels('pound foot'),           'symbol' => 'lb·ft', 'convert_from_standard' => [['value' => '0.737562', 'operator' => 'mul']]],
                    ['code' => 'pound_inch',           'labels' => $makeLabels('pound inch'),           'symbol' => 'lb·in', 'convert_from_standard' => [['value' => '8.85075', 'operator' => 'mul']]],
                    ['code' => 'kilogram_force_meter', 'labels' => $makeLabels('kilogram force meter'), 'symbol' => 'kgf·m', 'convert_from_standard' => [['value' => '0.101972', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 24. FLOW RATE
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'flow_rate'],
            [
                'name'          => 'Flow Rate',
                'labels'        => $makeLabels('flow rate'),
                'standard_unit' => 'cubic_meter_per_second',
                'symbol'        => 'm³/s',
                'units'         => [
                    ['code' => 'cubic_meter_per_second',  'labels' => $makeLabels('cubic meter per second'),  'symbol' => 'm³/s', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'liter_per_second',        'labels' => $makeLabels('liter per second'),        'symbol' => 'L/s', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'liter_per_minute',        'labels' => $makeLabels('liter per minute'),        'symbol' => 'L/min', 'convert_from_standard' => [['value' => '60000', 'operator' => 'mul']]],
                    ['code' => 'liter_per_hour',          'labels' => $makeLabels('liter per hour'),          'symbol' => 'L/h', 'convert_from_standard' => [['value' => '3600000', 'operator' => 'mul']]],
                    ['code' => 'cubic_foot_per_minute',   'labels' => $makeLabels('cubic foot per minute'),   'symbol' => 'ft³/min', 'convert_from_standard' => [['value' => '2118.88', 'operator' => 'mul']]],
                    ['code' => 'gallon_per_minute',       'labels' => $makeLabels('gallon per minute'),       'symbol' => 'gal/min', 'convert_from_standard' => [['value' => '15850.4', 'operator' => 'mul']]],
                ],
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 25. LUMINOUS INTENSITY
        |--------------------------------------------------------------------------
        */
        MeasurementFamily::updateOrCreate(
            ['code' => 'luminous_intensity'],
            [
                'name'          => 'Luminous Intensity',
                'labels'        => $makeLabels('luminous intensity'),
                'standard_unit' => 'candela',
                'symbol'        => 'cd',
                'units'         => [
                    ['code' => 'millicandela', 'labels' => $makeLabels('millicandela'), 'symbol' => 'mcd', 'convert_from_standard' => [['value' => '1000', 'operator' => 'mul']]],
                    ['code' => 'candela',      'labels' => $makeLabels('candela'),      'symbol' => 'cd', 'convert_from_standard' => [['value' => '1', 'operator' => 'mul']]],
                    ['code' => 'kilocandela',  'labels' => $makeLabels('kilocandela'),  'symbol' => 'kcd', 'convert_from_standard' => [['value' => '1000', 'operator' => 'div']]],
                    ['code' => 'lumen',        'labels' => $makeLabels('lumen'),        'symbol' => 'lm', 'convert_from_standard' => [['value' => '12.5664', 'operator' => 'mul']]],
                ],
            ]
        );
    }
}