# Laravel Package cho SePay - Giải pháp tự động hóa cho thanh toán chuyển khoản ngân hàng

## Đăng ký tài khoản

[Đăng ký tài khoản](https://sepay.vn?utm_source=INV&utm_medium=RFTRA&utm_campaign=D813AE64) tại SePay!

## Cài đặt

Bạn có thể cài đặt package qua composer:

```bash
composer require sepayvn/laravel-sepay
```

Phiên bản dành cho Laravel 7, 8 và PHP 7.4 trở lên

```bash
composer require "sepayvn/laravel-sepay:dev-lite"
```

Publish và chạy migrations:

```bash
php artisan vendor:publish --tag="sepay-migrations"
php artisan migrate
```

Publish file config:

```bash
php artisan vendor:publish --tag="sepay-config"
```

Nội dung của file config sau khi publish:

```php
return [
    'webhook_token' => env('SEPAY_WEBHOOK_TOKEN'),
    'pattern' => env('SEPAY_MATCH_PATTERN', 'SE'),
];
```

Tùy chọn, bạn có thể publish views:

```bash
php artisan vendor:publish --tag="sepay-views"
```

## Sử dụng

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

-   Đối với Laravel 11 trở xuống (7, 8, 9, 10)

    Đăng ký SePayWebhookListener vào app/Providers/EventServiceProvider.php

    ```php
        protected $listen = [
            ...
            \SePay\SePay\Events\SePayWebhookEvent::class => [
                \App\Listeners\SePayWebhookListener::class,
            ],
        ];
    ```

-   Đối với phiên bản Laravel 11 trở lên, `SePayWebhookListener` đặt ở trong thư mục app/Listeners thì Laravel
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
3. Các mục cần điền thì bạn hãy điền, riêng các mục sau cần lưu ý

    ![](<images/Screenshot 2024-05-27 at 18.50.00.png>)

    1. thay `domain.com` thành tên miền của bạn
    2. Kiểu chứng thực: là Api Key
    3. API Key: nhập vào 1 dãy bí mật ngẫu nhiên gồm chữ và số (không có dấu như hình ví dụ nhé)

4. Sửa file `.env` trong ứng dụng Laravel của bạn thành như sau

    ![](<images/Screenshot 2024-05-27 at 19.33.19.png>)

    1. `SEPAY_WEBHOOK_TOKEN` - Là API Key nhập ở bước 3.3 ở trên
    2. `SEPAY_MATCH_PATTERN` - Mặc định là `SE` bạn có thể sửa cho phù hợp với ứng dụng của bạn

## Kiểm tra với Postman

Bấm import trên postman và dán đoạn mã dưới đây vào

```bash
curl --location 'https://domain.com/api/sepay/webhook' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer Apikey đây_là_khóa_bí_mật' \
--data '{
    "gateway": "MBBank",
    "transactionDate": "2024-05-25 21:11:02",
    "accountNumber": "0359123456",
    "subAccount": null,
    "code": null,
    "content": "Thanh toan QR SE123456",
    "transferType": "out",
    "description": "Thanh toan QR SE123456",
    "transferAmount": 1700000,
    "referenceCode": "FT123456789",
    "accumulated": 0,
    "id": 123456
}'
```

## Kiểm thử

```bash
composer test
```

## Ủng hộ nhà phát triển

Bạn có thể hỗ trợ nhà phát triển gói này bằng cách sử dụng những dịch vụ sau:

-   Thuê tôi 👉 [Facebook](https://www.facebook.com/nguyentranchung.b3) | [Telegram](https://t.me/nguyentranchung)
-   [FlashPanel: Effortless Server Management](https://flashpanel.io)
-   [FcodeShare: Get link Fshare tiết kiệm](https://fcodeshare.com)

## Lịch sử thay đổi

Vui lòng xem [CHANGELOG](CHANGELOG.md) để biết thêm thông tin về các thay đổi gần đây.

## Đóng góp

Vui lòng xem [CONTRIBUTING](CONTRIBUTING.md) để biết chi tiết.

## Bảo mật

Vui lòng xem [chính sách bảo mật](../../security/policy) để biết cách báo cáo lỗ hổng bảo mật.

## Tác giả

-   [SePay](https://github.com/sepayvn)
-   [Tất cả những người đóng góp](../../contributors)

## Giấy phép

Giấy phép MIT. Vui lòng xem [License File](LICENSE.md) để biết thêm thông tin.
