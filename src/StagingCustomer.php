<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto;

/**
 * Customer staging DTO.
 *
 * Represents a customer from Square, WooCommerce, PayPal, etc.
 *
 * @package Ksfraser\StagingDto
 * @since 1.0.0
 */
class StagingCustomer extends StagingEntity
{
    /** @var string Customer email */
    protected $email = '';

    /** @var string Customer phone */
    protected $phone = '';

    /** @var string First name */
    protected $firstName = '';

    /** @var string Last name */
    protected $lastName = '';

    /** @var string Company name */
    protected $company = '';

    /** @var array Addresses */
    protected $addresses = [];

    /**
     * @param string $source     External module identifier
     * @param string $sourceId   Unique ID from external system
     * @param string $email      Customer email
     * @param string $phone      Customer phone
     * @param string $firstName  First name
     * @param string $lastName   Last name
     * @param string $company    Company name
     * @param array  $addresses  Addresses
     * @param string $createdAt  ISO 8601 timestamp
     */
    public function __construct(
        string $source,
        string $sourceId,
        string $email = '',
        string $phone = '',
        string $firstName = '',
        string $lastName = '',
        string $company = '',
        array $addresses = [],
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $createdAt);
        $this->version = '1.0.0';
        $this->email = $email;
        $this->phone = $phone;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->company = $company;
        $this->addresses = $addresses;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @return array
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'email' => $this->email,
            'phone' => $this->phone,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'company' => $this->company,
            'addresses' => $this->addresses,
        ]);
    }
}
