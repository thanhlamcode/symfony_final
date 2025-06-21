<?php

namespace App\Entity;

enum ReturnStatus: string
{
    case REQUESTED = 'requested';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case RETURNED = 'returned';
    case REFUNDED = 'refunded';
}
