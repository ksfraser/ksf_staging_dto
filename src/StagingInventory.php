<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Inventory staging DTO.
 *
 * Represents an inventory update from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingInventory extends StagingEntity
{
    /** @var string Product SKU */
    protected $sku = '';

    /** @var int Quantity */
    protected $quantity = 0;

    /** @var string Warehouse location */
    protected $warehouse = '';

    /** @var string Reason for adjustment */
    protected $reason = '';

    /**
     * @param string $source    External module identifier
     * @param string $sourceId  Unique ID from external system
     * @param string $sku       Product SKU
     * @param int    $quantity  Quantity
     * @param string $warehouse Warehouse location
     * @param string $reason    Reason
     * @param string $createdAt ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $sku = '',
        int $quantity = 0,
        string $warehouse = '',
        string $reason = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->sku = $sku;
        $this->quantity = $quantity;
        $this->warehouse = $warehouse;
        $this->reason = $reason;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getWarehouse(): string
    {
        return $this->warehouse;
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
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'warehouse' => $this->warehouse,
            'reason' => $this->reason,
        ]);
    }
}
