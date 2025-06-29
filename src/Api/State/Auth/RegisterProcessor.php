<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Auth;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Auth\Register;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Uid\Uuid;
use Doctrine\DBAL\Connection;

/** @implements ProcessorInterface<Register> */
class RegisterProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface      $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository     $userRepository,
        private Connection $connection,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $id = Uuid::v7();
        $hashedPassword = $this->passwordHasher->hashPassword(new User(), $data->password);

        $this->connection->insert('"user"', [
            'id' => $id,
            'email' => $data->email,
            'roles' => json_encode(['ROLE_USER']),
            'password' => $hashedPassword,
        ]);

        // Lấy lại user vừa tạo (hoặc trả về thông báo thành công)
        // Hoặc return null nếu chỉ cần 201 Created
    }
}
