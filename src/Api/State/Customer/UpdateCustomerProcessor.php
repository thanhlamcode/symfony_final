<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Customer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Customer\UpdateCustomer;
use App\Entity\Customer;
use App\Entity\CustomerStatus;
use App\Entity\Gender;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<UpdateCustomer> */
class UpdateCustomerProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Customer
    {
        $customer = $this->entityManager->find(Customer::class, $data->id);
        
        if (!$customer) {
            throw new \InvalidArgumentException('Customer not found');
        }

        if ($data->name !== null) {
            $customer->setName($data->name);
        }
        
        if ($data->email !== null) {
            $customer->setEmail($data->email);
        }
        
        if ($data->phone !== null) {
            $customer->setPhone($data->phone);
        }
        
        if ($data->birthday !== null) {
            $customer->setBirthday($data->birthday);
        }
        
        if ($data->address !== null) {
            $customer->setAddress($data->address);
        }
        
        if ($data->memberShipLevel !== null) {
            $customer->setMemberShipLevel($data->memberShipLevel);
        }
        
        if ($data->gender !== null) {
            $customer->setGender(Gender::from($data->gender));
        }
        
        if ($data->status !== null) {
            $customer->setStatus(CustomerStatus::from($data->status));
        }

        $this->entityManager->flush();

        return $customer;
    }
} 