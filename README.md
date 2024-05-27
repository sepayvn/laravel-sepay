# Laravel Package cho SePay - Giải pháp tự động hóa cho thanh toán chuyển khoản ngân hàng

## Installation

You can install the package via composer:

```bash
composer require sepayvn/laravel-sepay
```

Phiên bản dành cho Laravel 7, 8 và PHP 8.0 trở lên

```bash
composer require "sepayvn/laravel-sepay:dev-lite"
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

use App\Models\User;
use SePay\SePay\Events\SePayWebhookEvent;
use SePay\SePay\Notifications\SePayTopUpSuccessNotification;

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
        // Xử lý tiền vào tài khoản
        if ($event->sePayWebhookData->transferType === 'in') {
            // Trường hợp $info là user id
            $user = User::query()->where('id', $event->info)->first();
            if ($user instanceof User) {
                $user->notify(new SePayTopUpSuccessNotification($event->sePayWebhookData));
            }
        } else {
            // Xử lý tiền ra tài khoản
        }
    }
}
```

-   Đối với Laravel 10 trở xuống

    Đăng ký SePayWebhookListener vào app/Providers/EventServiceProvider.php

    ```php
        protected $listen = [
            ...
            \SePay\SePay\Events\SePayWebhookEvent::class => [
                \App\Listeners\SePayWebhookListener::class,
            ],
        ];
    ```

-   Đối với Laravel 11, `SePayWebhookListener` đặt ở trong thư mục app/Listeners thì Laravel
    sẽ tự động gắn với `SePayWebhookEvent` bạn không cần phải đăng ký với Provider, tránh bị gọi 2 lần.

    Nếu bạn kiểm tra thấy `SePayWebhookListener` chưa lắng nghe `SePayWebhookEvent` thì bạn có thể làm như sau:
    vào phương thức `boot` trong `app/Providers/AppServiceProvider.php`

    ```php
    public function boot(): void
    {
        \Illuminate\Support\Facades\Event::listen(
            \SePay\SePay\Events\SePayWebhookEvent::class,
            \App\Listeners\SePayWebhookListener::class,
        );
    }
    ```

## Webhook

1. Truy cập [SePay Webhooks](https://my.sepay.vn/webhooks)
2. Bấm nút `Thêm Webhook` ở góc trên bên phải
3. Các cần điền thì bạn hãy điền, riêng các mục sau cần lưu ý

    ![](<images/Screenshot 2024-05-27 at 18.50.00.png>)

    1. thay `domain.com` thành tên miền của bạn
    2. Kiểu chứng thực: là Api Key
    3. API Key: nhập vào 1 dãy bí mật ngẫu nhiên gồm chữ và số (không có dấu như hình ví dụ nhé)

4. Sửa file `.env` trong ứng dụng Laravel của bạn thành như sau

    ![](<images/Screenshot 2024-05-27 at 19.33.19.png>)

    1. `SEPAY_WEBHOOK_TOKEN` - Là API Key nhập ở bước 3.3 ở trên
    2. `SEPAY_MATCH_PATTERN` - Mặc định là `SE` bạn có thể sửa cho phù hợp với ứng dụng của bạn

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
