<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Auth;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Auth\RefreshToken;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/** @implements ProcessorInterface<RefreshToken> */
class RefreshTokenProcessor implements ProcessorInterface
{
    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private UserRepository $userRepository,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): array
    {
        try {
            // Decode the token to get user information
            $payload = $this->jwtManager->parse($data->token);
            $userEmail = $payload['email'] ?? null;
            
            if (!$userEmail) {
                throw new UnauthorizedHttpException('Bearer', 'Invalid token');
            }

            $user = $this->userRepository->findOneBy(['email' => $userEmail]);
            
            if (!$user) {
                throw new UnauthorizedHttpException('Bearer', 'User not found');
            }

            // Generate new token
            $newToken = $this->jwtManager->create($user);

            return [
                'token' => $newToken,
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles(),
                ]
            ];
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid token');
        }
    }
} 