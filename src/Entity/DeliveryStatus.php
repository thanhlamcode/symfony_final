<?php

namespace App\Entity;

enum DeliveryStatus: string
{
    case PENDING = 'pending';
    case SHIPPING = 'shipping';
    case DELIVERED = 'delivered';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
}