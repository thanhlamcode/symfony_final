<?php

namespace App\Entity;

enum PromotionProgramStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case EXPIRED = 'expired';
} 