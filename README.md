![livewire-urls](https://github.com/ralphjsmit/livewire-urls/blob/main/docs/images/livewire-urls.jpg)

# Get the current and previous url in Livewire.

This package gives you a simple way to **retrieve the current and previous URL** in Livewire.

Unfortunately, Laravel or Livewire **cannot handle** this for you, since Livewire also makes requests to your server when a user interacts with your webpage. This means that the usual methods like `URL()->current()` **point to an internal Livewire** route, instead of the **"real route" your user is on**.

This package provides you with a middleware and **helper methods to determine which URL is currently being used**.

## Installation

You can install the package via composer:

```bash
composer require ralphjsmit/livewire-urls
```

Next, you should add `\RalphJSmit\Livewire\Urls\Middleware\LivewireUrlsMiddleware::class,` to your Http `Kernel.php`, in the `web` key of the `$middlewareGroups` property.

## Usage

### Current url

```php
use RalphJSmit\Livewire\Urls\Facades\Url;

$currentUrl = Url::current();
```

### Current route

```php
$currentRouteName = Url::currentRoute();
```

The `Url::currentRoute()` returns `null` when the user is on a route without a name.

### Previous url

```php
$previousUrl = Url::previous();
```

The `Url::previous()`-method returns `null` when there isn't a previous route available.

### Previous route

```php
$previousRouteName = Url::previousRoute();
```

The `Url::previousRoute()` returns `null` when there isn't a previous route or if the previous route wasn't a named route.

### Last recorded url

You can use the `Url::lastRecorded()` method to get the last url from the history that is _different_ from the current url.

For example:

1. User visits page A
2. User visits page B
3. User visits page B

The `Url::lastRecorded()` would give you the url of page A. The function returns `null` when there isn't an other url found, apart from the current session.

```php
$lastRecordedUrl = Url::lastRecorded();
```

### Last recorded route

You can use the `Url::lastRecordedRoute()` method to get the last route from the history that is _different_ from the current url/route.

```php
$lastRecordedRoute = Url::lastRecordedRoute();
```

The `Url::lastRecordedRoute()` would give you the route of page A from the previous example, **if page A is on a named route**. Otherwise, it would return `null`. The function also returns `null` when there isn't an other url found, apart from the current session.

## General

🐞 If you spot a bug, please submit a detailed issue and I'll try to fix it as soon as possible.

🔐 If you discover a vulnerability, please review [our security policy](../../security/policy).

🙌 If you want to contribute, please submit a pull request. All PRs will be fully credited. If you're unsure whether I'd accept your idea, feel free to contact me!

🙋‍♂️ [Ralph J. Smit](https://ralphjsmit.com)
