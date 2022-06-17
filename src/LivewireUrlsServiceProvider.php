<?php

namespace RalphJSmit\Livewire\Urls;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LivewireUrlsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('livewire-urls')
            ->hasConfigFile()
            ->hasViews();
    }
}
