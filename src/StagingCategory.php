<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Category staging DTO.
 *
 * Represents a category from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingCategory extends StagingEntity
{
    /** @var string Category name */
    protected $name = '';

    /** @var string Parent category source ID */
    protected $parentSourceId = '';

    /** @var string Category description */
    protected $description = '';

    /**
     * @param string $source          External module identifier
     * @param string $sourceId        Unique ID from external system
     * @param string $name            Category name
     * @param string $parentSourceId  Parent category source ID
     * @param string $description     Category description
     * @param string $createdAt       ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $name = '',
        string $parentSourceId = '',
        string $description = '',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->name = $name;
        $this->parentSourceId = $parentSourceId;
        $this->description = $description;
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
    public function getParentSourceId(): string
    {
        return $this->parentSourceId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'name' => $this->name,
            'parentSourceId' => $this->parentSourceId,
            'description' => $this->description,
        ]);
    }
}
