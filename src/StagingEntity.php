<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Abstract base class for all staging DTOs.
 *
 * Provides common fields (source, sourceId, createdAt) and versioning.
 * All DTOs are immutable — no setters.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
abstract class StagingEntity implements \JsonSerializable
{
    /** @var string External module identifier (e.g., 'square', 'woo') */
    protected $source;

    /** @var string Unique ID from external system */
    protected $sourceId;

    /** @var string ISO 8601 timestamp */
    protected $createdAt;

    /** @var string Per-DTO version (semver) */
    protected $version = '1.0.0';

    /**
     * @param string $source    External module identifier
     * @param string $sourceId  Unique ID from external system
     * @param string $createdAt ISO 8601 timestamp (default: now)
     */
    public function __construct(string $source, string $sourceId, string $createdAt = '')
    {
        $this->source = $source;
        $this->sourceId = $sourceId;
        $this->createdAt = $createdAt ?: date('c');
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
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'source' => $this->source,
            'sourceId' => $this->sourceId,
            'createdAt' => $this->createdAt,
            'version' => $this->version,
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
