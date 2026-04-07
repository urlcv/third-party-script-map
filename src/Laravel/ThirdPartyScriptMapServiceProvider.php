<?php

declare(strict_types=1);

namespace URLCV\ThirdPartyScriptMap\Laravel;

use Illuminate\Support\ServiceProvider;

class ThirdPartyScriptMapServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'third-party-script-map');
    }
}
