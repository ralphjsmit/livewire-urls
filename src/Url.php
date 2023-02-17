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
        return collect(session()->get('livewire-urls.history'))
            ->reverse()
            ->first(function (string $url): bool {
                return $url !== $this->current();
            }) ?? $fallback;
    }

    public function lastRecordedRoute(?string $fallback = null): ?string
    {
        return collect(session()->get('livewire-urls.history-route'))
            ->reverse()
            ->first(function (?string $route): bool {
                if ( $route === null ) {
                    return false;
                }

                return $route !== $this->currentRoute();
            }) ?? $fallback;
    }
}
