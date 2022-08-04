<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Authentication extends BaseConfig
{
    /**
     * ////////////////////////////////////////////////////////////////////
     * AUTHENTICATION
     * ////////////////////////////////////////////////////////////////////
     */
    public array $views = [
        'layout'                => 'Authentication/layout',

        'login'                 => 'Authentication/login',
        'loginMessage'          => 'Authentication/login_message',
        'logout'                => 'Authentication/logout',
        'logoutMessage'         => 'Authentication/logout_message',
        'register'              => 'Authentication/register',
        'registerMessage'       => 'Authentication/register_message',
        'forgotPassword'        => 'Authentication/forgot_password',
        'forgotPasswordMessage' => 'Authentication/forgot_password_message',
        'forgotPasswordEmail'   => 'Authentication/forgot_password_email',
        'resetPassword'         => 'Authentication/reset_password'
    ];
}
