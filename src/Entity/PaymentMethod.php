<?php

namespace App\Entity;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case CREDIT_CARD = 'credit_card';
    case BANK_TRANSFER = 'bank_transfer';
} 