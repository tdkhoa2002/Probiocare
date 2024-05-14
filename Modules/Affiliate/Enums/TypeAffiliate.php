<?php

namespace Modules\Affiliate\Enums;

enum TypeAffiliate: string
{
    case DEPOSIT_BONUS = 'DEPOSIT_BONUS';
    case INTEREST_BONUS = 'INTEREST_BONUS';
    case TRADING_FEE_BONUS = 'TRADING_FEE_BONUS';
}
