<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Staging existence query DTO.
 *
 * Used to check if a staging entity exists by source + sourceId.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingExistsQuery
{
    /** @var string Source module */
    protected $source = '';

    /** @var string Source ID */
    protected $sourceId = '';

    /** @var string Entity type (e.g., 'order', 'invoice', 'customer') */
    protected $entityType = '';

    /**
     * @param string $source     Source module
     * @param string $sourceId   Source ID
     * @param string $entityType Entity type
     */
    public function __construct(string $source = '', string $sourceId = '', string $entityType = '')
    {
        $this->source = $source;
        $this->sourceId = $sourceId;
        $this->entityType = $entityType;
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
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'sourceId' => $this->sourceId,
            'entityType' => $this->entityType,
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
