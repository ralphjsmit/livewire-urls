<?php

namespace RalphJSmit\Livewire\Urls\Middleware;

use Closure;
use Illuminate\Http\Request;
use Livewire\LivewireManager;

class LivewireUrlsMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->isLivewireRequest()) {
            return $next($request);
        }

        session()->put('livewire-urls.previous', session()->get('livewire-urls.current', null));
        session()->put('livewire-urls.previous-route', session()->get('livewire-urls.current-route', null));

        session()->put('livewire-urls.current', $request->url());
        session()->put('livewire-urls.current-route', $request->route()?->getName());

        return $next($request);
    }

    protected function isLivewireRequest(): bool
    {
        return class_exists(LivewireManager::class) && app(LivewireManager::class)->isLivewireRequest();
    }
}
