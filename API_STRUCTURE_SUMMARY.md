# API Platform Structure Summary

## Completed Entities

### 1. Shop ✅

-   **Entity**: Updated with Get, GetCollection, Delete operations
-   **DTOs**: CreateShop, UpdateShop
-   **Processors**: CreateShopProcessor, UpdateShopProcessor
-   **Filters**: name, email, status, shopCode

### 2. Staff ✅

-   **Entity**: Updated with Get, GetCollection, Delete operations
-   **DTOs**: CreateStaff, UpdateStaff
-   **Processors**: CreateStaffProcessor, UpdateStaffProcessor
-   **Filters**: name, email, position, isActive

## Remaining Entities to Complete

### 3. Customer

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateCustomer, UpdateCustomer
-   **Processors**: CreateCustomerProcessor, UpdateCustomerProcessor
-   **Filters**: firstName, lastName, email, status, gender

### 4. Category

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateCategory, UpdateCategory
-   **Processors**: CreateCategoryProcessor, UpdateCategoryProcessor
-   **Filters**: name, status

### 5. Product

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateProduct, UpdateProduct
-   **Processors**: CreateProductProcessor, UpdateProductProcessor
-   **Filters**: name, status, category

### 6. Order

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateOrder, UpdateOrder
-   **Processors**: CreateOrderProcessor, UpdateOrderProcessor
-   **Filters**: customer, shop, staff, paymentMethod

### 7. Coupon

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateCoupon, UpdateCoupon
-   **Processors**: CreateCouponProcessor, UpdateCouponProcessor
-   **Filters**: name, code, status, discountType

### 8. PromotionProgram

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreatePromotionProgram, UpdatePromotionProgram
-   **Processors**: CreatePromotionProgramProcessor, UpdatePromotionProgramProcessor
-   **Filters**: name, status

### 9. MemberShipLevel

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateMemberShipLevel, UpdateMemberShipLevel
-   **Processors**: CreateMemberShipLevelProcessor, UpdateMemberShipLevelProcessor
-   **Filters**: name, type

### 10. OrderItem

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateOrderItem, UpdateOrderItem
-   **Processors**: CreateOrderItemProcessor, UpdateOrderItemProcessor

### 11. CouponOrder

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateCouponOrder, UpdateCouponOrder
-   **Processors**: CreateCouponOrderProcessor, UpdateCouponOrderProcessor

### 12. CustomerPointTransaction

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateCustomerPointTransaction, UpdateCustomerPointTransaction
-   **Processors**: CreateCustomerPointTransactionProcessor, UpdateCustomerPointTransactionProcessor

### 13. OrderFeedback

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateOrderFeedback, UpdateOrderFeedback
-   **Processors**: CreateOrderFeedbackProcessor, UpdateOrderFeedbackProcessor

### 14. ShopFeedback

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateShopFeedback, UpdateShopFeedback
-   **Processors**: CreateShopFeedbackProcessor, UpdateShopFeedbackProcessor

### 15. StaffFeedback

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateStaffFeedback, UpdateStaffFeedback
-   **Processors**: CreateStaffFeedbackProcessor, UpdateStaffFeedbackProcessor

### 16. ReturnOrder

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateReturnOrder, UpdateReturnOrder
-   **Processors**: CreateReturnOrderProcessor, UpdateReturnOrderProcessor

### 17. ShopSetting

-   **Entity**: Needs API Platform operations
-   **DTOs**: CreateShopSetting, UpdateShopSetting
-   **Processors**: CreateShopSettingProcessor, UpdateShopSettingProcessor

## Pattern for Each Entity

### Entity Structure

```php
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/{entity_plural}/{id}.{_format}',
            requirements: ['id' => Requirement::UUID_V7],
            openapi: new Operation(tags: ['{Entity}']),
            normalizationContext: ['groups' => ['api:{entity}:get', 'api:{entity}']],
        ),
        new GetCollection(
            uriTemplate: '/{entity_plural}.{_format}',
            openapi: new Operation(tags: ['{Entity}']),
            normalizationContext: ['groups' => ['api:{entity}:get_collection', 'api:{entity}']]
        ),
        new Delete()
    ]
)]
#[ApiFilter(
    filterClass: SearchFilter::class,
    properties: [
        // Define searchable properties
    ]
)]
```

### DTO Structure (Create)

```php
#[Post(
    uriTemplate: '/{entity_plural}.{_format}',
    openapi: new Operation(tags: ['{Entity}']),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: {Entity}::class,
    processor: Create{Entity}Processor::class
)]
```

### DTO Structure (Update)

```php
#[Patch(
    uriTemplate: '/{entity_plural}/{id}.{_format}',
    openapi: new Operation(tags: ['{Entity}']),
    exceptionToStatus: [
        UniqueConstraintViolationException::class => 422,
        ORMException::class => 422
    ],
    output: {Entity}::class,
    processor: Update{Entity}Processor::class
)]
```

### Processor Structure

```php
/** @implements ProcessorInterface<Create{Entity}> */
class Create{Entity}Processor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): {Entity}
    {
        // Implementation
    }
}
```

## Next Steps

1. **Complete remaining entities** following the established pattern
2. **Add proper validation** for each DTO based on entity properties
3. **Configure API documentation** with proper examples
4. **Test API endpoints** to ensure they work correctly
5. **Add authentication/authorization** if needed
6. **Configure CORS** if needed for frontend integration

## Files Created

### Shop

-   `src/Entity/Shop.php` (updated)
-   `src/Api/Resource/Shop/CreateShop.php`
-   `src/Api/Resource/Shop/UpdateShop.php`
-   `src/Api/State/Shop/CreateShopProcessor.php`
-   `src/Api/State/Shop/UpdateShopProcessor.php`

### Staff

-   `src/Entity/Staff.php` (updated)
-   `src/Api/Resource/Staff/CreateStaff.php`
-   `src/Api/Resource/Staff/UpdateStaff.php`
-   `src/Api/State/Staff/CreateStaffProcessor.php`
-   `src/Api/State/Staff/UpdateStaffProcessor.php`

## Directory Structure

```
src/
├── Api/
│   ├── Resource/
│   │   ├── Shop/
│   │   │   ├── CreateShop.php
│   │   │   └── UpdateShop.php
│   │   └── Staff/
│   │       ├── CreateStaff.php
│   │       └── UpdateStaff.php
│   └── State/
│       ├── Shop/
│       │   ├── CreateShopProcessor.php
│       │   └── UpdateShopProcessor.php
│       └── Staff/
│           ├── CreateStaffProcessor.php
│           └── UpdateStaffProcessor.php
└── Entity/
    ├── Shop.php (updated)
    └── Staff.php (updated)
```
