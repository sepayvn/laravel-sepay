
<?php

namespace SePay\SePay\Datas;

class SePayWebhookData
{
    /** ID giao dịch trên SePay: 228478 */
    public number $id;
    /** Brand name của ngân hàng: 'MBBank' */
    public string $gateway;
    /** Thời gian xảy ra giao dịch phía ngân hàng: '2023-11-28 14:18:18' */
    public string $transactionDate;
    /** Số tài khoản ngân hàng: '0359123123' */
    public string $accountNumber;
    /** Tài khoản ngân hàng phụ (tài khoản định danh): NULL */
    public any $subAccount;
    /** Mã code thanh toán (sepay tự nhận diện dựa vào cấu hình tại Công ty -> Cấu hình chung): NULL */
    public ?string $code = null;
    /** Nội dung chuyển khoản: 'SEPAY123123' */
    public string $content;
    /** Loại giao dịch. in là tiền vào, out là tiền ra: 'in' */
    public string $transferType;
    /** Toàn bộ nội dung tin nhắn sms */
    public ?string $description = null;
    /** Số tiền giao dịch: 50000 */
    public number $transferAmount;
    /** Ex: NULL */
    public ?string $referenceCode = null;
    /** Số dư tài khoản (lũy kế): 356489 */
    public number $accumulated;
}
