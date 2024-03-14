<?php

use Illuminate\Support\Facades\Route;
use RalphJSmit\Livewire\Urls\Facades\Url;
use RalphJSmit\Livewire\Urls\Middleware\LivewireUrlsMiddleware;
use RalphJSmit\Livewire\Urls\Tests\Fixtures\TestComponent;

use function Pest\Laravel\delete;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;
use function Pest\Laravel\put;

it('can store the user url in the session on a visit', function () {
    Route::get('test', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.test');
    Route::get('test-b', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.test-b');

    expect(session()->get('livewire-urls'))->toBeNull();

    get('test');

    expect(Url::previous())->toBeNull();
    expect(Url::previousRoute())->toBeNull();
    expect(Url::current())->toBe(route('route.test'));
    expect(Url::currentRoute())->toBe('route.test');
    expect(Url::lastRecorded())->toBeNull();
    expect(Url::lastRecordedRoute())->toBeNull();

    get('test-b');

    expect(Url::previous())->toBe(route('route.test'));
    expect(Url::previousRoute())->toBe('route.test');
    expect(Url::current())->toBe(route('route.test-b'));
    expect(Url::currentRoute())->toBe('route.test-b');
    expect(Url::lastRecorded())->toBe(route('route.test'));
    expect(Url::lastRecordedRoute())->toBe('route.test');

	$route = match(true)  {
		Route::has('livewire.update') => 'livewire.update',
		Route::has('livewire.message') => 'livewire.message',
	};
	
    post(route($route, ['name' => TestComponent::class]));

    expect(Url::previous())->toBe(route('route.test'));
    expect(Url::previousRoute())->toBe('route.test');
    expect(Url::current())->toBe(route('route.test-b'));
    expect(Url::currentRoute())->toBe('route.test-b');
    expect(Url::lastRecorded())->toBe(route('route.test'));
    expect(Url::lastRecordedRoute())->toBe('route.test');

    get('test-b');

    expect(Url::previous())->toBe(route('route.test-b'));
    expect(Url::previousRoute())->toBe('route.test-b');
    expect(Url::current())->toBe(route('route.test-b'));
    expect(Url::currentRoute())->toBe('route.test-b');
    expect(Url::lastRecorded())->toBe(route('route.test'));
    expect(Url::lastRecordedRoute())->toBe('route.test');
});

it('can store the user url in the session on a visit on a route without a route name', function () {
    Route::get('/test-without-name', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class);

    get('test-without-name');

    expect(Url::previous())->toBeNull();
    expect(Url::previousRoute())->toBeNull();
    expect(Url::current())->toEndWith('/test-without-name');
    expect(Url::currentRoute())->toBeNull();
});

it('can store the user url in the session on a visit on a mix of named and unnamed routes', function () {
    Route::get('/test-without-name', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class);
    Route::get('test', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.test');

    get('test-without-name');
    get('test');

    expect(Url::previous())->toEndWith('/test-without-name');
    expect(Url::previousRoute())->toBeNull();
    expect(Url::current())->toBe(route('route.test'));
    expect(Url::currentRoute())->toBe('route.test');
    expect(Url::lastRecorded())->toEndWith('/test-without-name');
    expect(Url::lastRecordedRoute())->toBeNull();
});

it('can use the fallbacks', function () {
    expect(Url::current())->toBeNull();
    expect(Url::currentRoute())->toBeNull();
    expect(Url::previous())->toBeNull();
    expect(Url::previousRoute())->toBeNull();
    expect(Url::lastRecorded())->toBeNull();
    expect(Url::lastRecordedRoute())->toBeNull();

    expect(Url::previous('https://rjs.test/example'))->toBe('https://rjs.test/example');
    expect(Url::previousRoute('web.example'))->toBe('web.example');
    expect(Url::current('https://rjs.test/example'))->toBe('https://rjs.test/example');
    expect(Url::currentRoute('web.example'))->toBe('web.example');
    expect(Url::lastRecorded('https://rjs.test/example'))->toBe('https://rjs.test/example');
    expect(Url::lastRecordedRoute('web.example'))->toBe('web.example');
});

it('will exclude all request types apart from GET', function () {
    Route::get('get', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.get');
    Route::post('post', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.post');
    Route::put('put', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.put');
    Route::patch('patch', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.patch');
    Route::delete('delete', fn () => 'ok')->middleware(LivewireUrlsMiddleware::class)->name('route.delete');

    get('get');
    post('post');
    put('put');
    patch('patch');
    delete('delete');

    expect(Url::previous())->toBeNull();
    expect(Url::previousRoute())->toBeNull();
    expect(Url::current())->toBe(route('route.get'));
    expect(Url::currentRoute())->toBe('route.get');
    expect(Url::lastRecorded())->toBeNull();
    expect(Url::lastRecordedRoute())->toBeNull();
});
