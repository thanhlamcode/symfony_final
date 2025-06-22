# Symfony Fixtures

This directory contains comprehensive test data fixtures for the Symfony application using AliceBundle.

## Installation

First, install AliceBundle if not already installed:

```bash
composer require --dev alice-data-fixtures/nelmio-alice-bundle
```

## Fixtures Overview

The fixtures are organized by entity and include realistic test data:

### Core Entities

-   **Shop** (50 records): Coffee shops with realistic names, addresses, and contact info
-   **Staff** (200 records): Employees with various positions and contact details
-   **Customer** (500 records): Customers with membership levels and personal info
-   **Category** (20 records): Product categories for food and beverages
-   **Product** (300 records): Menu items with prices and descriptions
-   **Order** (1000 records): Customer orders with payment methods
-   **OrderItem** (3000 records): Individual items in orders

### Business Logic Entities

-   **MemberShipLevel** (5 records): Customer loyalty tiers (Bronze to Diamond)
-   **PromotionProgram** (20 records): Marketing campaigns and promotions
-   **Coupon** (100 records): Discount codes with various types and values
-   **CouponOrder** (500 records): Coupon usage in orders
-   **CustomerPointTransaction** (2000 records): Loyalty point transactions

### Feedback & Support

-   **OrderFeedback** (800 records): Customer reviews of orders
-   **ShopFeedback** (600 records): Customer reviews of shops
-   **StaffFeedback** (400 records): Customer reviews of staff
-   **ReturnOrder** (100 records): Product returns and refunds

### Settings

-   **ShopSetting** (50 records): Configuration settings for each shop

## Usage

### Load All Fixtures

```bash
php bin/console doctrine:fixtures:load --env=dev
```

### Load Specific Fixtures

```bash
# Load only shops and staff
php bin/console doctrine:fixtures:load --env=dev --group=shop_fixtures.yaml,staff_fixtures.yaml

# Load with append (don't clear database)
php bin/console doctrine:fixtures:load --env=dev --append
```

### Load with Custom Data

You can modify the fixture files to adjust:

-   Number of records (change the range in `{1..N}`)
-   Data values and ranges
-   Relationships between entities

## Data Features

### Realistic Data

-   **Names**: Generated using Faker's name generators
-   **Addresses**: Realistic street addresses
-   **Phone Numbers**: Properly formatted phone numbers
-   **Emails**: Valid email addresses
-   **Dates**: Realistic creation and update timestamps
-   **Prices**: Realistic price ranges in cents (Vietnamese Dong equivalent)

### Relationships

-   Customers are linked to membership levels
-   Products are linked to categories
-   Orders are linked to customers, shops, and staff
-   Order items are linked to orders and products
-   Coupons are linked to promotion programs
-   Feedback is linked to relevant entities

### Enums and Statuses

-   Proper enum values for all status fields
-   Realistic distribution of status values
-   Appropriate date ranges for different entity types

## Customization

### Adding More Data

To add more records, simply change the range in the fixture files:

```yaml
# Change from 50 to 100 shops
shop_{1..100}:
```

### Modifying Data Types

You can customize the data generation by changing the Faker providers:

```yaml
# Custom company names
name: <randomElement(['Starbucks', 'Coffee Bean', 'Dunkin', 'Tim Hortons'])>

# Custom price ranges
price: <numberBetween(10000, 100000)>
```

### Adding New Entities

When adding new entities, ensure they are loaded in the correct order in `main_fixtures.yaml` to handle dependencies properly.

## Notes

-   All IDs use UUID v7 for consistency
-   Timestamps are realistic and span appropriate time periods
-   Unique constraints are respected with proper data generation
-   Relationships are properly maintained across entities
-   Data is suitable for testing and development environments
