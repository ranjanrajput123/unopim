<?php

namespace Webkul\Measurement\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class MeasurementServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'measurement');
        $this->loadViewsFrom(__DIR__ . '/../Resources/view', 'measurement');
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes/api.php');

        $this->mergeConfigFrom(
            __DIR__ . '/../Config/attribute_types.php',
            'attribute_types'
        );

        Event::listen(
            'unopim.admin.catalog.attributes.edit.card.label.after',
            fn ($manager) =>
                $manager->addTemplate(
                    'measurement::admin.attributes.custom-filed'
                )
        );

        Event::listen(
            'unopim.admin.products.dynamic-attribute-fields.control.measurement.before',
            fn ($manager) =>
                $manager->addTemplate(
                    'measurement::admin.attributes.component-attribute'
                )
        );
    }

    public function register()
    {
        config([
            'menu.admin' => array_merge(
                config('menu.admin', []),
                require __DIR__ . '/../Config/menu.php'
            ),
        ]);
    }
}
