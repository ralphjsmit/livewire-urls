<?php

namespace RalphJSmit\Livewire\Urls\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RalphJSmit\Livewire\Urls\Url
 * @method static null|string current( ?string $fallback = null )
 * @method static null|string currentRoute( ?string $fallback = null )
 * @method static null|string previous( ?string $fallback = null )
 * @method static null|string previousRoute( ?string $fallback = null )
 * @method static null|string lastRecorded( ?string $fallback = null )
 * @method static null|string lastRecordedRoute( ?string $fallback = null )
 */
class Url extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \RalphJSmit\Livewire\Urls\Url::class;
    }
}
