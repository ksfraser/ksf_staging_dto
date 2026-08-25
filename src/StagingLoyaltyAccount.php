<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Loyalty account staging DTO.
 *
 * Represents a loyalty account from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingLoyaltyAccount extends StagingEntity
{
    /** @var string Customer source ID */
    protected $customerSourceId = '';

    /** @var string Program source ID */
    protected $programSourceId = '';

    /** @var int Points balance */
    protected $points = 0;

    /** @var string Tier level */
    protected $tier = '';

    /**
     * @param string $source            External module identifier
     * @param string $sourceId          Unique ID from external system
     * @param string $customerSourceId  Customer source ID
     * @param string $programSourceId   Program source ID
     * @param int    $points            Points balance
     * @param string $tier              Tier level
     * @param string $createdAt         ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $customerSourceId = '',
        string $programSourceId = '',
        int $points = 0,
        string $tier = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->customerSourceId = $customerSourceId;
        $this->programSourceId = $programSourceId;
        $this->points = $points;
        $this->tier = $tier;
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
    public function getProgramSourceId(): string
    {
        return $this->programSourceId;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @return string
     */
    public function getTier(): string
    {
        return $this->tier;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'customerSourceId' => $this->customerSourceId,
            'programSourceId' => $this->programSourceId,
            'points' => $this->points,
            'tier' => $this->tier,
        ]);
    }
}
