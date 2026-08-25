<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Payment staging DTO.
 *
 * Represents a payment from Square, PayPal, Stripe, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingPayment extends StagingTransaction
{
    /** @var string Transaction source ID (order/invoice xref) */
    protected $transactionSourceId = '';

    /** @var string Invoice source ID */
    protected $invoiceSourceId = '';

    /**
     * @param string $source              External module identifier
     * @param string $sourceId            Unique ID from external system
     * @param float  $amount              Payment amount
     * @param string $currency            Currency code
     * @param string $status              Payment status
     * @param string $paymentMethod       Payment method
     * @param string $transactionSourceId Transaction xref
     * @param string $invoiceSourceId     Invoice xref
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
        string $invoiceSourceId = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $amount, $currency, $status, $paymentMethod, $createdAt);
        $this->version = '1.0.0';
        $this->transactionSourceId = $transactionSourceId;
        $this->invoiceSourceId = $invoiceSourceId;
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
    public function getInvoiceSourceId(): string
    {
        return $this->invoiceSourceId;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'transactionSourceId' => $this->transactionSourceId,
            'invoiceSourceId' => $this->invoiceSourceId,
        ]);
    }
}
