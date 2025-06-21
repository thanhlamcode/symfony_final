<?php

namespace App\Entity;

enum StaffStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
} 