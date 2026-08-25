<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Refund staging DTO.
 *
 * Represents a refund from Square, PayPal, Stripe, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingRefund extends StagingTransaction
{
    /** @var string Transaction source ID (original payment xref) */
    protected $transactionSourceId = '';

    /** @var string Refund reason */
    protected $reason = '';

    /**
     * @param string $source              External module identifier
     * @param string $sourceId            Unique ID from external system
     * @param float  $amount              Refund amount
     * @param string $currency            Currency code
     * @param string $status              Refund status
     * @param string $paymentMethod       Payment method
     * @param string $transactionSourceId Original payment xref
     * @param string $reason              Refund reason
     * @param string $createdAt           ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        float $amount,
        string $currency,
        string $status,
        string $paymentMethod,
        string $transactionSourceId = '',
        string $reason = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $amount, $currency, $status, $paymentMethod, $createdAt);
        $this->version = '1.0.0';
        $this->transactionSourceId = $transactionSourceId;
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getTransactionSourceId(): string
    {
        return $this->transactionSourceId;
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'transactionSourceId' => $this->transactionSourceId,
            'reason' => $this->reason,
        ]);
    }
}
