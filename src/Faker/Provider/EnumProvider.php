<?php

namespace App\Faker\Provider;

use Faker\Provider\Base;
// Import tất cả enum
use App\Entity\ShopStatus;
use App\Entity\StaffStatus;
use App\Entity\CustomerStatus;
use App\Entity\ProductStatus;
use App\Entity\CategoryStatus;
use App\Entity\CouponStatus;
use App\Entity\DiscountType;
use App\Entity\PaymentMethod;
use App\Entity\Gender;
use App\Entity\PromotionProgramStatus;
use App\Entity\MemberShipLevelType;
use App\Entity\PointTransactionType;
use App\Entity\ReturnOrderStatus;
use App\Entity\ReturnStatus;
use App\Entity\RatingValue;

class EnumProvider extends Base
{
    public function shopStatus(): string
    {
        return $this->generator->randomElement(ShopStatus::cases())->value;
    }
    public function staffStatus(): string
    {
        return $this->generator->randomElement(StaffStatus::cases())->value;
    }
    public function customerStatus(): string
    {
        return $this->generator->randomElement(CustomerStatus::cases())->value;
    }
    public function productStatus(): string
    {
        return $this->generator->randomElement(ProductStatus::cases())->value;
    }
    public function categoryStatus(): string
    {
        return $this->generator->randomElement(CategoryStatus::cases())->value;
    }
    public function couponStatus(): string
    {
        return $this->generator->randomElement(CouponStatus::cases())->value;
    }
    public function discountType(): string
    {
        return $this->generator->randomElement(DiscountType::cases())->value;
    }
    public function paymentMethod(): string
    {
        return $this->generator->randomElement(PaymentMethod::cases())->value;
    }
    public function gender(): string
    {
        return $this->generator->randomElement(Gender::cases())->value;
    }
    public function promotionProgramStatus(): string
    {
        return $this->generator->randomElement(PromotionProgramStatus::cases())->value;
    }
    public function memberShipLevelType(): string
    {
        return $this->generator->randomElement(MemberShipLevelType::cases())->value;
    }
    public function pointTransactionType(): string
    {
        return $this->generator->randomElement(PointTransactionType::cases())->value;
    }
    public function returnOrderStatus(): string
    {
        return $this->generator->randomElement(ReturnOrderStatus::cases())->value;
    }
    public function returnStatus(): string
    {
        return $this->generator->randomElement(ReturnStatus::cases())->value;
    }
    public function ratingValue(): int
    {
        return $this->generator->randomElement(RatingValue::cases())->value;
    }

    public function workingDays(): array
    {
        $options = [
            ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'],
            ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'],
            ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']
        ];
        return $this->generator->randomElement($options);
    }
} 