
<?php

namespace SePay\SePay\Datas;

class SePayWebhookData
{
    /** Ex: 228478 */
    public number $id;
    /** Ex: 'MBBank' */
    public string $gateway;
    /** Ex: '2023-11-28 14:18:18' */
    public string $transactionDate;
    /** Ex: '0359123123' */
    public string $accountNumber;
    /** Ex: NULL */
    public any $subAccount;
    /** Ex: NULL */
    public ?mixed $code;
    /** Ex: 'SEPAY123123' */
    public string $content;
    /** Ex: 'in' */
    public string $transferType;
    /** Ex: NULL */
    public ?mixed $description;
    /** Ex: 50000 */
    public number $transferAmount;
    /** Ex: NULL */
    public ?mixed $referenceCode;
    /** Ex: 356489 */
    public number $accumulated;
}
