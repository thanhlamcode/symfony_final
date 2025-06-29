<?php

namespace App\Validator\Constraints;

use App\Api\Resource\Auth\Register;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class PasswordConfirmationValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PasswordConfirmation) {
            throw new UnexpectedTypeException($constraint, PasswordConfirmation::class);
        }

        if (!$value instanceof Register) {
            throw new UnexpectedValueException($value, Register::class);
        }

        if ($value->password !== $value->confirmPassword) {
            $this->context->buildViolation($constraint->message)
                ->atPath('confirmPassword')
                ->addViolation();
        }
    }
} 