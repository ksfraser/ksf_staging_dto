# Requirements Specification — ksf_staging_dto

> **Package**: ksfraser/staging-dto
> **Version**: 1.0.0
> **Platform**: PHP 7.3+

---

## 1. Business Context

External modules (Square, WooCommerce, PayPal, Stripe) need to pass staging data to ISU via hooks. A shared package (`ksfraser/staging-dto`) provides immutable Data Transfer Objects used by all modules, ensuring a common contract and version compatibility.

---

## 2. Functional Requirements

### FR-DTO-001: Base Entity DTO

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-001-001 | `StagingEntity` is abstract base class with `$source`, `$sourceId`, `$createdAt` | Must | Planned |
| FR-DTO-001-002 | All properties are readonly (immutable) | Must | Planned |
| FR-DTO-001-003 | Constructor accepts `$source`, `$sourceId`, `$createdAt` | Must | Planned |
| FR-DTO-001-004 | `getSource()`, `getSourceId()`, `getCreatedAt()` methods | Must | Planned |
| FR-DTO-001-005 | `toArray()` method returns array representation | Should | Planned |
| FR-DTO-001-006 | `jsonSerialize()` for JSON encoding | Should | Planned |

---

### FR-DTO-002: Transaction DTOs

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-002-001 | `StagingTransaction` extends `StagingEntity` with `$amount`, `$currency`, `$status`, `$paymentMethod` | Must | Planned |
| FR-DTO-002-002 | `StagingOrder` extends `StagingTransaction` with `$lineItems[]`, `$customerSourceId`, `$billingAddress`, `$shippingAddress` | Must | Planned |
| FR-DTO-002-003 | `StagingInvoice` extends `StagingTransaction` with `$lineItems[]`, `$customerSourceId`, `$dueDate` | Must | Planned |
| FR-DTO-002-004 | `StagingPayment` extends `StagingTransaction` with `$transactionSourceId`, `$invoiceSourceId` | Must | Planned |
| FR-DTO-002-005 | `StagingRefund` extends `StagingTransaction` with `$transactionSourceId`, `$reason` | Must | Planned |
| FR-DTO-002-006 | `StagingSubscription` extends `StagingTransaction` with `$frequency`, `$nextBillingDate`, `$lineItems[]` | Must | Planned |
| FR-DTO-002-007 | Each transaction DTO has own version in constructor | Must | Planned |

---

### FR-DTO-003: Per-DTO Versioning

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-003-001 | Base class defines `$version` property | Must | Planned |
| FR-DTO-003-002 | Each DTO sets its own version in constructor | Must | Planned |
| FR-DTO-003-003 | `getVersion()` returns current version | Must | Planned |
| FR-DTO-003-004 | ISU can check `$dto->getVersion()` for version handling | Must | Planned |
| FR-DTO-003-005 | Version follows semver (MAJOR.MINOR.PATCH) | Should | Planned |

---

### FR-DTO-004: Master Data DTOs

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-004-001 | `StagingCustomer` with `$email`, `$phone`, `$firstName`, `$lastName`, `$company`, `$addresses[]` | Must | Planned |
| FR-DTO-004-002 | `StagingProduct` with `$sku`, `$name`, `$description`, `$price`, `$weight`, `$categories[]`, `$images[]` | Must | Planned |
| FR-DTO-004-003 | `StagingProductVariant` with `$productSourceId`, `$sku`, `$attributes[]`, `$price`, `$stock` | Should | Planned |
| FR-DTO-004-004 | `StagingCategory` with `$name`, `$parentSourceId`, `$description` | Should | Planned |
| FR-DTO-004-005 | `StagingTax` with `$name`, `$rate`, `$type` | Should | Planned |
| FR-DTO-004-006 | `StagingDiscount` with `$name`, `$type`, `$amount`, `$code` | Should | Planned |
| FR-DTO-004-007 | `StagingCoupon` with `$code`, `$type`, `$amount`, `$usageLimit`, `$expiryDate` | Should | Planned |

---

### FR-DTO-005: Loyalty DTOs

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-005-001 | `StagingLoyaltyProgram` with `$name`, `$type`, `$rules[]` | Could | Planned |
| FR-DTO-005-002 | `StagingLoyaltyReward` with `$programSourceId`, `$name`, `$type`, `$points` | Could | Planned |
| FR-DTO-005-003 | `StagingLoyaltyAccount` with `$customerSourceId`, `$programSourceId`, `$points`, `$tier` | Could | Planned |

---

### FR-DTO-006: Line Item DTO

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-006-001 | `StagingLineItem` is standalone (not extending StagingEntity) | Must | Planned |
| FR-DTO-006-002 | `$transactionSourceId` field for xref to parent order/invoice | Must | Planned |
| FR-DTO-006-003 | `$sku`, `$quantity`, `$unitPrice`, `$discount`, `$tax` | Must | Planned |
| FR-DTO-006-004 | `$description`, `$name`, `$sourceId` | Must | Planned |

---

### FR-DTO-007: Existence Query DTOs

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-007-001 | `StagingExistsQuery` with `$source`, `$sourceId`, `$entityType` | Must | Planned |
| FR-DTO-007-002 | `StagingExistsResult` with `$exists`, `$stagingId`, `$status`, `$message` | Must | Planned |

---

### FR-DTO-008: Additional DTOs

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-008-001 | `StagingInventory` with `$sku`, `$quantity`, `$warehouse`, `$reason` | Should | Planned |
| FR-DTO-008-002 | `StagingShipment` with `$transactionSourceId`, `$carrier`, `$trackingNumber`, `$status` | Should | Planned |
| FR-DTO-008-003 | `StagingNote` with `$entitySourceId`, `$entityType`, `$note`, `$type` (audit/sync/manual) | Should | Planned |

---

### FR-DTO-009: Package & Autoloading

| ID | Requirement | Priority | Status |
|----|-------------|----------|--------|
| FR-DTO-009-001 | `composer.json` with PSR-4 autoloading | Must | Planned |
| FR-DTO-009-002 | Namespace: `Ksfraser\StagingDto\` | Must | Planned |
| FR-DTO-009-003 | PHP 7.3 compatible (no typed properties, no union types) | Must | Planned |
| FR-DTO-009-004 | No external dependencies | Must | Planned |
| FR-DTO-009-005 | `phpunit.xml` for testing | Should | Planned |

---

## 3. Non-Functional Requirements

| ID | Requirement | Details |
|----|-------------|---------|
| NFR-DTO-001 | PHP Version | PHP 7.3+ compatible |
| NFR-DTO-002 | Immutability | All DTOs are readonly (no setters) |
| NFR-DTO-003 | Performance | DTOs are lightweight value objects |
| NFR-DTO-004 | Testing | 100% code coverage target |
| NFR-DTO-005 | Documentation | Full PHPDoc with @param, @return, @throws, @since |

---

## 4. Data Model

### 4.1 DTO Fields

See UML.md §5 for complete field definitions per DTO.

### 4.2 Version Strategy

Each DTO sets its own version in constructor:

```php
$this->version = '1.0.0'; // Per-DTO version
```

ISU checks version for version-specific handling:

```php
if (version_compare($dto->getVersion(), '2.0.0', '>=')) {
    // Handle v2+ fields
}
```

---

## 5. Inter-Module Communication

### Hook Usage

```php
// External module creates DTO and calls ISU hook
$order = new StagingOrder('square', 'sq_txn_123', 100.00, 'USD', 'completed', 'card');
$result = hook_invoke('ksf_FA_ImportStagingProcessing_UI', 'stageEntity', $order);

// Check staging existence
$query = new StagingExistsQuery('square', 'sq_txn_123', 'order');
$exists = hook_invoke('ksf_FA_ImportStagingProcessing_UI', 'stagingExists', $query);
```

### ISU Response

ISU responds about staging data ONLY:

```php
return new StagingExistsResult(
    true,           // exists
    42,             // staging_id
    'pending',      // status
    'Order found'   // message
);
```

ISU is NOT allowed to respond about FA entities (journal entries, customers, etc.).

---

## 6. Glossary

| Term | Definition |
|------|-----------|
| DTO | Data Transfer Object — immutable value object for passing data between modules |
| ISU | Import Staging Processing — FA module handling staging and FA entity creation |
| Staging | Inserting imported data into intermediate tables before processing into FA |
| Source | External module identifier (e.g., 'square', 'woo') |
| SourceId | Unique ID from external system (e.g., 'sq_txn_123') |

---

## Version History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-08-23 | KSFraser | Initial requirements |
