<?php
namespace Modules\Customer\Enums;

enum TypeCustomerEnum:int {
    case NEW_CUSTOMER = 0;
    case EMAIL_VERIFIED = 1;
}