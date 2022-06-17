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
}

