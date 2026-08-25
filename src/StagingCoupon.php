<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Coupon staging DTO.
 *
 * Represents a coupon from WooCommerce, Square, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingCoupon extends StagingEntity
{
    /** @var string Coupon code */
    protected $code = '';

    /** @var string Coupon type (e.g., 'percentage', 'fixed_cart') */
    protected $type = 'percentage';

    /** @var float Coupon amount */
    protected $amount = 0.0;

    /** @var int Usage limit (0 = unlimited) */
    protected $usageLimit = 0;

    /** @var string Expiry date (ISO 8601) */
    protected $expiryDate = '';

    /**
     * @param string $source      External module identifier
     * @param string $sourceId    Unique ID from external system
     * @param string $code        Coupon code
     * @param string $type        Coupon type
     * @param float  $amount      Coupon amount
     * @param int    $usageLimit  Usage limit
     * @param string $expiryDate  Expiry date
     * @param string $createdAt   ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $code = '',
        string $type = 'percentage',
        float $amount = 0.0,
        int $usageLimit = 0,
        string $expiryDate = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->code = $code;
        $this->type = $type;
        $this->amount = $amount;
        $this->usageLimit = $usageLimit;
        $this->expiryDate = $expiryDate;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getUsageLimit(): int
    {
        return $this->usageLimit;
    }

    /**
     * @return string
     */
    public function getExpiryDate(): string
    {
        return $this->expiryDate;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'code' => $this->code,
            'type' => $this->type,
            'amount' => $this->amount,
            'usageLimit' => $this->usageLimit,
            'expiryDate' => $this->expiryDate,
        ]);
    }
}
