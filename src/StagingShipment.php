<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Shipment staging DTO.
 *
 * Represents a shipment from Square, WooCommerce, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingShipment extends StagingEntity
{
    /** @var string Transaction source ID (order xref) */
    protected $transactionSourceId = '';

    /** @var string Carrier (e.g., 'UPS', 'FedEx', 'USPS') */
    protected $carrier = '';

    /** @var string Tracking number */
    protected $trackingNumber = '';

    /** @var string Shipment status (e.g., 'pending', 'shipped', 'delivered') */
    protected $status = 'pending';

    /**
     * @param string $source              External module identifier
     * @param string $sourceId            Unique ID from external system
     * @param string $transactionSourceId Order xref
     * @param string $carrier             Carrier
     * @param string $trackingNumber      Tracking number
     * @param string $status              Shipment status
     * @param string $createdAt           ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $transactionSourceId = '',
        string $carrier = '',
        string $trackingNumber = '',
        string $status = 'pending',
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->transactionSourceId = $transactionSourceId;
        $this->carrier = $carrier;
        $this->trackingNumber = $trackingNumber;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTransactionSourceId(): string
    {
        return $this->transactionSourceId;
    }

    /**
     * @return string
     */
    public function getCarrier(): string
    {
        return $this->carrier;
    }

    /**
     * @return string
     */
    public function getTrackingNumber(): string
    {
        return $this->trackingNumber;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'transactionSourceId' => $this->transactionSourceId,
            'carrier' => $this->carrier,
            'trackingNumber' => $this->trackingNumber,
            'status' => $this->status,
        ]);
    }
}
