<?php

namespace Modules\Wallet\Enums;

enum StatusTransactionEnum: string
{
    case CREATED = 'CREATED';
    case ACCEPTED = 'ACCEPTED';
    case PROCESSING = 'PROCESSING';
    case COMPLETED = 'COMPLETED';
    case CANCELED = 'CANCELED';
    case FAIL = 'FAIL';
}
