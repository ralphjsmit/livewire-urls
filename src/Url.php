<?php

namespace RalphJSmit\Livewire\Urls;

class Url
{
    public function current(?string $fallback = null): ?string
    {
        return session()->get('livewire-urls.current', $fallback);
    }

    public function currentRoute(?string $fallback = null): ?string
    {
        return session()->get('livewire-urls.current-route', $fallback);
    }

    public function previous(?string $fallback = null): ?string
    {
        return session()->get('livewire-urls.previous', $fallback);
    }

    public function previousRoute(?string $fallback = null): ?string
    {
        return session()->get('livewire-urls.previous-route', $fallback);
    }

    public function lastRecorded(?string $fallback = null): ?string
    {
        $lastUrlFromHistory = collect(session()->get('livewire-urls.history'))->first();

        if ($lastUrlFromHistory === $this->current($fallback)) {
            return $fallback;
        }

        return $lastUrlFromHistory ?? $fallback;
    }

    public function lastRecordedRoute(?string $fallback = null): ?string
    {
        $lastRouteFromHistory = collect(session()->get('livewire-urls.history-route'))->first();

        if ($lastRouteFromHistory === $this->currentRoute($fallback)) {
            return $fallback;
        }

        return $lastRouteFromHistory ?? $fallback;
    }
}
