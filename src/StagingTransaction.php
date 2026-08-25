<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Abstract base class for financial transaction DTOs.
 *
 * Extends StagingEntity with amount, currency, status, paymentMethod.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
abstract class StagingTransaction extends StagingEntity
{
    /** @var float Transaction amount */
    protected $amount;

    /** @var string Currency code (e.g., 'USD') */
    protected $currency;

    /** @var string Transaction status (e.g., 'pending', 'completed', 'failed') */
    protected $status;

    /** @var string Payment method (e.g., 'card', 'cash', 'bank_transfer') */
    protected $paymentMethod;

    /**
     * @param string $source        External module identifier
     * @param string $sourceId      Unique ID from external system
     * @param float  $amount        Transaction amount
     * @param string $currency      Currency code
     * @param string $status        Transaction status
     * @param string $paymentMethod Payment method
     * @param string $createdAt     ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        float $amount,
        string $currency,
        string $status,
        string $paymentMethod,
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->amount = $amount;
        $this->currency = $currency;
        $this->status = $status;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,
            'paymentMethod' => $this->paymentMethod,
        ]);
    }
}
