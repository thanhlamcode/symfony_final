<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Auth;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Auth\Logout;

/** @implements ProcessorInterface<Logout> */
class LogoutProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): array
    {
        // In a stateless JWT setup, logout is typically handled client-side
        // by removing the token from storage. However, you could implement
        // a token blacklist here if needed.
        
        // For now, we'll just return a success message
        return [
            'message' => 'Successfully logged out',
            'success' => true
        ];
    }
} 