<?php

namespace App\Models;

use App\Base\Trait\HasRules;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, HasRules;

    /*
     * ---------------------------
     *          Constants
     * ---------------------------
     */
    const ID = 'id';
    const USER_ID = 'user_id';
    const PAYMENTABLE_ID = 'paymentable_id';
    const PAYMENTABLE_TYPE = 'paymentable_type';
    const REFERENCE_ID = 'reference_id';
    const TRANSACTION_ID = 'transaction_id';
    const GATEWAY = 'gateway';
    const METHOD = 'method';
    const STATUS = 'status';
    const AMOUNT = 'amount';
    const CURRENCY = 'currency';
    const EXCHANGE_RATE = 'exchange_rate';
    const FEE = 'fee';
    const TAX = 'tax';
    const DISCOUNT = 'discount';
    const NET_AMOUNT = 'net_amount';
    const DESCRIPTION = 'description';
    const TRANSACTION_RESULT = 'transaction_result';
    const PAID_AT = 'paid_at';
    const RECEIPT_ID = 'receipt_id';
    const INSTITUTE_ID = 'institute_id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::USER_ID,
        self::PAYMENTABLE_ID,
        self::PAYMENTABLE_TYPE,
        self::REFERENCE_ID,
        self::TRANSACTION_ID,
        self::GATEWAY,
        self::METHOD,
        self::STATUS,
        self::AMOUNT,
        self::CURRENCY,
        self::EXCHANGE_RATE,
        self::FEE,
        self::TAX,
        self::DISCOUNT,
        self::NET_AMOUNT,
        self::DESCRIPTION,
        self::TRANSACTION_RESULT,
        self::PAID_AT,
        self::RECEIPT_ID,
        self::INSTITUTE_ID,
    ];

    protected $casts = [
        self::ID => 'int',
        self::AMOUNT => 'decimal:2',
        self::EXCHANGE_RATE => 'decimal:4',
        self::FEE => 'decimal:2',
        self::TAX => 'decimal:2',
        self::DISCOUNT => 'decimal:2',
        self::NET_AMOUNT => 'decimal:2',
        self::PAID_AT => 'datetime',
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
    ];

    protected $attributes = [
        self::STATUS => 'pending',
        self::CURRENCY => 'USD',
        self::EXCHANGE_RATE => 1.0,
        self::FEE => 0,
        self::TAX => 0,
        self::DISCOUNT => 0,
    ];

    protected static array $rules = [
        'user_id' => 'required|exists:users,id',
        'paymentable_id' => 'nullable|integer',
        'paymentable_type' => 'nullable|string|max:255',
        'reference_id' => 'nullable|string|max:100',
        'transaction_id' => 'nullable|string|max:100|unique:payments,transaction_id',
        'gateway' => 'nullable|string|max:50',
        'method' => 'nullable|in:cash,card,bank_transfer,online,wallet,check,cryptocurrency',
        'status' => 'required|in:pending,processing,completed,failed,cancelled,refunded,partial_refund',
        'amount' => 'required|numeric|min:0|max:999999.99',
        'currency' => 'nullable|string|size:3',
        'exchange_rate' => 'nullable|numeric|min:0.0001|max:9999.9999',
        'fee' => 'nullable|numeric|min:0|max:9999.99',
        'tax' => 'nullable|numeric|min:0|max:9999.99',
        'discount' => 'nullable|numeric|min:0|max:9999.99',
        'net_amount' => 'nullable|numeric|min:0|max:999999.99',
        'description' => 'nullable|string|max:1000',
        'transaction_result' => 'nullable|string',
        'paid_at' => 'nullable|date',
        'receipt_id' => 'nullable|exists:receipts,id',
        'institute_id' => 'nullable|exists:institutes,id',
    ];

    /*
     * ---------------------------
     *          Relations
     * ---------------------------
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /*
     * ---------------------------
     *          Scopes
     * ---------------------------
     */
    public function scopeCompleted($query)
    {
        return $query->where(self::STATUS, 'completed');
    }

    public function scopePending($query)
    {
        return $query->where(self::STATUS, 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where(self::STATUS, 'failed');
    }

    public function scopeRefunded($query)
    {
        return $query->whereIn(self::STATUS, ['refunded', 'partial_refund']);
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where(self::METHOD, $method);
    }

    public function scopeByGateway($query, $gateway)
    {
        return $query->where(self::GATEWAY, $gateway);
    }

    public function scopeByInstitute($query, $instituteId)
    {
        return $query->where(self::INSTITUTE_ID, $instituteId);
    }

    public function scopeToday($query)
    {
        return $query->whereDate(self::CREATED_AT, today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth(self::CREATED_AT, now()->month)
                    ->whereYear(self::CREATED_AT, now()->year);
    }

    public function scopeThisYear($query)
    {
        return $query->whereYear(self::CREATED_AT, now()->year);
    }

    public function scopeAmountRange($query, $min, $max)
    {
        return $query->whereBetween(self::AMOUNT, [$min, $max]);
    }

    /*
     * ---------------------------
     *          Accessors
     * ---------------------------
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'معلق',
            'processing' => 'در حال پردازش',
            'completed' => 'پرداخت شد',
            'failed' => 'کنسل شد',
            'cancelled' => 'لغو شد',
            'refunded' => 'برگشت داده شد',
            'partial_refund' => 'برگشت جزئی',
            default => 'نامشخص',
        };
    }

    public function statusBadgeClasses(): string
    {
        return match ($this->status) {
            'completed' => 'bg-green-100 text-green-800 ring-green-600/20',
            'processing' => 'bg-blue-100 text-blue-800 ring-blue-600/20',
            'pending' => 'bg-yellow-100 text-yellow-800 ring-yellow-600/20',
            'failed', 'cancelled' => 'bg-red-100 text-red-800 ring-red-600/20',
            'refunded', 'partial_refund' => 'bg-purple-100 text-purple-800 ring-purple-600/20',
            default => 'bg-gray-100 text-gray-800 ring-gray-600/20',
        } . ' inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset';
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2) . ' ' . $this->currency;
    }

    public function getCalculatedNetAmountAttribute(): float
    {
        return round($this->amount + $this->fee + $this->tax - $this->discount, 2);
    }

    public function getIsSuccessfulAttribute(): bool
    {
        return $this->status === 'completed';
    }

    public function getIsPendingAttribute(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    public function getIsFailedAttribute(): bool
    {
        return in_array($this->status, ['failed', 'cancelled']);
    }

    public function getIsRefundedAttribute(): bool
    {
        return in_array($this->status, ['refunded', 'partial_refund']);
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'cash' => 'نقد',
            'card' => 'کارت',
            'bank_transfer' => 'انتقال بانکی',
            'online' => 'آنلاین',
            'wallet' => 'کیف پول',
            'check' => 'چک',
            'cryptocurrency' => 'ارز دیجیتال',
            default => 'نامشخص',
        };
    }

    /*
     * ---------------------------
     *          Mutators
     * ---------------------------
     */
    public function setAmountAttribute($value)
    {
        $this->attributes[self::AMOUNT] = $value;
        $this->attributes[self::NET_AMOUNT] = $this->calculated_net_amount;
    }

    public function setFeeAttribute($value)
    {
        $this->attributes[self::FEE] = $value;
        $this->attributes[self::NET_AMOUNT] = $this->calculated_net_amount;
    }

    public function setTaxAttribute($value)
    {
        $this->attributes[self::TAX] = $value;
        $this->attributes[self::NET_AMOUNT] = $this->calculated_net_amount;
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes[self::DISCOUNT] = $value;
        $this->attributes[self::NET_AMOUNT] = $this->calculated_net_amount;
    }

    /*
     * ---------------------------
     *          Methods
     * ---------------------------
     */
    public function markAsCompleted(): bool
    {
        $this->status = 'completed';
        $this->paid_at = now();
        return $this->save();
    }

    public function markAsFailed(): bool
    {
        $this->status = 'failed';
        return $this->save();
    }

    public function markAsRefunded(): bool
    {
        $this->status = 'refunded';
        return $this->save();
    }

    public function canBeRefunded(): bool
    {
        return $this->status === 'completed' && $this->paid_at && $this->paid_at->gt(now()->subDays(30));
    }

    public function generateReceipt(): Receipt
    {
        if ($this->receipt) {
            return $this->receipt;
        }

        $receipt = Receipt::create([
            'payment_id' => $this->id,
            'user_id' => $this->user_id,
            'institute_id' => $this->institute_id,
            'receipt_number' => Receipt::generateReceiptNumber(),
            'amount' => $this->amount,
            'currency' => $this->currency,
            'description' => $this->description,
            'issued_at' => now(),
        ]);

        $this->update(['receipt_id' => $receipt->id]);

        return $receipt;
    }
}
