<?php

namespace SePay\SePay\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * SePay\SePay\Models\SePayTransaction
 *
 * @property int $id
 * @property string $gateway
 * @property string $transactionDate
 * @property string $accountNumber
 * @property string|null $subAccount
 * @property string|null $code
 * @property string $content
 * @property string $transferType
 * @property string|null $description
 * @property int $transferAmount
 * @property string|null $referenceCode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SePayTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SePayTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SePayTransaction query()
 *
 * @mixin \Eloquent
 */
class SePayTransaction extends Model
{
    use HasFactory;

    protected $table = 'sepay_transactions';
}
