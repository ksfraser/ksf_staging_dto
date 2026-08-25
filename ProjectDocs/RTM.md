# Requirements Traceability Matrix — ksf_staging_dto

> **Package**: ksfraser/staging-dto
> **Version**: 1.0.0

---

## 1. BR → FR Traceability

| BR | FR | Description |
|----|----|-------------|
| BR-DTO-001 | FR-DTO-001, FR-DTO-002, FR-DTO-004, FR-DTO-005, FR-DTO-006, FR-DTO-007, FR-DTO-008 | Shared Data Transfer Objects |
| BR-DTO-002 | FR-DTO-003 | Per-DTO Versioning |
| BR-DTO-003 | FR-DTO-001, FR-DTO-002, FR-DTO-004 | Entity Type Hierarchy |

---

## 2. FR → Test Traceability

| FR | Test Case | Description |
|----|-----------|-------------|
| FR-DTO-001-001 | testStagingEntityCreation | Base entity creation |
| FR-DTO-001-002 | testStagingEntityImmutability | Readonly properties |
| FR-DTO-001-003 | testStagingEntityConstructor | Constructor params |
| FR-DTO-001-004 | testStagingEntityGetters | Getter methods |
| FR-DTO-001-005 | testStagingEntityToArray | Array representation |
| FR-DTO-001-006 | testStagingEntityJsonSerialize | JSON encoding |
| FR-DTO-002-001 | testStagingTransactionCreation | Transaction base |
| FR-DTO-002-002 | testStagingOrderCreation | Order DTO |
| FR-DTO-002-003 | testStagingInvoiceCreation | Invoice DTO |
| FR-DTO-002-004 | testStagingPaymentCreation | Payment DTO |
| FR-DTO-002-005 | testStagingRefundCreation | Refund DTO |
| FR-DTO-002-006 | testStagingSubscriptionCreation | Subscription DTO |
| FR-DTO-002-007 | testTransactionVersioning | Per-transaction version |
| FR-DTO-003-001 | testBaseVersionProperty | Base version property |
| FR-DTO-003-002 | testDtoVersionInConstructor | Version in constructor |
| FR-DTO-003-003 | testGetVersion | getVersion() method |
| FR-DTO-003-004 | testIsuVersionCheck | ISU version handling |
| FR-DTO-003-005 | testSemverFormat | Semver format |
| FR-DTO-004-001 | testStagingCustomerCreation | Customer DTO |
| FR-DTO-004-002 | testStagingProductCreation | Product DTO |
| FR-DTO-004-003 | testStagingProductVariantCreation | Product variant DTO |
| FR-DTO-004-004 | testStagingCategoryCreation | Category DTO |
| FR-DTO-004-005 | testStagingTaxCreation | Tax DTO |
| FR-DTO-004-006 | testStagingDiscountCreation | Discount DTO |
| FR-DTO-004-007 | testStagingCouponCreation | Coupon DTO |
| FR-DTO-005-001 | testStagingLoyaltyProgramCreation | Loyalty program DTO |
| FR-DTO-005-002 | testStagingLoyaltyRewardCreation | Loyalty reward DTO |
| FR-DTO-005-003 | testStagingLoyaltyAccountCreation | Loyalty account DTO |
| FR-DTO-006-001 | testStagingLineItemStandalone | Line item standalone |
| FR-DTO-006-002 | testStagingLineItemTransactionXref | Transaction xref |
| FR-DTO-006-003 | testStagingLineItemFields | Line item fields |
| FR-DTO-006-004 | testStagingLineItemAdditionalFields | Additional fields |
| FR-DTO-007-001 | testStagingExistsQueryCreation | Exists query DTO |
| FR-DTO-007-002 | testStagingExistsResultCreation | Exists result DTO |
| FR-DTO-008-001 | testStagingInventoryCreation | Inventory DTO |
| FR-DTO-008-002 | testStagingShipmentCreation | Shipment DTO |
| FR-DTO-008-003 | testStagingNoteCreation | Note DTO |
| FR-DTO-009-001 | testComposerJson | Composer config |
| FR-DTO-009-002 | testNamespace | PSR-4 namespace |
| FR-DTO-009-003 | testPhp73Compatibility | PHP 7.3 syntax |
| FR-DTO-009-004 | testNoExternalDependencies | No dependencies |
| FR-DTO-009-005 | testPhpunitConfig | PHPUnit config |

---

## 3. Cross-Module References

| Module | Reference | Description |
|--------|-----------|-------------|
| ksf_FA_ImportStagingProcessing | FR-09.01 | Consumes DTOs via hooks |
| ksf_FA_Square | FR-SQ-020 | Creates DTOs for ISU hooks |
| ksf_FA_Woocommerce | FR-WC-010 | Creates DTOs for ISU hooks |
| ksf_FA_PayPal (future) | FR-PP-001 | Creates DTOs for ISU hooks |
| ksf_FA_Stripe (future) | FR-ST-001 | Creates DTOs for ISU hooks |

---

## 4. Version History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-08-23 | KSFraser | Initial RTM |
