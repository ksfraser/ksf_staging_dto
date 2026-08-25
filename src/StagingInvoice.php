<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Invoice staging DTO.
 *
 * Represents an invoice from Square, PayPal, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingInvoice extends StagingTransaction
{
    /** @var array Line items */
    protected $lineItems = [];

    /** @var string Customer source ID */
    protected $customerSourceId = '';

    /** @var string Due date (ISO 8601) */
    protected $dueDate = '';

    /**
     * @param string $source           External module identifier
     * @param string $sourceId         Unique ID from external system
     * @param float  $amount           Invoice total
     * @param string $currency         Currency code
     * @param string $status           Invoice status
     * @param string $paymentMethod    Payment method
     * @param array  $lineItems        Line items
     * @param string $customerSourceId Customer source ID
     * @param string $dueDate          Due date
     * @param string $createdAt        ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        float $amount,
        string $currency,
        string $status,
        string $paymentMethod,
        array $lineItems = [],
        string $customerSourceId = '',
        string $dueDate = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $amount, $currency, $status, $paymentMethod, $createdAt);
        $this->version = '1.0.0';
        $this->lineItems = $lineItems;
        $this->customerSourceId = $customerSourceId;
        $this->dueDate = $dueDate;
    }

    /**
     * @return array
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @return string
     */
    public function getCustomerSourceId(): string
    {
        return $this->customerSourceId;
    }

    /**
     * @return string
     */
    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'lineItems' => $this->lineItems,
            'customerSourceId' => $this->customerSourceId,
            'dueDate' => $this->dueDate,
        ]);
    }
}
