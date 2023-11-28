# Laravel Package cho SePay - Giải pháp tự động hóa cho thanh toán chuyển khoản ngân hàng

## Installation

You can install the package via composer:

```bash
composer require sepayvn/laravel-sepay
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-sepay-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-sepay-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-sepay-views"
```

## Usage

```php
$sePay = new SePay\SePay();
echo $sePay->echoPhrase('Hello, SePay!');
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

- [SePay](https://github.com/sepayvn)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
