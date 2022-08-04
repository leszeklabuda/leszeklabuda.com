<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function home()
    {
        $this->setLanguageSwitch('home');
        return view('pages/home', $this->data);
    }

    public function about()
    {
        $this->setLanguageSwitch('about');
        return view('pages/about', $this->data);
    }

    public function contact()
    {
        $this->setLanguageSwitch('contact');
        return view('pages/contact', $this->data);
    }
}
