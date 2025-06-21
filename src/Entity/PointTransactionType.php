<?php

namespace App\Entity;

enum PointTransactionType: string
{
    case EARN = 'earn';
    case REDEEM = 'redeem';
    case REFUND = 'refund';
} 