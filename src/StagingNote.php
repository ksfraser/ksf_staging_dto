<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Note staging DTO.
 *
 * Represents a note (audit, sync, manual) for staging entities.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingNote extends StagingEntity
{
    /** @var string Entity source ID */
    protected $entitySourceId = '';

    /** @var string Entity type (e.g., 'order', 'invoice', 'customer') */
    protected $entityType = '';

    /** @var string Note content */
    protected $note = '';

    /** @var string Note type (e.g., 'audit', 'sync', 'manual') */
    protected $type = 'manual';

    /**
     * @param string $source         External module identifier
     * @param string $sourceId       Unique ID from external system
     * @param string $entitySourceId Entity source ID
     * @param string $entityType     Entity type
     * @param string $note           Note content
     * @param string $type           Note type
     * @param string $createdAt      ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $entitySourceId = '',
        string $entityType = '',
        string $note = '',
        string $type = 'manual',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->entitySourceId = $entitySourceId;
        $this->entityType = $entityType;
        $this->note = $note;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getEntitySourceId(): string
    {
        return $this->entitySourceId;
    }

    /**
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->entityType;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return $this->note;
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
            'entitySourceId' => $this->entitySourceId,
            'entityType' => $this->entityType,
            'note' => $this->note,
            'type' => $this->type,
        ]);
    }
}
