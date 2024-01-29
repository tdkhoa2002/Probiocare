<?php

return [
    'list resource' => 'List customers',
    'create resource' => 'Create customers',
    'edit resource' => 'Edit customers',
    'destroy resource' => 'Destroy customers',
    'title' => [
        'customers' => 'Customer',
        'create customer' => 'Create a customer',
        'edit customer' => 'Edit a customer',
    ],
    'button' => [
        'create customer' => 'Create a customer',
    ],
    'table' => [
        'email' => 'Email',
        'password' => 'Password',
        'ref_code' => 'Ref code',
        'gg_auth' => 'Google Auth',
        'status_gg_auth' => 'Status gg auth',
        'status_kyc' => 'Status kyc',
        'sponsor_id' => 'Sponsor',
        'sponsor_floor' => 'Sponsor floor',
        'status' => 'Status',
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'phone_number' => 'Phone number',
        'address' => 'Address',
        'birthday' => 'Birthday',
    ],
    'form' => [
        'email' => 'Email',
        'password' => 'Password',
        'ref_code' => 'Ref code',
        'gg_auth' => 'Google Auth',
        'status_gg_auth' => 'Status gg auth',
        'status_kyc' => 'Status kyc',
        'sponsor_id' => 'Sponsor',
        'sponsor_floor' => 'Sponsor floor',
        'status' => 'Status',
        'firstname' => 'Firstname',
        'lastname' => 'Lastname',
        'phone_number' => 'Phone number',
        'address' => 'Address',
        'birthday' => 'Birthday',
    ],
    'messages' => [
        'customer created' => 'Customer successfully created.',
        'customer_not_found' => 'Customer not found.',
        'customer updated' => 'Customer successfully updated.',
        'customer deleted' => 'Customer successfully deleted.',
        'send_email_verify_register_success'=>'Send email verify register success',
        'send_email_code_login_success'=>'Send email code login success',
        'email_or_password_wrong'=>'Email or password wrong',
        'customer_not_active'=>'Customer not active',
        'verify_code_expired'=>'Verify code expired',
        'login_success'=>'Login success',
        'password_min_8_character'=>'Password min 8 character',
        'confim_password_dont_match'=>'Confim password dont match',
        'change_password_success'=>'Change password success',
        'send_email_forgot_success'=>'Send email forgot success',
        'update_profile_success'=>'Update profile success',
        'sponsor_not_found'=>'Sponsor not found',
        'kyc_required'=>'Kyc required',
        'require_auth'=>'Please log in before executing.',
        'resend_email_success'=>'Gửi lại code thành công',
        'err_request_too_often'=>'Bạn đã yêu cầu quá nhiều lần vui lòng đợi',
        'email_wrong_not_esxit'=>'Email không đúng hoặc không tồn tại'
    ],
    'validation' => [],
    'routers' => [
        'login' => 'login',
        'verifyLogin' => 'verify-login',
        'forgot' => 'forgot-password',
        'verify_forgot' => 'verify-forgot-password',
        'register' => 'register',
        'verifyRegister' => 'verify-register'
    ]
];
