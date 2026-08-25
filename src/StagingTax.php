<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Tax staging DTO.
 *
 * Represents a tax from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingTax extends StagingEntity
{
    /** @var string Tax name */
    protected $name = '';

    /** @var float Tax rate (e.g., 0.08 for 8%) */
    protected $rate = 0.0;

    /** @var string Tax type (e.g., 'percentage', 'fixed') */
    protected $type = 'percentage';

    /**
     * @param string $source    External module identifier
     * @param string $sourceId  Unique ID from external system
     * @param string $name      Tax name
     * @param float  $rate      Tax rate
     * @param string $type      Tax type
     * @param string $createdAt ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $name = '',
        float $rate = 0.0,
        string $type = 'percentage',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->name = $name;
        $this->rate = $rate;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'name' => $this->name,
            'rate' => $this->rate,
            'type' => $this->type,
        ]);
    }
}
