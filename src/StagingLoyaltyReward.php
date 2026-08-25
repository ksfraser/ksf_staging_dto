<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Loyalty reward staging DTO.
 *
 * Represents a loyalty reward from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingLoyaltyReward extends StagingEntity
{
    /** @var string Program source ID */
    protected $programSourceId = '';

    /** @var string Reward name */
    protected $name = '';

    /** @var string Reward type (e.g., 'discount', 'free_item') */
    protected $type = 'discount';

    /** @var int Points required */
    protected $points = 0;

    /**
     * @param string $source           External module identifier
     * @param string $sourceId         Unique ID from external system
     * @param string $programSourceId  Program source ID
     * @param string $name             Reward name
     * @param string $type             Reward type
     * @param int    $points           Points required
     * @param string $createdAt        ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $programSourceId = '',
        string $name = '',
        string $type = 'discount',
        int $points = 0,
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->programSourceId = $programSourceId;
        $this->name = $name;
        $this->type = $type;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getProgramSourceId(): string
    {
        return $this->programSourceId;
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
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'programSourceId' => $this->programSourceId,
            'name' => $this->name,
            'type' => $this->type,
            'points' => $this->points,
        ]);
    }
}
