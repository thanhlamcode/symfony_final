<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Auth;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\Resource\Auth\Me;
use Symfony\Bundle\SecurityBundle\Security;

/** @implements ProviderInterface<Me> */
class MeProvider implements ProviderInterface
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): Me
    {
        $user = $this->security->getUser();
        
        if (!$user) {
            throw new \RuntimeException('User not found');
        }

        return new Me($user);
    }
} 