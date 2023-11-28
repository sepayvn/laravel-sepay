# Laravel Package cho SePay - Giải pháp tự động hóa cho thanh toán chuyển khoản ngân hàng

## Installation

You can install the package via composer:

```bash
composer require sepayvn/laravel-sepay
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="sepay-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="sepay-config"
```

This is the contents of the published config file:

```php
return [
    'webhook_token' => env('SEPAY_WEBHOOK_TOKEN'),
    'pattern' => env('SEPAY_MATCH_PATTERN', 'SE'),
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="sepay-views"
```

## Usage

Tạo SePayWebhookListener

```bash
php artisan make:listener SePayWebhookListener
```

```php
<?php

namespace App\Listeners;

use SePay\SePay\Events\SePayWebhookEvent;

class SePayWebhookListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SePayWebhookEvent $event): void
    {
        // Xử lý nạp tiền / rút tiền
    }
}

```

Đăng ký SePayWebhookListener vào app/Providers/EventServiceProvider.php

```php
    protected $listen = [
        ...
        \SePay\SePay\Events\SePayWebhookEvent::class => [
            \App\Listeners\SePayWebhookListener::class,
        ],
    ];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [SePay](https://github.com/sepayvn)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
