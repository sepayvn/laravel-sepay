<?php

namespace SePay\SePay\Datas;

class SePayWebhookData
{
    /** ID giao dịch trên SePay: 228478 */
    public int $id;

    /** Brand name của ngân hàng: 'MBBank' */
    public string $gateway;

    /** Thời gian xảy ra giao dịch phía ngân hàng: '2023-11-28 14:18:18' */
    public string $transactionDate;

    /** Số tài khoản ngân hàng: '0359123123' */
    public string $accountNumber;

    /** Tài khoản ngân hàng phụ (tài khoản định danh) */
    public string $subAccount;

    /** Mã code thanh toán (sepay tự nhận diện dựa vào cấu hình tại Công ty -> Cấu hình chung) */
    public string $code;

    /** Nội dung chuyển khoản: 'SEPAY123123' */
    public string $content;

    /** Loại giao dịch. in là tiền vào, out là tiền ra: 'in' */
    public string $transferType;

    /** Toàn bộ nội dung tin nhắn sms */
    public string $description;

    /** Số tiền giao dịch: 50000 */
    public int $transferAmount;

    public string $referenceCode;

    /** Số dư tài khoản (lũy kế): 356489 */
    public int $accumulated;

    public function __construct(
        int $id,
        string $gateway,
        string $transactionDate,
        string $accountNumber,
        string $subAccount,
        string $code,
        string $content,
        string $transferType,
        string $description,
        int $transferAmount,
        string $referenceCode,
        int $accumulated
    ) {
        $this->id = $id;
        $this->gateway = $gateway;
        $this->transactionDate = $transactionDate;
        $this->accountNumber = $accountNumber;
        $this->subAccount = $subAccount;
        $this->code = $code;
        $this->content = $content;
        $this->transferType = $transferType;
        $this->description = $description;
        $this->transferAmount = $transferAmount;
        $this->referenceCode = $referenceCode;
        $this->accumulated = $accumulated;
    }
}
