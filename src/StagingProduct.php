<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Product staging DTO.
 *
 * Represents a product from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingProduct extends StagingEntity
{
    /** @var string Product SKU */
    protected $sku = '';

    /** @var string Product name */
    protected $name = '';

    /** @var string Product description */
    protected $description = '';

    /** @var float Product price */
    protected $price = 0.0;

    /** @var float Product weight */
    protected $weight = 0.0;

    /** @var array Categories */
    protected $categories = [];

    /** @var array Images */
    protected $images = [];

    /**
     * @param string $source      External module identifier
     * @param string $sourceId    Unique ID from external system
     * @param string $sku         Product SKU
     * @param string $name        Product name
     * @param string $description Product description
     * @param float  $price       Product price
     * @param float  $weight      Product weight
     * @param array  $categories  Categories
     * @param array  $images      Images
     * @param string $createdAt   ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $sku = '',
        string $name = '',
        string $description = '',
        float $price = 0.0,
        float $weight = 0.0,
        array $categories = [],
        array $images = [],
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->weight = $weight;
        $this->categories = $categories;
        $this->images = $images;
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
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'weight' => $this->weight,
            'categories' => $this->categories,
            'images' => $this->images,
        ]);
    }
}
