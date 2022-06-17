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

Next, you should add the `LivewireUrlsMiddleware` to your Http `Kernel.php`. You should add it to the `web` key of the `$middlewareGroups` property.

## Usage

### Getting the current url

```php
use RalphJSmit\Livewire\Urls\Facades\Url;

$currentUrl = Url::current();
```

### Getting the current route

```php
$currentRouteName = Url::currentRoute();
```

The `Url::currentRoute()` returns `null` when the user is on a route without a name.

### Getting the previous url

```php
$previousUrl = Url::previous();
```

The `Url::previous()`-method returns `null` when there isn't a previous route available.

### Getting the previous route

```php
$previousRouteName = Url::previousRoute();
```

The `Url::previousRoute()` returns `null` when there isn't a previous route or if the previous route wasn't a named route.

## General

🐞 If you spot a bug, please submit a detailed issue and I'll try to fix it as soon as possible.

🔐 If you discover a vulnerability, please review [our security policy](../../security/policy).

🙌 If you want to contribute, please submit a pull request. All PRs will be fully credited. If you're unsure whether I'd accept your idea, feel free to contact me!

🙋‍♂️ [Ralph J. Smit](https://ralphjsmit.com)
