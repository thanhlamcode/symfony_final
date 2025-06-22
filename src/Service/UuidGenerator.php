<?php

namespace App\Service;

use Symfony\Component\Uid\UuidV7;

class UuidGenerator
{
    public static function generate(): UuidV7
    {
        return new UuidV7();
    }
    
    public static function generateString(): string
    {
        return (new UuidV7())->toRfc4122();
    }
} 