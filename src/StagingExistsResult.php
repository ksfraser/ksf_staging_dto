<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Staging existence result DTO.
 *
 * Returned by ISU when checking staging existence.
 * ISU responds about staging data ONLY — never about FA entities.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingExistsResult
{
    /** @var bool Whether staging entity exists */
    protected $exists = false;

    /** @var int Staging ID (0 if not found) */
    protected $stagingId = 0;

    /** @var string Status (e.g., 'pending', 'processed', 'error') */
    protected $status = '';

    /** @var string Message */
    protected $message = '';

    /**
     * @param bool   $exists    Whether entity exists
     * @param int    $stagingId Staging ID
     * @param string $status    Status
     * @param string $message   Message
     */
    public function __construct(bool $exists = false, int $stagingId = 0, string $status = '', string $message = '')
    {
        $this->exists = $exists;
        $this->stagingId = $stagingId;
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @return bool
     */
    public function getExists(): bool
    {
        return $this->exists;
    }

    /**
     * @return int
     */
    public function getStagingId(): int
    {
        return $this->stagingId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'exists' => $this->exists,
            'stagingId' => $this->stagingId,
            'status' => $this->status,
            'message' => $this->message,
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
