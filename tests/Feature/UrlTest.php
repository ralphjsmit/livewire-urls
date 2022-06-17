<?php

use Illuminate\Support\Facades\Route;
use RalphJSmit\Livewire\Urls\Facades\Url;
use RalphJSmit\Livewire\Urls\Middleware\LivewireUrlsMiddleware;
use RalphJSmit\Livewire\Urls\Tests\Fixtures\TestComponent;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('can store the user url in the session on a visit', function () {
    Route::get('test')->middleware(LivewireUrlsMiddleware::class)->name('route.test');
    Route::get('test-b')->middleware(LivewireUrlsMiddleware::class)->name('route.test-b');

    expect(session()->get('livewire-urls'))->toBeNull();

    get('test');

    expect(Url::previous())->toBeNull();
    expect(Url::previousRoute())->toBeNull();
    expect(Url::current())->toBe(route('route.test'));
    expect(Url::currentRoute())->toBe('route.test');

    get('test-b');

    expect(Url::previous())->toBe(route('route.test'));
    expect(Url::previousRoute())->toBe('route.test');
    expect(Url::current())->toBe(route('route.test-b'));
    expect(Url::currentRoute())->toBe('route.test-b');

    post(route('livewire.message', ['name' => TestComponent::class]));

    expect(Url::previous())->toBe(route('route.test'));
    expect(Url::previousRoute())->toBe('route.test');
    expect(Url::current())->toBe(route('route.test-b'));
    expect(Url::currentRoute())->toBe('route.test-b');
});

it('can store the user url in the session on a visit on a route without a route name', function () {
    Route::get('/test-without-name')->middleware(LivewireUrlsMiddleware::class);

    get('test-without-name');

    expect(Url::previous())->toBeNull();
    expect(Url::previousRoute())->toBeNull();
    expect(Url::current())->toEndWith('/test-without-name');
    expect(Url::currentRoute())->toBeNull();
});
