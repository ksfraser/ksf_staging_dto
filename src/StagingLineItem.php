<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Line item staging DTO.
 *
 * Standalone DTO (not extending StagingEntity).
 * Represents a line item from orders, invoices, etc.
 * Has transactionSourceId for xref to parent order/invoice.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingLineItem
{
    /** @var string Source module */
    protected $source = '';

    /** @var string Source ID */
    protected $sourceId = '';

    /** @var string Transaction source ID (parent order/invoice xref) */
    protected $transactionSourceId = '';

    /** @var string Item SKU */
    protected $sku = '';

    /** @var string Item name/description */
    protected $name = '';

    /** @var string Item description */
    protected $description = '';

    /** @var int Quantity */
    protected $quantity = 1;

    /** @var float Unit price */
    protected $unitPrice = 0.0;

    /** @var float Discount amount */
    protected $discount = 0.0;

    /** @var float Tax amount */
    protected $tax = 0.0;

    /** @var string Line item version */
    protected $version = '1.0.0';

    /**
     * @param string $source              Source module
     * @param string $sourceId            Source ID
     * @param string $transactionSourceId Parent order/invoice xref
     * @param string $sku                 Item SKU
     * @param string $name                Item name
     * @param string $description         Item description
     * @param int    $quantity            Quantity
     * @param float  $unitPrice           Unit price
     * @param float  $discount            Discount
     * @param float  $tax                 Tax
     */
    public function __construct(
        string $source = '',
        string $sourceId = '',
        string $transactionSourceId = '',
        string $sku = '',
        string $name = '',
        string $description = '',
        int $quantity = 1,
        float $unitPrice = 0.0,
        float $discount = 0.0,
        float $tax = 0.0
    ) {
        $this->source = $source;
        $this->sourceId = $sourceId;
        $this->transactionSourceId = $transactionSourceId;
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->discount = $discount;
        $this->tax = $tax;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getSourceId(): string
    {
        return $this->sourceId;
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
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    /**
     * @return float
     */
    public function getDiscount(): float
    {
        return $this->discount;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'sourceId' => $this->sourceId,
            'transactionSourceId' => $this->transactionSourceId,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unitPrice,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'version' => $this->version,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
