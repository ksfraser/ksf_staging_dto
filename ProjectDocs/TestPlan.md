# Test Plan — ksf_staging_dto

> **Package**: ksfraser/staging-dto
> **Version**: 1.0.0
> **Framework**: PHPUnit 9.6

---

## 1. Test Strategy

### 1.1 Unit Tests

- Each DTO tested in isolation
- Constructor validation
- Getter methods
- Immutability (no setters)
- `toArray()` and `jsonSerialize()` methods
- Edge cases (empty strings, null values, arrays)

### 1.2 Integration Tests

- DTOs used in hook context (mock ISU)
- Version handling across DTOs
- DTO type checking (`instanceof`)

---

## 2. Test Cases

### 2.1 StagingEntity Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingEntityCreation | Create base entity with required fields | FR-DTO-001-001 |
| testStagingEntityImmutability | Verify readonly properties | FR-DTO-001-002 |
| testStagingEntityConstructor | Constructor with all params | FR-DTO-001-003 |
| testStagingEntityGetters | All getter methods return correct values | FR-DTO-001-004 |
| testStagingEntityToArray | Array representation | FR-DTO-001-005 |
| testStagingEntityJsonSerialize | JSON encoding | FR-DTO-001-006 |
| testStagingEntityDefaultCreatedAt | Default created_at value | FR-DTO-001-003 |

---

### 2.2 Transaction DTO Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingTransactionCreation | Create transaction with amount, currency, status | FR-DTO-002-001 |
| testStagingTransactionGetters | Transaction getter methods | FR-DTO-002-001 |
| testStagingOrderCreation | Create order with line items | FR-DTO-002-002 |
| testStagingOrderLineItems | Order line items array | FR-DTO-002-002 |
| testStagingOrderBillingAddress | Order billing address | FR-DTO-002-002 |
| testStagingOrderShippingAddress | Order shipping address | FR-DTO-002-002 |
| testStagingInvoiceCreation | Create invoice with due date | FR-DTO-002-003 |
| testStagingInvoiceDueDate | Invoice due date | FR-DTO-002-003 |
| testStagingPaymentCreation | Create payment with transaction xref | FR-DTO-002-004 |
| testStagingPaymentTransactionXref | Payment transaction reference | FR-DTO-002-004 |
| testStagingPaymentInvoiceXref | Payment invoice reference | FR-DTO-002-004 |
| testStagingRefundCreation | Create refund with reason | FR-DTO-002-005 |
| testStagingRefundReason | Refund reason | FR-DTO-002-005 |
| testStagingSubscriptionCreation | Create subscription with frequency | FR-DTO-002-006 |
| testStagingSubscriptionFrequency | Subscription frequency | FR-DTO-002-006 |
| testStagingSubscriptionNextBillingDate | Subscription next billing date | FR-DTO-002-006 |
| testTransactionVersioning | Each transaction has own version | FR-DTO-002-007 |

---

### 2.3 Versioning Tests

| Test | Description | FR |
|------|-------------|-----|
| testBaseVersionProperty | Base class has version property | FR-DTO-003-001 |
| testDtoVersionInConstructor | Each DTO sets version in constructor | FR-DTO-003-002 |
| testGetVersion | getVersion() returns correct version | FR-DTO-003-003 |
| testIsuVersionCheck | ISU can check version for handling | FR-DTO-003-004 |
| testSemverFormat | Version follows semver format | FR-DTO-003-005 |
| testDifferentVersionsPerDto | Different DTOs have different versions | FR-DTO-003-002 |

---

### 2.4 Master Data DTO Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingCustomerCreation | Create customer with contact info | FR-DTO-004-001 |
| testStagingCustomerEmail | Customer email field | FR-DTO-004-001 |
| testStagingCustomerPhone | Customer phone field | FR-DTO-004-001 |
| testStagingCustomerAddresses | Customer addresses array | FR-DTO-004-001 |
| testStagingProductCreation | Create product with SKU | FR-DTO-004-002 |
| testStagingProductSku | Product SKU field | FR-DTO-004-002 |
| testStagingProductPrice | Product price field | FR-DTO-004-002 |
| testStagingProductCategories | Product categories array | FR-DTO-004-002 |
| testStagingProductImages | Product images array | FR-DTO-004-002 |
| testStagingProductVariantCreation | Create variant with product xref | FR-DTO-004-003 |
| testStagingProductVariantAttributes | Variant attributes array | FR-DTO-004-003 |
| testStagingCategoryCreation | Create category with name | FR-DTO-004-004 |
| testStagingCategoryParent | Category parent source ID | FR-DTO-004-004 |
| testStagingTaxCreation | Create tax with rate | FR-DTO-004-005 |
| testStagingTaxRate | Tax rate field | FR-DTO-004-005 |
| testStagingDiscountCreation | Create discount with type | FR-DTO-004-006 |
| testStagingDiscountType | Discount type field | FR-DTO-004-006 |
| testStagingCouponCreation | Create coupon with code | FR-DTO-004-007 |
| testStagingCouponCode | Coupon code field | FR-DTO-004-007 |
| testStagingCouponExpiry | Coupon expiry date | FR-DTO-004-007 |

---

### 2.5 Loyalty DTO Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingLoyaltyProgramCreation | Create loyalty program | FR-DTO-005-001 |
| testStagingLoyaltyProgramRules | Program rules array | FR-DTO-005-001 |
| testStagingLoyaltyRewardCreation | Create loyalty reward | FR-DTO-005-002 |
| testStagingLoyaltyRewardPoints | Reward points field | FR-DTO-005-002 |
| testStagingLoyaltyAccountCreation | Create loyalty account | FR-DTO-005-003 |
| testStagingLoyaltyAccountPoints | Account points field | FR-DTO-005-003 |
| testStagingLoyaltyAccountTier | Account tier field | FR-DTO-005-003 |

---

### 2.6 Line Item DTO Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingLineItemStandalone | Line item not extending StagingEntity | FR-DTO-006-001 |
| testStagingLineItemTransactionXref | transactionSourceId field | FR-DTO-006-002 |
| testStagingLineItemSku | Line item SKU field | FR-DTO-006-003 |
| testStagingLineItemQuantity | Line item quantity field | FR-DTO-006-003 |
| testStagingLineItemUnitPrice | Line item unit price field | FR-DTO-006-003 |
| testStagingLineItemDiscount | Line item discount field | FR-DTO-006-003 |
| testStagingLineItemTax | Line item tax field | FR-DTO-006-003 |
| testStagingLineItemDescription | Line item description field | FR-DTO-006-004 |
| testStagingLineItemName | Line item name field | FR-DTO-006-004 |

---

### 2.7 Existence Query DTO Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingExistsQueryCreation | Create exists query | FR-DTO-007-001 |
| testStagingExistsQuerySource | Query source field | FR-DTO-007-001 |
| testStagingExistsQuerySourceId | Query sourceId field | FR-DTO-007-001 |
| testStagingExistsQueryEntityType | Query entity type field | FR-DTO-007-001 |
| testStagingExistsResultCreation | Create exists result | FR-DTO-007-002 |
| testStagingExistsResultExists | Result exists field | FR-DTO-007-002 |
| testStagingExistsResultStagingId | Result staging ID field | FR-DTO-007-002 |
| testStagingExistsResultStatus | Result status field | FR-DTO-007-002 |
| testStagingExistsResultMessage | Result message field | FR-DTO-007-002 |

---

### 2.8 Additional DTO Tests

| Test | Description | FR |
|------|-------------|-----|
| testStagingInventoryCreation | Create inventory DTO | FR-DTO-008-001 |
| testStagingInventorySku | Inventory SKU field | FR-DTO-008-001 |
| testStagingInventoryQuantity | Inventory quantity field | FR-DTO-008-001 |
| testStagingShipmentCreation | Create shipment DTO | FR-DTO-008-002 |
| testStagingShipmentTracking | Shipment tracking number | FR-DTO-008-002 |
| testStagingShipmentStatus | Shipment status field | FR-DTO-008-002 |
| testStagingNoteCreation | Create note DTO | FR-DTO-008-003 |
| testStagingNoteType | Note type field (audit/sync/manual) | FR-DTO-008-003 |
| testStagingNoteEntityXref | Note entity source ID | FR-DTO-008-003 |

---

### 2.9 Package Tests

| Test | Description | FR |
|------|-------------|-----|
| testComposerJson | Composer config valid | FR-DTO-009-001 |
| testNamespace | PSR-4 namespace correct | FR-DTO-009-002 |
| testPhp73Compatibility | No PHP 8+ syntax | FR-DTO-009-003 |
| testNoExternalDependencies | No dependencies in composer.json | FR-DTO-009-004 |
| testPhpunitConfig | PHPUnit config valid | FR-DTO-009-005 |

---

## 3. Coverage Targets

| Component | Target |
|-----------|--------|
| StagingEntity | 100% |
| Transaction DTOs | 100% |
| Master Data DTOs | 100% |
| Loyalty DTOs | 100% |
| Line Item DTO | 100% |
| Existence Query DTOs | 100% |
| Additional DTOs | 100% |
| **Overall** | **100%** |

---

## 4. Test Execution

```bash
# Run all tests
vendor/bin/phpunit

# Run with coverage
vendor/bin/phpunit --coverage-html=coverage

# Run specific test class
vendor/bin/phpunit tests/Unit/StagingEntityTest.php
```

---

## Version History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-08-23 | KSFraser | Initial test plan |
