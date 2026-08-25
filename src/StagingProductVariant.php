<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Product variant staging DTO.
 *
 * Represents a product variant from Square CSV items, WooCommerce, etc.
 * Used for catalog import (not order line items).
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingProductVariant extends StagingEntity
{
    /** @var string Parent product source ID */
    protected $productSourceId = '';

    /** @var string Variant SKU */
    protected $sku = '';

    /** @var array Variant attributes (e.g., color, size) */
    protected $attributes = [];

    /** @var float Variant price */
    protected $price = 0.0;

    /** @var int Variant stock quantity */
    protected $stock = 0;

    /**
     * @param string $source          External module identifier
     * @param string $sourceId        Unique ID from external system
     * @param string $productSourceId Parent product source ID
     * @param string $sku             Variant SKU
     * @param array  $attributes      Variant attributes
     * @param float  $price           Variant price
     * @param int    $stock           Stock quantity
     * @param string $createdAt       ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $productSourceId = '',
        string $sku = '',
        array $attributes = [],
        float $price = 0.0,
        int $stock = 0,
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->productSourceId = $productSourceId;
        $this->sku = $sku;
        $this->attributes = $attributes;
        $this->price = $price;
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getProductSourceId(): string
    {
        return $this->productSourceId;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'productSourceId' => $this->productSourceId,
            'sku' => $this->sku,
            'attributes' => $this->attributes,
            'price' => $this->price,
            'stock' => $this->stock,
        ]);
    }
}
