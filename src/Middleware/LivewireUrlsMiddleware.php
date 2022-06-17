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

        session()->put('livewire-urls.current', $currentUrl = $request->url());
        session()->put('livewire-urls.current-route', $currentRoute = $request->route()?->getName());

        session()->push('livewire-urls.history', $currentUrl);
        session()->push('livewire-urls.history-route', $currentRoute);

        $this->trimSession();

        return $next($request);
    }

    protected function isLivewireRequest(): bool
    {
        return class_exists(LivewireManager::class) && app(LivewireManager::class)->isLivewireRequest();
    }

    protected function trimSession(): void
    {
        $history = session()->get('livewire-urls.history', []);
        $historyRoute = session()->get('livewire-urls.history-route', []);

        if (count($history) > 20) {
            session()->put('livewire-urls.history', collect($history)->reverse()->slice(0, 20)->reverse()->all());
        }

        if (count($historyRoute) > 20) {
            session()->put('livewire-urls.history-route', collect($historyRoute)->reverse()->slice(0, 20)->reverse()->all());
        }
    }
}
