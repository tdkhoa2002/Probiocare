<?php

namespace Modules\ShoppingCart\Enums;

enum StatusOrderEnum: string
{
    case CREATED = 'CREATED';
    case SHIPPING = 'SHIPPING';
    case PAYMENTING = 'PAYMENTING';
    case PAYMENT_COMPLETED = 'PAYMENT_COMPLETED';
    case PAYMENT_FAILED = 'PAYMENT_FAILED';
    case PROCESSING = 'PROCESSING';
    case COMPLETED = 'COMPLETED';
    case CANCELED = 'CANCELED';
}
