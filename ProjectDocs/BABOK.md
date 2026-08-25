# BABOK Business Analysis — ksf_staging_dto

> **Package**: ksfraser/staging-dto
> **Version**: 1.0.0
> **Aligned to BABOK v3 knowledge areas**

---

## 1. Stakeholders

| Stakeholder | Role | Interest |
|-------------|------|----------|
| ISU Maintainer | Implements staging logic | Needs DTOs to define contract |
| Square Module | Creates staging entities | Needs DTOs to pass data to ISU hooks |
| WooCommerce Module | Creates staging entities | Needs DTOs to pass data to ISU hooks |
| PayPal Module (future) | Creates staging entities | Needs DTOs to pass data to ISU hooks |
| Stripe Module (future) | Creates staging entities | Needs DTOs to pass data to ISU hooks |
| Bank Import Module (future) | Creates staging entities | Needs DTOs to pass data to ISU hooks |
| PHP Developer | Package maintainer | Needs clean API, versioning, documentation |

---

## 2. Business Needs

### 2.1 Current State (As-Is)

- ISU defines staging interfaces inline (`StagingTransactionInterface`, `StagingCustomerInterface`, etc.)
- Square module implements adapters for these interfaces
- No shared DTO package exists
- Each module duplicates staging data structures
- Version incompatibilities between modules and ISU

### 2.2 Desired State (To-Be)

- Standalone `ksfraser/staging-dto` package with 22 DTOs
- All external modules depend on this package via Composer
- ISU consumes DTOs via hooks — never exposes FA entity data
- Each DTO has its own version (like versioned REST APIs)
- Single source of truth for staging data structures

### 2.3 Gap Analysis

| Gap | Current | Target | Solution |
|-----|---------|--------|----------|
| Shared DTOs | None | `ksfraser/staging-dto` package | New package with 22 DTOs |
| Versioning | None | Per-DTO versioning | Base class `$version` var |
| Contract | ISU interfaces | Standalone DTOs | External modules depend on DTO package |
| Duplication | Per-module interfaces | Single package | Centralized DTOs |

---

## 3. Business Requirements

### BR-DTO-001: Shared Data Transfer Objects

**Statement:** The system SHALL provide a standalone package (`ksfraser/staging-dto`) containing Data Transfer Objects used for cross-module staging integration via ISU hooks.

**Rationale:** External modules (Square, WooCommerce, PayPal, Stripe) need a common contract for passing staging data to ISU. Without a shared package, each module duplicates structures and risks version incompatibilities.

**Acceptance Criteria:**
- 22 DTOs covering all staging entity types
- Base `StagingEntity` class with versioning
- All DTOs immutable (readonly properties)
- PSR-4 autoloading
- PHP 7.3 compatible
- No external dependencies

**Related FRs:** FR-DTO-001, FR-DTO-002

---

### BR-DTO-002: Per-DTO Versioning

**Statement:** Each DTO SHALL maintain its own version number, enabling ISU to handle version-specific logic per entity type.

**Rationale:** Like versioned REST APIs, individual DTOs may evolve independently. ISU needs to know which version of a DTO it's receiving to apply appropriate transformations.

**Acceptance Criteria:**
- Base `StagingEntity` defines `$version` property
- Each DTO sets its own version in constructor
- `getVersion()` method returns current version
- ISU can check `$dto->getVersion()` for version handling

**Related FRs:** FR-DTO-003

---

### BR-DTO-003: Entity Type Hierarchy

**Statement:** The DTO package SHALL define a clear inheritance hierarchy covering Transactions, Entities, and Query objects.

**Rationale:** Different staging entities share common fields (timestamps, source info). A hierarchy reduces duplication and enables polymorphic handling in ISU.

**Acceptance Criteria:**
- `StagingEntity` is the abstract base class
- `StagingTransaction` extends `StagingEntity` for financial transactions
- `StagingCustomer`, `StagingProduct`, `StagingCategory` extend `StagingEntity` for master data
- `StagingLineItem` is a standalone DTO with `transactionSourceId` xref
- `StagingExistsQuery` and `StagingExistsResult` are standalone DTOs

**Related FRs:** FR-DTO-001, FR-DTO-004

---

## 4. Business Rules

| Rule ID | Description |
|---------|------------|
| BR-DTO-R001 | All DTOs are immutable (readonly properties, no setters) |
| BR-DTO-R002 | Each DTO defines its own version in constructor |
| BR-DTO-R003 | No external dependencies — pure PHP value objects |
| BR-DTO-R004 | All DTOs use PHP 7.3 compatible syntax (no typed properties, no union types) |
| BR-DTO-R005 | Source + sourceId combination is unique per staging entity |
| BR-DTO-R006 | LineItem has `transactionSourceId` field for xref to parent order/invoice |
| BR-DTO-R007 | Subscription extends StagingTransaction (recurring billing) |

---

## 5. Solution Approach

### 5.1 Package Structure

```
ksf_staging_dto/
├── src/
│   ├── StagingEntity.php              — Abstract base class
│   ├── StagingTransaction.php         — Abstract financial transaction
│   ├── StagingOrder.php               — Order (WooCommerce, Square orders)
│   ├── StagingInvoice.php             — Invoice (Square invoices)
│   ├── StagingPayment.php             — Payment (Square, PayPal, Stripe)
│   ├── StagingRefund.php              — Refund
│   ├── StagingSubscription.php        — Subscription (Square, WooCommerce)
│   ├── StagingCustomer.php            — Customer
│   ├── StagingProduct.php             — Product
│   ├── StagingProductVariant.php      — Product variant (catalog import)
│   ├── StagingCategory.php            — Category
│   ├── StagingTax.php                 — Tax
│   ├── StagingDiscount.php            — Discount
│   ├── StagingCoupon.php              — Coupon (WooCommerce)
│   ├── StagingLoyaltyProgram.php      — Loyalty program
│   ├── StagingLoyaltyReward.php       — Loyalty reward
│   ├── StagingLoyaltyAccount.php      — Loyalty account
│   ├── StagingInventory.php           — Inventory
│   ├── StagingShipment.php            — Shipment
│   ├── StagingNote.php                — Note (audit, sync, manual)
│   ├── StagingLineItem.php            — Line item (order lines, invoice lines)
│   ├── StagingExistsQuery.php         — Query for staging existence
│   └── StagingExistsResult.php        — Result of staging existence check
├── composer.json
├── README.md
└── ProjectDocs/
    ├── BABOK.md
    ├── UML.md
    ├── Requirements.md
    ├── RTM.md
    └── TestPlan.md
```

### 5.2 DTO Hierarchy

```
StagingEntity (abstract)
├── StagingTransaction (abstract)
│   ├── StagingOrder
│   ├── StagingInvoice
│   ├── StagingPayment
│   ├── StagingRefund
│   └── StagingSubscription
├── StagingCustomer
├── StagingProduct
├── StagingProductVariant
├── StagingCategory
├── StagingTax
├── StagingDiscount
├── StagingCoupon
├── StagingLoyaltyProgram
├── StagingLoyaltyReward
├── StagingLoyaltyAccount
├── StagingInventory
├── StagingShipment
├── StagingNote
└── StagingLineItem (standalone, not extending StagingEntity)

StagingExistsQuery (standalone)
StagingExistsResult (standalone)
```

### 5.3 Key Fields

| DTO | Key Fields |
|-----|-----------|
| StagingEntity | `$source`, `$sourceId`, `$createdAt`, `$version` |
| StagingTransaction | Extends Entity + `$amount`, `$currency`, `$status`, `$paymentMethod` |
| StagingOrder | Extends Transaction + `$lineItems[]`, `$customerSourceId`, `$billingAddress`, `$shippingAddress` |
| StagingInvoice | Extends Transaction + `$lineItems[]`, `$customerSourceId`, `$dueDate` |
| StagingPayment | Extends Transaction + `$transactionSourceId`, `$invoiceSourceId` |
| StagingSubscription | Extends Transaction + `$frequency`, `$nextBillingDate`, `$lineItems[]` |
| StagingLineItem | `$source`, `$sourceId`, `$transactionSourceId`, `$sku`, `$quantity`, `$unitPrice`, `$discount`, `$tax` |
| StagingCustomer | Extends Entity + `$email`, `$phone`, `$firstName`, `$lastName`, `$company`, `$addresses[]` |
| StagingProduct | Extends Entity + `$sku`, `$name`, `$description`, `$price`, `$weight`, `$categories[]`, `$images[]` |
| StagingProductVariant | Extends Entity + `$productSourceId`, `$sku`, `$attributes[]`, `$price`, `$stock` |
| StagingCategory | Extends Entity + `$name`, `$parentSourceId`, `$description` |
| StagingTax | Extends Entity + `$name`, `$rate`, `$type` |
| StagingDiscount | Extends Entity + `$name`, `$type`, `$amount`, `$code` |
| StagingCoupon | Extends Entity + `$code`, `$type`, `$amount`, `$usageLimit`, `$expiryDate` |
| StagingLoyaltyProgram | Extends Entity + `$name`, `$type`, `$rules[]` |
| StagingLoyaltyReward | Extends Entity + `$programSourceId`, `$name`, `$type`, `$points` |
| StagingLoyaltyAccount | Extends Entity + `$customerSourceId`, `$programSourceId`, `$points`, `$tier` |
| StagingInventory | Extends Entity + `$sku`, `$quantity`, `$warehouse`, `$reason` |
| StagingShipment | Extends Entity + `$transactionSourceId`, `$carrier`, `$trackingNumber`, `$status` |
| StagingNote | Extends Entity + `$entitySourceId`, `$entityType`, `$note`, `$type` (audit/sync/manual) |
| StagingExistsQuery | `$source`, `$sourceId`, `$entityType` |
| StagingExistsResult | `$exists`, `$stagingId`, `$status`, `$message` |

---

## 6. Risks

| Risk | Impact | Likelihood | Mitigation |
|------|--------|------------|------------|
| DTO versioning complexity | Modules may not handle version differences | Medium | Document version changes, provide migration guides |
| PHP 7.3 limitations | Cannot use modern syntax | High | Target PHP 7.3, avoid typed properties |
| Package adoption | Modules may not switch from inline interfaces | Medium | Deprecate old interfaces, provide migration path |
| Breaking changes | Modules break on DTO updates | Low | Semantic versioning, immutable DTOs |

---

## 7. Traceability

| BR | FR | UAT |
|----|----|-----|
| BR-DTO-001 | FR-DTO-001 | UAT-DTO-001 |
| BR-DTO-002 | FR-DTO-003 | UAT-DTO-002 |
| BR-DTO-003 | FR-DTO-004 | UAT-DTO-003 |

---

## Version History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-08-23 | KSFraser | Initial BABOK alignment |
