<?php

/**
 * Copyright (c) 2025 Fastboy Marketing
 */

declare (strict_types = 1);

namespace App\Api\State\Customer;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\Resource\Customer\CreateCustomer;
use App\Entity\Customer;
use App\Entity\CustomerStatus;
use App\Entity\Gender;
use Doctrine\ORM\EntityManagerInterface;

/** @implements ProcessorInterface<CreateCustomer> */
class CreateCustomerProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Customer
    {
        $customer = new Customer();

        $customer->setName($data->name);
        $customer->setEmail($data->email);
        $customer->setPhone($data->phone);
        $customer->setBirthday($data->birthday);
        $customer->setAddress($data->address);
        $customer->setMemberShipLevel($data->memberShipLevel);

        if ($data->gender !== null) {
            $customer->setGender(Gender::from($data->gender));
        }

        $customer->setStatus(CustomerStatus::from($data->status));

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}
