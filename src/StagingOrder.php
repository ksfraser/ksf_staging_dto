<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Order staging DTO.
 *
 * Represents an order from WooCommerce, Square, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingOrder extends StagingTransaction
{
    /** @var array Line items */
    protected $lineItems = [];

    /** @var string Customer source ID */
    protected $customerSourceId = '';

    /** @var array Billing address */
    protected $billingAddress = [];

    /** @var array Shipping address */
    protected $shippingAddress = [];

    /**
     * @param string $source           External module identifier
     * @param string $sourceId         Unique ID from external system
     * @param float  $amount           Order total
     * @param string $currency         Currency code
     * @param string $status           Order status
     * @param string $paymentMethod    Payment method
     * @param array  $lineItems        Line items
     * @param string $customerSourceId Customer source ID
     * @param array  $billingAddress   Billing address
     * @param array  $shippingAddress  Shipping address
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
        array $billingAddress = [],
        array $shippingAddress = [],
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $amount, $currency, $status, $paymentMethod, $createdAt);
        $this->version = '1.0.0';
        $this->lineItems = $lineItems;
        $this->customerSourceId = $customerSourceId;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
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
     * @return array
     */
    public function getBillingAddress(): array
    {
        return $this->billingAddress;
    }

    /**
     * @return array
     */
    public function getShippingAddress(): array
    {
        return $this->shippingAddress;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'lineItems' => $this->lineItems,
            'customerSourceId' => $this->customerSourceId,
            'billingAddress' => $this->billingAddress,
            'shippingAddress' => $this->shippingAddress,
        ]);
    }
}
