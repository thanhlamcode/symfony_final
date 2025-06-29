<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class PasswordConfirmation extends Constraint
{
    public string $message = 'The password confirmation does not match.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
} 