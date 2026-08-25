<?php
declare(strict_types=1);

namespace Ksfraser\StagingDto\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Ksfraser\StagingDto\StagingEntity;
use Ksfraser\StagingDto\StagingTransaction;
use Ksfraser\StagingDto\StagingOrder;
use Ksfraser\StagingDto\StagingInvoice;
use Ksfraser\StagingDto\StagingPayment;
use Ksfraser\StagingDto\StagingRefund;
use Ksfraser\StagingDto\StagingSubscription;
use Ksfraser\StagingDto\StagingCustomer;
use Ksfraser\StagingDto\StagingProduct;
use Ksfraser\StagingDto\StagingProductVariant;
use Ksfraser\StagingDto\StagingCategory;
use Ksfraser\StagingDto\StagingTax;
use Ksfraser\StagingDto\StagingDiscount;
use Ksfraser\StagingDto\StagingCoupon;
use Ksfraser\StagingDto\StagingLoyaltyProgram;
use Ksfraser\StagingDto\StagingLoyaltyReward;
use Ksfraser\StagingDto\StagingLoyaltyAccount;
use Ksfraser\StagingDto\StagingInventory;
use Ksfraser\StagingDto\StagingShipment;
use Ksfraser\StagingDto\StagingNote;
use Ksfraser\StagingDto\StagingLineItem;
use Ksfraser\StagingDto\StagingExistsQuery;
use Ksfraser\StagingDto\StagingExistsResult;

/**
 * Unit tests for all staging DTOs.
 *
 * @package Ksfraser\StagingDto\Tests\Unit
 * @since 1.0.0
 */
class StagingDtoTest extends TestCase
{
    // ============================================================
    // StagingEntity Tests
    // ============================================================

    public function testStagingEntityCreation(): void
    {
        $entity = new class('square', 'sq_123') extends StagingEntity {};
        
        $this->assertEquals('square', $entity->getSource());
        $this->assertEquals('sq_123', $entity->getSourceId());
        $this->assertNotEmpty($entity->getCreatedAt());
        $this->assertEquals('1.0.0', $entity->getVersion());
    }

    public function testStagingEntityImmutability(): void
    {
        $entity = new class('square', 'sq_123') extends StagingEntity {};
        $reflection = new \ReflectionClass($entity);
        
        foreach ($reflection->getProperties() as $property) {
            $this->assertTrue(
                $property->isProtected() || $property->isPrivate(),
                "Property {$property->getName()} should not be public"
            );
        }
    }

    public function testStagingEntityConstructor(): void
    {
        $entity = new class('woo', 'woo_456', '2026-01-01T00:00:00Z') extends StagingEntity {};
        
        $this->assertEquals('woo', $entity->getSource());
        $this->assertEquals('woo_456', $entity->getSourceId());
        $this->assertEquals('2026-01-01T00:00:00Z', $entity->getCreatedAt());
    }

    public function testStagingEntityGetters(): void
    {
        $entity = new class('pp', 'pp_789') extends StagingEntity {};
        
        $this->assertEquals('pp', $entity->getSource());
        $this->assertEquals('pp_789', $entity->getSourceId());
        $this->assertNotEmpty($entity->getCreatedAt());
    }

    public function testStagingEntityToArray(): void
    {
        $entity = new class('stripe', 'str_012') extends StagingEntity {};
        $array = $entity->toArray();
        
        $this->assertArrayHasKey('source', $array);
        $this->assertArrayHasKey('sourceId', $array);
        $this->assertArrayHasKey('createdAt', $array);
        $this->assertArrayHasKey('version', $array);
        $this->assertEquals('stripe', $array['source']);
        $this->assertEquals('str_012', $array['sourceId']);
    }

    public function testStagingEntityJsonSerialize(): void
    {
        $entity = new class('bank', 'bank_345') extends StagingEntity {};
        $json = json_encode($entity);
        
        $this->assertNotFalse($json);
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('source', $decoded);
        $this->assertEquals('bank', $decoded['source']);
    }

    public function testStagingEntityDefaultCreatedAt(): void
    {
        $entity = new class('test', 'test_123') extends StagingEntity {};
        
        $this->assertNotEmpty($entity->getCreatedAt());
        // Should be a valid ISO 8601 format
        $this->assertNotFalse(strtotime($entity->getCreatedAt()));
    }

    // ============================================================
    // StagingTransaction Tests
    // ============================================================

    public function testStagingTransactionCreation(): void
    {
        $dto = new class('square', 'sq_txn_1', 100.00, 'USD', 'completed', 'card') extends StagingTransaction {};
        
        $this->assertEquals('square', $dto->getSource());
        $this->assertEquals('sq_txn_1', $dto->getSourceId());
        $this->assertEquals(100.00, $dto->getAmount());
        $this->assertEquals('USD', $dto->getCurrency());
        $this->assertEquals('completed', $dto->getStatus());
        $this->assertEquals('card', $dto->getPaymentMethod());
    }

    public function testStagingTransactionGetters(): void
    {
        $dto = new class('woo', 'woo_txn_2', 50.50, 'EUR', 'pending', 'bank_transfer') extends StagingTransaction {};
        
        $this->assertEquals(50.50, $dto->getAmount());
        $this->assertEquals('EUR', $dto->getCurrency());
        $this->assertEquals('pending', $dto->getStatus());
        $this->assertEquals('bank_transfer', $dto->getPaymentMethod());
    }

    // ============================================================
    // StagingOrder Tests
    // ============================================================

    public function testStagingOrderCreation(): void
    {
        $lineItems = [['sku' => 'ITEM001', 'quantity' => 2]];
        $billing = ['street' => '123 Main St'];
        $shipping = ['street' => '456 Oak Ave'];
        
        $order = new StagingOrder(
            'woo',
            'woo_ord_123',
            150.00,
            'USD',
            'processing',
            'card',
            $lineItems,
            'cust_001',
            $billing,
            $shipping
        );
        
        $this->assertEquals('woo', $order->getSource());
        $this->assertEquals('woo_ord_123', $order->getSourceId());
        $this->assertEquals(150.00, $order->getAmount());
        $this->assertEquals('USD', $order->getCurrency());
        $this->assertEquals('processing', $order->getStatus());
        $this->assertEquals('card', $order->getPaymentMethod());
        $this->assertEquals($lineItems, $order->getLineItems());
        $this->assertEquals('cust_001', $order->getCustomerSourceId());
        $this->assertEquals($billing, $order->getBillingAddress());
        $this->assertEquals($shipping, $order->getShippingAddress());
    }

    public function testStagingOrderLineItems(): void
    {
        $lineItems = [
            ['sku' => 'ITEM001', 'quantity' => 2, 'price' => 25.00],
            ['sku' => 'ITEM002', 'quantity' => 1, 'price' => 100.00],
        ];
        
        $order = new StagingOrder('woo', 'woo_ord_456', 150.00, 'USD', 'completed', 'card', $lineItems);
        
        $this->assertCount(2, $order->getLineItems());
        $this->assertEquals('ITEM001', $order->getLineItems()[0]['sku']);
    }

    public function testStagingOrderVersioning(): void
    {
        $order = new StagingOrder('woo', 'woo_ord_789', 100.00, 'USD', 'pending', 'card');
        
        $this->assertEquals('1.0.0', $order->getVersion());
    }

    // ============================================================
    // StagingInvoice Tests
    // ============================================================

    public function testStagingInvoiceCreation(): void
    {
        $invoice = new StagingInvoice(
            'square',
            'sq_inv_123',
            200.00,
            'USD',
            'sent',
            'card',
            [['sku' => 'SERVICE001', 'quantity' => 1, 'price' => 200.00]],
            'cust_002',
            '2026-09-01'
        );
        
        $this->assertEquals('square', $invoice->getSource());
        $this->assertEquals('sq_inv_123', $invoice->getSourceId());
        $this->assertEquals(200.00, $invoice->getAmount());
        $this->assertEquals('sent', $invoice->getStatus());
        $this->assertCount(1, $invoice->getLineItems());
        $this->assertEquals('cust_002', $invoice->getCustomerSourceId());
        $this->assertEquals('2026-09-01', $invoice->getDueDate());
    }

    // ============================================================
    // StagingPayment Tests
    // ============================================================

    public function testStagingPaymentCreation(): void
    {
        $payment = new StagingPayment(
            'square',
            'sq_pay_123',
            150.00,
            'USD',
            'completed',
            'card',
            'sq_txn_123',
            'sq_inv_123'
        );
        
        $this->assertEquals('square', $payment->getSource());
        $this->assertEquals('sq_pay_123', $payment->getSourceId());
        $this->assertEquals(150.00, $payment->getAmount());
        $this->assertEquals('sq_txn_123', $payment->getTransactionSourceId());
        $this->assertEquals('sq_inv_123', $payment->getInvoiceSourceId());
    }

    // ============================================================
    // StagingRefund Tests
    // ============================================================

    public function testStagingRefundCreation(): void
    {
        $refund = new StagingRefund(
            'square',
            'sq_ref_123',
            50.00,
            'USD',
            'completed',
            'card',
            'sq_txn_123',
            'Customer dissatisfied'
        );
        
        $this->assertEquals('square', $refund->getSource());
        $this->assertEquals('sq_ref_123', $refund->getSourceId());
        $this->assertEquals(50.00, $refund->getAmount());
        $this->assertEquals('sq_txn_123', $refund->getTransactionSourceId());
        $this->assertEquals('Customer dissatisfied', $refund->getReason());
    }

    // ============================================================
    // StagingSubscription Tests
    // ============================================================

    public function testStagingSubscriptionCreation(): void
    {
        $subscription = new StagingSubscription(
            'square',
            'sq_sub_123',
            29.99,
            'USD',
            'active',
            'card',
            'monthly',
            '2026-09-01',
            [['sku' => 'SUB001', 'quantity' => 1, 'price' => 29.99]]
        );
        
        $this->assertEquals('square', $subscription->getSource());
        $this->assertEquals('sq_sub_123', $subscription->getSourceId());
        $this->assertEquals(29.99, $subscription->getAmount());
        $this->assertEquals('monthly', $subscription->getFrequency());
        $this->assertEquals('2026-09-01', $subscription->getNextBillingDate());
        $this->assertCount(1, $subscription->getLineItems());
    }

    // ============================================================
    // StagingCustomer Tests
    // ============================================================

    public function testStagingCustomerCreation(): void
    {
        $customer = new StagingCustomer(
            'woo',
            'woo_cust_123',
            'john@example.com',
            '555-1234',
            'John',
            'Doe',
            'Acme Corp',
            [['type' => 'billing', 'street' => '123 Main St']]
        );
        
        $this->assertEquals('woo', $customer->getSource());
        $this->assertEquals('woo_cust_123', $customer->getSourceId());
        $this->assertEquals('john@example.com', $customer->getEmail());
        $this->assertEquals('555-1234', $customer->getPhone());
        $this->assertEquals('John', $customer->getFirstName());
        $this->assertEquals('Doe', $customer->getLastName());
        $this->assertEquals('Acme Corp', $customer->getCompany());
        $this->assertCount(1, $customer->getAddresses());
    }

    // ============================================================
    // StagingProduct Tests
    // ============================================================

    public function testStagingProductCreation(): void
    {
        $product = new StagingProduct(
            'woo',
            'woo_prod_123',
            'SKU001',
            'Test Product',
            'A test product',
            29.99,
            1.5,
            ['cat_1', 'cat_2'],
            ['img_1.jpg', 'img_2.jpg']
        );
        
        $this->assertEquals('woo', $product->getSource());
        $this->assertEquals('woo_prod_123', $product->getSourceId());
        $this->assertEquals('SKU001', $product->getSku());
        $this->assertEquals('Test Product', $product->getName());
        $this->assertEquals('A test product', $product->getDescription());
        $this->assertEquals(29.99, $product->getPrice());
        $this->assertEquals(1.5, $product->getWeight());
        $this->assertCount(2, $product->getCategories());
        $this->assertCount(2, $product->getImages());
    }

    // ============================================================
    // StagingProductVariant Tests
    // ============================================================

    public function testStagingProductVariantCreation(): void
    {
        $variant = new StagingProductVariant(
            'woo',
            'woo_var_123',
            'woo_prod_123',
            'SKU001-RED',
            ['color' => 'Red', 'size' => 'L'],
            34.99,
            10
        );
        
        $this->assertEquals('woo', $variant->getSource());
        $this->assertEquals('woo_var_123', $variant->getSourceId());
        $this->assertEquals('woo_prod_123', $variant->getProductSourceId());
        $this->assertEquals('SKU001-RED', $variant->getSku());
        $this->assertEquals(['color' => 'Red', 'size' => 'L'], $variant->getAttributes());
        $this->assertEquals(34.99, $variant->getPrice());
        $this->assertEquals(10, $variant->getStock());
    }

    // ============================================================
    // StagingCategory Tests
    // ============================================================

    public function testStagingCategoryCreation(): void
    {
        $category = new StagingCategory(
            'woo',
            'woo_cat_123',
            'Electronics',
            'woo_cat_001',
            'Electronic devices'
        );
        
        $this->assertEquals('woo', $category->getSource());
        $this->assertEquals('woo_cat_123', $category->getSourceId());
        $this->assertEquals('Electronics', $category->getName());
        $this->assertEquals('woo_cat_001', $category->getParentSourceId());
        $this->assertEquals('Electronic devices', $category->getDescription());
    }

    // ============================================================
    // StagingTax Tests
    // ============================================================

    public function testStagingTaxCreation(): void
    {
        $tax = new StagingTax(
            'woo',
            'woo_tax_123',
            'VAT',
            0.20,
            'percentage'
        );
        
        $this->assertEquals('woo', $tax->getSource());
        $this->assertEquals('woo_tax_123', $tax->getSourceId());
        $this->assertEquals('VAT', $tax->getName());
        $this->assertEquals(0.20, $tax->getRate());
        $this->assertEquals('percentage', $tax->getType());
    }

    // ============================================================
    // StagingDiscount Tests
    // ============================================================

    public function testStagingDiscountCreation(): void
    {
        $discount = new StagingDiscount(
            'woo',
            'woo_disc_123',
            'Summer Sale',
            'percentage',
            10.00,
            'SUMMER10'
        );
        
        $this->assertEquals('woo', $discount->getSource());
        $this->assertEquals('woo_disc_123', $discount->getSourceId());
        $this->assertEquals('Summer Sale', $discount->getName());
        $this->assertEquals('percentage', $discount->getType());
        $this->assertEquals(10.00, $discount->getAmount());
        $this->assertEquals('SUMMER10', $discount->getCode());
    }

    // ============================================================
    // StagingCoupon Tests
    // ============================================================

    public function testStagingCouponCreation(): void
    {
        $coupon = new StagingCoupon(
            'woo',
            'woo_cp_123',
            'SAVE20',
            'percentage',
            20.00,
            100,
            '2026-12-31'
        );
        
        $this->assertEquals('woo', $coupon->getSource());
        $this->assertEquals('woo_cp_123', $coupon->getSourceId());
        $this->assertEquals('SAVE20', $coupon->getCode());
        $this->assertEquals('percentage', $coupon->getType());
        $this->assertEquals(20.00, $coupon->getAmount());
        $this->assertEquals(100, $coupon->getUsageLimit());
        $this->assertEquals('2026-12-31', $coupon->getExpiryDate());
    }

    // ============================================================
    // StagingLoyaltyProgram Tests
    // ============================================================

    public function testStagingLoyaltyProgramCreation(): void
    {
        $program = new StagingLoyaltyProgram(
            'square',
            'sq_lp_123',
            ' Rewards',
            'points',
            [['type' => 'earn', 'rate' => 1]]
        );
        
        $this->assertEquals('square', $program->getSource());
        $this->assertEquals('sq_lp_123', $program->getSourceId());
        $this->assertEquals(' Rewards', $program->getName());
        $this->assertEquals('points', $program->getType());
        $this->assertCount(1, $program->getRules());
    }

    // ============================================================
    // StagingLoyaltyReward Tests
    // ============================================================

    public function testStagingLoyaltyRewardCreation(): void
    {
        $reward = new StagingLoyaltyReward(
            'square',
            'sq_lr_123',
            'sq_lp_123',
            'Free Coffee',
            'free_item',
            100
        );
        
        $this->assertEquals('square', $reward->getSource());
        $this->assertEquals('sq_lr_123', $reward->getSourceId());
        $this->assertEquals('sq_lp_123', $reward->getProgramSourceId());
        $this->assertEquals('Free Coffee', $reward->getName());
        $this->assertEquals('free_item', $reward->getType());
        $this->assertEquals(100, $reward->getPoints());
    }

    // ============================================================
    // StagingLoyaltyAccount Tests
    // ============================================================

    public function testStagingLoyaltyAccountCreation(): void
    {
        $account = new StagingLoyaltyAccount(
            'square',
            'sq_la_123',
            'cust_001',
            'sq_lp_123',
            500,
            'Gold'
        );
        
        $this->assertEquals('square', $account->getSource());
        $this->assertEquals('sq_la_123', $account->getSourceId());
        $this->assertEquals('cust_001', $account->getCustomerSourceId());
        $this->assertEquals('sq_lp_123', $account->getProgramSourceId());
        $this->assertEquals(500, $account->getPoints());
        $this->assertEquals('Gold', $account->getTier());
    }

    // ============================================================
    // StagingInventory Tests
    // ============================================================

    public function testStagingInventoryCreation(): void
    {
        $inventory = new StagingInventory(
            'woo',
            'woo_inv_123',
            'SKU001',
            50,
            'Warehouse A',
            'Stock adjustment'
        );
        
        $this->assertEquals('woo', $inventory->getSource());
        $this->assertEquals('woo_inv_123', $inventory->getSourceId());
        $this->assertEquals('SKU001', $inventory->getSku());
        $this->assertEquals(50, $inventory->getQuantity());
        $this->assertEquals('Warehouse A', $inventory->getWarehouse());
        $this->assertEquals('Stock adjustment', $inventory->getReason());
    }

    // ============================================================
    // StagingShipment Tests
    // ============================================================

    public function testStagingShipmentCreation(): void
    {
        $shipment = new StagingShipment(
            'woo',
            'woo_ship_123',
            'woo_ord_123',
            'UPS',
            '1Z999AA10123456784',
            'shipped'
        );
        
        $this->assertEquals('woo', $shipment->getSource());
        $this->assertEquals('woo_ship_123', $shipment->getSourceId());
        $this->assertEquals('woo_ord_123', $shipment->getTransactionSourceId());
        $this->assertEquals('UPS', $shipment->getCarrier());
        $this->assertEquals('1Z999AA10123456784', $shipment->getTrackingNumber());
        $this->assertEquals('shipped', $shipment->getStatus());
    }

    // ============================================================
    // StagingNote Tests
    // ============================================================

    public function testStagingNoteCreation(): void
    {
        $note = new StagingNote(
            'woo',
            'woo_note_123',
            'woo_ord_123',
            'order',
            'Order processed successfully',
            'audit'
        );
        
        $this->assertEquals('woo', $note->getSource());
        $this->assertEquals('woo_note_123', $note->getSourceId());
        $this->assertEquals('woo_ord_123', $note->getEntitySourceId());
        $this->assertEquals('order', $note->getEntityType());
        $this->assertEquals('Order processed successfully', $note->getNote());
        $this->assertEquals('audit', $note->getType());
    }

    // ============================================================
    // StagingLineItem Tests
    // ============================================================

    public function testStagingLineItemStandalone(): void
    {
        $lineItem = new StagingLineItem();
        
        $this->assertInstanceOf(StagingLineItem::class, $lineItem);
        $this->assertNotInstanceOf(StagingEntity::class, $lineItem);
    }

    public function testStagingLineItemTransactionXref(): void
    {
        $lineItem = new StagingLineItem(
            'woo',
            'woo_li_123',
            'woo_ord_123',
            'SKU001',
            'Product A',
            'Description',
            2,
            25.00,
            5.00,
            4.00
        );
        
        $this->assertEquals('woo_ord_123', $lineItem->getTransactionSourceId());
    }

    public function testStagingLineItemFields(): void
    {
        $lineItem = new StagingLineItem(
            'woo',
            'woo_li_123',
            'woo_ord_123',
            'SKU001',
            'Product A',
            'Description',
            2,
            25.00,
            5.00,
            4.00
        );
        
        $this->assertEquals('woo', $lineItem->getSource());
        $this->assertEquals('woo_li_123', $lineItem->getSourceId());
        $this->assertEquals('SKU001', $lineItem->getSku());
        $this->assertEquals('Product A', $lineItem->getName());
        $this->assertEquals('Description', $lineItem->getDescription());
        $this->assertEquals(2, $lineItem->getQuantity());
        $this->assertEquals(25.00, $lineItem->getUnitPrice());
        $this->assertEquals(5.00, $lineItem->getDiscount());
        $this->assertEquals(4.00, $lineItem->getTax());
    }

    public function testStagingLineItemVersion(): void
    {
        $lineItem = new StagingLineItem();
        
        $this->assertEquals('1.0.0', $lineItem->getVersion());
    }

    // ============================================================
    // StagingExistsQuery Tests
    // ============================================================

    public function testStagingExistsQueryCreation(): void
    {
        $query = new StagingExistsQuery('square', 'sq_txn_123', 'order');
        
        $this->assertEquals('square', $query->getSource());
        $this->assertEquals('sq_txn_123', $query->getSourceId());
        $this->assertEquals('order', $query->getEntityType());
    }

    public function testStagingExistsQueryToArray(): void
    {
        $query = new StagingExistsQuery('woo', 'woo_ord_456', 'invoice');
        $array = $query->toArray();
        
        $this->assertEquals('woo', $array['source']);
        $this->assertEquals('woo_ord_456', $array['sourceId']);
        $this->assertEquals('invoice', $array['entityType']);
    }

    // ============================================================
    // StagingExistsResult Tests
    // ============================================================

    public function testStagingExistsResultCreation(): void
    {
        $result = new StagingExistsResult(true, 42, 'pending', 'Order found');
        
        $this->assertTrue($result->getExists());
        $this->assertEquals(42, $result->getStagingId());
        $this->assertEquals('pending', $result->getStatus());
        $this->assertEquals('Order found', $result->getMessage());
    }

    public function testStagingExistsResultNotFound(): void
    {
        $result = new StagingExistsResult(false, 0, '', 'Not found');
        
        $this->assertFalse($result->getExists());
        $this->assertEquals(0, $result->getStagingId());
        $this->assertEquals('', $result->getStatus());
        $this->assertEquals('Not found', $result->getMessage());
    }

    public function testStagingExistsResultToArray(): void
    {
        $result = new StagingExistsResult(true, 42, 'processed', 'Success');
        $array = $result->toArray();
        
        $this->assertTrue($array['exists']);
        $this->assertEquals(42, $array['stagingId']);
        $this->assertEquals('processed', $array['status']);
        $this->assertEquals('Success', $array['message']);
    }

    // ============================================================
    // Version Handling Tests
    // ============================================================

    public function testDifferentVersionsPerDto(): void
    {
        $order = new StagingOrder('woo', 'woo_ord_1', 100.00, 'USD', 'pending', 'card');
        $payment = new StagingPayment('woo', 'woo_pay_1', 100.00, 'USD', 'completed', 'card');
        $customer = new StagingCustomer('woo', 'woo_cust_1');
        
        // All should have version 1.0.0
        $this->assertEquals('1.0.0', $order->getVersion());
        $this->assertEquals('1.0.0', $payment->getVersion());
        $this->assertEquals('1.0.0', $customer->getVersion());
    }

    // ============================================================
    // toArray/jsonSerialize Tests
    // ============================================================

    public function testStagingOrderToArray(): void
    {
        $order = new StagingOrder(
            'woo',
            'woo_ord_123',
            150.00,
            'USD',
            'processing',
            'card',
            [['sku' => 'ITEM001']],
            'cust_001',
            ['street' => '123 Main St'],
            ['street' => '456 Oak Ave']
        );
        
        $array = $order->toArray();
        
        $this->assertEquals('woo', $array['source']);
        $this->assertEquals('woo_ord_123', $array['sourceId']);
        $this->assertEquals(150.00, $array['amount']);
        $this->assertEquals('USD', $array['currency']);
        $this->assertEquals('processing', $array['status']);
        $this->assertEquals('card', $array['paymentMethod']);
        $this->assertEquals([['sku' => 'ITEM001']], $array['lineItems']);
        $this->assertEquals('cust_001', $array['customerSourceId']);
        $this->assertEquals(['street' => '123 Main St'], $array['billingAddress']);
        $this->assertEquals(['street' => '456 Oak Ave'], $array['shippingAddress']);
    }

    public function testStagingLineItemToArray(): void
    {
        $lineItem = new StagingLineItem(
            'woo',
            'woo_li_123',
            'woo_ord_123',
            'SKU001',
            'Product A',
            'Description',
            2,
            25.00,
            5.00,
            4.00
        );
        
        $array = $lineItem->toArray();
        
        $this->assertEquals('woo', $array['source']);
        $this->assertEquals('woo_li_123', $array['sourceId']);
        $this->assertEquals('woo_ord_123', $array['transactionSourceId']);
        $this->assertEquals('SKU001', $array['sku']);
        $this->assertEquals('Product A', $array['name']);
        $this->assertEquals('Description', $array['description']);
        $this->assertEquals(2, $array['quantity']);
        $this->assertEquals(25.00, $array['unitPrice']);
        $this->assertEquals(5.00, $array['discount']);
        $this->assertEquals(4.00, $array['tax']);
        $this->assertEquals('1.0.0', $array['version']);
    }
}
