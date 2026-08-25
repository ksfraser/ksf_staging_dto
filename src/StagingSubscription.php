<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Subscription staging DTO.
 *
 * Represents a recurring subscription from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingSubscription extends StagingTransaction
{
    /** @var string Frequency (e.g., 'monthly', 'weekly', 'yearly') */
    protected $frequency = '';

    /** @var string Next billing date (ISO 8601) */
    protected $nextBillingDate = '';

    /** @var array Line items */
    protected $lineItems = [];

    /**
     * @param string $source          External module identifier
     * @param string $sourceId        Unique ID from external system
     * @param float  $amount          Subscription amount
     * @param string $currency        Currency code
     * @param string $status          Subscription status
     * @param string $paymentMethod   Payment method
     * @param string $frequency       Billing frequency
     * @param string $nextBillingDate Next billing date
     * @param array  $lineItems       Line items
     * @param string $createdAt       ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        float $amount,
        string $currency,
        string $status,
        string $paymentMethod,
        string $frequency = '',
        string $nextBillingDate = '',
        array $lineItems = [],
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $amount, $currency, $status, $paymentMethod, $createdAt);
        $this->version = '1.0.0';
        $this->frequency = $frequency;
        $this->nextBillingDate = $nextBillingDate;
        $this->lineItems = $lineItems;
    }

    /**
     * @return string
     */
    public function getFrequency(): string
    {
        return $this->frequency;
    }

    /**
     * @return string
     */
    public function getNextBillingDate(): string
    {
        return $this->nextBillingDate;
    }

    /**
     * @return array
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'frequency' => $this->frequency,
            'nextBillingDate' => $this->nextBillingDate,
            'lineItems' => $this->lineItems,
        ]);
    }
}
