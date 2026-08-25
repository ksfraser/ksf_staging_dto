<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Discount staging DTO.
 *
 * Represents a discount from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingDiscount extends StagingEntity
{
    /** @var string Discount name */
    protected $name = '';

    /** @var string Discount type (e.g., 'percentage', 'fixed') */
    protected $type = 'percentage';

    /** @var float Discount amount */
    protected $amount = 0.0;

    /** @var string Discount code */
    protected $code = '';

    /**
     * @param string $source    External module identifier
     * @param string $sourceId  Unique ID from external system
     * @param string $name      Discount name
     * @param string $type      Discount type
     * @param float  $amount    Discount amount
     * @param string $code      Discount code
     * @param string $createdAt ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $name = '',
        string $type = 'percentage',
        float $amount = 0.0,
        string $code = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->name = $name;
        $this->type = $type;
        $this->amount = $amount;
        $this->code = $code;
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
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'name' => $this->name,
            'type' => $this->type,
            'amount' => $this->amount,
            'code' => $this->code,
        ]);
    }
}
