<?php
namespace Modules\Customer\Enums;

enum TypeEmailEnum:string {
    case REGISTER = 'REGISTER';
    case LOGIN = 'LOGIN';
    case FORGOTPASSWORD = 'FORGOTPASSWORD';
    case CHANGEPASSWORD = 'CHANGEPASSWORD';
    case WITHDRAW = 'WITHDRAW';
}