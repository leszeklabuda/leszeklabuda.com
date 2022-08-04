<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->setLanguageSwitch('home');
        return view('home', $this->data);
    }
}
