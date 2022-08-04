<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pages extends BaseConfig
{
    /**
     * ////////////////////////////////////////////////////////////////////
     * STANDARD PAGES
     * ////////////////////////////////////////////////////////////////////
     */
    public array $views = [
        'layout'                => 'layout',

        'contact'               => 'contact',
        'contactMessage'        => 'contact_message'
    ];
}
