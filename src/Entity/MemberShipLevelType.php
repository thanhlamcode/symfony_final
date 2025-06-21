<?php

namespace App\Entity;

enum MemberShipLevelType: string
{
    case BRONZE = 'bronze';
    case SILVER = 'silver';
    case GOLD = 'gold';
    case PLATINUM = 'platinum';
} 