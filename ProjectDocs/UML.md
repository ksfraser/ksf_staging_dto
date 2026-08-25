# UML Diagrams — ksf_staging_dto

> **Package**: ksfraser/staging-dto
> **Version**: 1.0.0

---

## 1. Class Hierarchy

```
┌─────────────────────────────────────────┐
│           StagingEntity (abstract)      │
│─────────────────────────────────────────│
│ - source: string                        │
│ - sourceId: string                      │
│ - createdAt: string                     │
│ - version: string                       │
│─────────────────────────────────────────│
│ + getSource(): string                   │
│ + getSourceId(): string                 │
│ + getCreatedAt(): string                │
│ + getVersion(): string                  │
└─────────────────────────────────────────┘
                    △
                    │
        ┌───────────┴───────────────────────────────────────┐
        │                                                   │
┌───────┴───────┐                          ┌───────────────┴──────────────┐
│StagingTransaction│                       │ StagingCustomer              │
│ (abstract)   │                          │ StagingProduct               │
│──────────────│                          │ StagingProductVariant        │
│ - amount     │                          │ StagingCategory              │
│ - currency   │                          │ StagingTax                   │
│ - status     │                          │ StagingDiscount              │
│ - paymentMethod│                        │ StagingCoupon                │
│──────────────│                          │ StagingLoyaltyProgram        │
│ + getAmount()│                          │ StagingLoyaltyReward         │
│ + ...        │                          │ StagingLoyaltyAccount        │
└───────┬──────┘                          │ StagingInventory             │
        │                                 │ StagingShipment              │
        │                                 │ StagingNote                  │
        │                                 └──────────────────────────────┘
        │
        │  ┌──────────────────┐
        ├─ │ StagingOrder     │
        ├─ │ StagingInvoice   │
        ├─ │ StagingPayment   │
        ├─ │ StagingRefund    │
        └─ │ StagingSubscription│
           └──────────────────┘

┌──────────────────┐      ┌──────────────────┐
│ StagingLineItem  │      │ StagingExistsQuery│
│ (standalone)     │      │ (standalone)     │
│──────────────────│      │──────────────────│
│ - transactionSourceId │  │ - source         │
│ - sku            │      │ - sourceId       │
│ - quantity       │      │ - entityType     │
│ - unitPrice      │      └──────────────────┘
└──────────────────┘               │
        │                          ▼
        │               ┌──────────────────┐
        │               │ StagingExistsResult│
        │               │ (standalone)     │
        │               │──────────────────│
        │               │ - exists         │
        │               │ - stagingId      │
        │               │ - status         │
        └──────────────►│ - message        │
                        └──────────────────┘
```

---

## 2. Sequence Diagram: External Module → ISU via Hooks

```
┌─────────────┐          ┌─────────────────┐          ┌─────────────┐
│ Square /    │          │ ksf_staging_dto │          │     ISU     │
│ WooCommerce │          │    (DTOs)       │          │   (hooks)   │
└──────┬──────┘          └────────┬────────┘          └──────┬──────┘
       │                          │                         │
       │  1. Create DTO           │                         │
       │─────────────────────────►│                         │
       │  new StagingOrder(...)   │                         │
       │                          │                         │
       │  2. Call ISU hook        │                         │
       │───────────────────────────────────────────────────►│
       │  hook_invoke('ISU', 'stageEntity', $dto)          │
       │                          │                         │
       │                          │  3. Receive DTO         │
       │                          │◄────────────────────────│
       │                          │  Validate DTO type      │
       │                          │  Check version          │
       │                          │                         │
       │                          │  4. Write to staging DB │
       │                          │────────────────────────►│
       │                          │  INSERT INTO 0_staging_*│
       │                          │                         │
       │                          │  5. Return result       │
       │                          │◄────────────────────────│
       │  6. Return exists result │                         │
       │◄─────────────────────────│                         │
       │  StagingExistsResult     │                         │
       │  (exists, staging_id)    │                         │
       │                          │                         │
```

---

## 3. Sequence Diagram: Staging Existence Check

```
┌─────────────┐          ┌─────────────────┐          ┌─────────────┐
│ External    │          │ ksf_staging_dto │          │     ISU     │
│ Module      │          │    (DTOs)       │          │   (hooks)   │
└──────┬──────┘          └────────┬────────┘          └──────┬──────┘
       │                          │                         │
       │  1. Create query DTO     │                         │
       │─────────────────────────►│                         │
       │  new StagingExistsQuery  │                         │
       │  ('square', 'txn_123')   │                         │
       │                          │                         │
       │  2. Call ISU hook        │                         │
       │───────────────────────────────────────────────────►│
       │  hook_invoke('ISU', 'stagingExists', $query)      │
       │                          │                         │
       │                          │  3. Receive query       │
       │                          │◄────────────────────────│
       │                          │  SELECT FROM staging    │
       │                          │                         │
       │                          │  4. Return result       │
       │                          │◄────────────────────────│
       │  5. Return exists result │                         │
       │◄─────────────────────────│                         │
       │  StagingExistsResult     │                         │
       │  (true, 42, 'pending')   │                         │
       │                          │                         │
```

---

## 4. Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                        External Modules                            │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐│
│  │   Square    │  │ WooCommerce │  │   PayPal    │  │   Stripe    ││
│  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘  └──────┬──────┘│
└─────────┼────────────────┼────────────────┼────────────────┼────────┘
          │                │                │                │
          │  Create DTOs   │                │                │
          │  Call hooks    │                │                │
          ▼                ▼                ▼                ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    ksf_staging_dto (shared)                         │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐│
│  │StagingOrder  │ │StagingPayment│ │StagingCustomer│ │StagingLineItem││
│  │StagingInvoice│ │StagingRefund │ │StagingProduct │ │StagingExists ││
│  │StagingSubscr │ │StagingTax    │ │StagingCategory│ │  Query/Result││
│  └──────────────┘ └──────────────┘ └──────────────┘ └──────────────┘│
└─────────────────────────────────┬───────────────────────────────────┘
                                  │
                                  │ hook_invoke()
                                  ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    ISU (hooks + DB operations)                      │
│  ┌──────────────┐ ┌──────────────┐ ┌──────────────┐ ┌──────────────┐│
│  │ stageEntity  │ │stagingExists │ │ processQueue │ │ getStaging   ││
│  └──────┬───────┘ └──────┬───────┘ └──────┬───────┘ └──────┬───────┘│
│         │                │                │                │         │
│         ▼                ▼                ▼                ▼         │
│  ┌──────────────────────────────────────────────────────────────────┐│
│  │                    Staging DB Tables                             ││
│  │  0_staging_transactions  0_staging_payments  0_staging_customers ││
│  │  0_staging_line_items    0_staging_products  0_staging_log       ││
│  └──────────────────────────────────────────────────────────────────┘│
│         │                                                            │
│         │ Process into FA                                            │
│         ▼                                                            │
│  ┌──────────────────────────────────────────────────────────────────┐│
│  │                    FA Entity Tables                              ││
│  │  0_debtor_trans  0_cust_branch  0_sales_orders  etc.           ││
│  └──────────────────────────────────────────────────────────────────┘│
└─────────────────────────────────────────────────────────────────────┘
```

---

## 5. Version Handling

Each DTO defines its own version in the constructor:

```php
class StagingOrder extends StagingTransaction
{
    public function __construct(
        string $source,
        string $sourceId,
        float $amount,
        string $currency,
        string $status,
        string $paymentMethod,
        array $lineItems = [],
        string $customerSourceId = '',
        array $billingAddress = [],
        array $shippingAddress = [],
        string $createdAt = ''
    ) {
        parent::__construct($source, $sourceId, $amount, $currency, $status, $paymentMethod, $createdAt);
        $this->version = '1.0.0';
        $this->lineItems = $lineItems;
        $this->customerSourceId = $customerSourceId;
        $this->billingAddress = $billingAddress;
        $this->shippingAddress = $shippingAddress;
    }
}
```

ISU checks version for version-specific handling:

```php
public function stageEntity($dto): StagingExistsResult
{
    $version = $dto->getVersion();
    
    if (version_compare($version, '2.0.0', '>=')) {
        // Handle v2+ fields
    } else {
        // Handle v1 fields
    }
    
    // Write to staging DB...
}
```

---

## 6. Source ID Strategy

Each external module uses a unique source prefix:

| Module | Source Value | Example sourceId |
|--------|-------------|-----------------|
| Square | `square` | `sq_txn_123` |
| WooCommerce (instance 1) | `woo` | `woo_ord_456` |
| WooCommerce (instance 2) | `woo2` | `woo2_ord_789` |
| PayPal (future) | `pp` | `pp_pay_012` |
| Stripe (future) | `stripe` | `stripe_ch_345` |
| Bank Import (future) | `bank` | `bank_tx_678` |

---

## Version History

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-08-23 | KSFraser | Initial UML |
