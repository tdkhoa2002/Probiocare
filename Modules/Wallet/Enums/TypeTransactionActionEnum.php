<?php

namespace Modules\Wallet\Enums;

enum TypeTransactionActionEnum: string
{
    case DEPOSIT = 'DEPOSIT';
    case WITHDRAW = "WITHDRAW";
    case STAKING = "STAKING";
    case RETURN = "RETURN";
    case REDEEM_STAKING = "REDEEM_STAKING";
    case REWARD_STAKING = "REWARD_STAKING";
    case COMMISSION_STAKING = "COMMISSION_STAKING";
    case TRADING_FEE_BONUS = "TRADING_FEE_BONUS";
    case DEPOSIT_BONUS = "DEPOSIT_BONUS";
    case INTEREST_BONUS = "INTEREST_BONUS";
    case TRADE_IN = "TRADE_IN";
    case TRADE_OUT = "TRADE_OUT";
    case TRADE_RETURN = "TRADE_RETURN";
    case AGENT_SELL_ADS = "AGENT_SELL_ADS";
    case AGENT_BUY_ADS = "AGENT_BUY_ADS";
    case AGENT_SELL_ADS_CANCEL = "AGENT_SELL_ADS_CANCEL";
    case USER_SELL_ADS_CANCEL = "USER_SELL_ADS_CANCEL";
    case USER_BUY_ADS = "USER_BUY_ADS";
    case USER_SELL_ADS = "USER_SELL_ADS";
    case SWAP_FROM = "SWAP_FROM";
    case SWAP_TO = "SWAP_TO";
    case COMMISSION_LOYALTY = "COMMISSION_LOYALTY";
    case SUBCRIBE_LOYALTY = "SUBCRIBE_LOYALTY";
    case REWARD_LOYALTY = "REWARD_LOYALTY";
    case VOUCHER_REFUND = "VOUCHER_REFUND";
}
