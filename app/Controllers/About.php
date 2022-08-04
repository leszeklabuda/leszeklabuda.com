<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index()
    {
        $this->setLanguageSwitch('about');
        return view('about', $this->data);
    }
}
