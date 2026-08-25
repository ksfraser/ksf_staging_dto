<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Loyalty program staging DTO.
 *
 * Represents a loyalty program from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingLoyaltyProgram extends StagingEntity
{
    /** @var string Program name */
    protected $name = '';

    /** @var string Program type (e.g., 'points', 'tier') */
    protected $type = 'points';

    /** @var array Program rules */
    protected $rules = [];

    /**
     * @param string $source    External module identifier
     * @param string $sourceId  Unique ID from external system
     * @param string $name      Program name
     * @param string $type      Program type
     * @param array  $rules     Program rules
     * @param string $createdAt ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $name = '',
        string $type = 'points',
        array $rules = [],
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->name = $name;
        $this->type = $type;
        $this->rules = $rules;
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
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'name' => $this->name,
            'type' => $this->type,
            'rules' => $this->rules,
        ]);
    }
}
