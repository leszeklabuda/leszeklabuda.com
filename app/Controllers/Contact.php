<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $this->setLanguageSwitch('contact');

        if ($this->session->getFlashdata('success')) {
            return view(setting('Pages.views')['contactMessage'], $this->data);
        }

        $this->data['email'] = $this->data['loggedIn'] ? $this->data['email'] : '';
        return view(setting('Pages.views')['contact'], $this->data);
    }

    public function action()
    {
        $rules = $this->getValidationRules();
        $this->session->setFlashdata('rules', $rules);

        /** @var Validation $validation */
        $validation = service('validation');

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = $this->request->getPost(['subject', 'message', 'email']);

        // Sending an e-mail.
        $from = esc($data['email']);
        $name = $data['email'] ?: env('email.websiteName');
        $to = env('email.privateEmail');
        $subject = esc($data['subject']);
        $message = esc($data['message']);
        $result = $this->sendEmail($from, $name, $to, $subject, $message);

        if (!$result->isOK()) {
            return redirect()->back()->withInput()->with('error', $result->reason());
        }

        $this->session->remove('rules');

        $this->session->setFlashdata('success', true);
        return redirect()->route('contact');
    }

    protected function getValidationRules(): array
    {
        return [
            'subject' => [
                'label' => 'Pages.subject',
                'rules' => 'required|min_length[3]|max_length[255]'
            ],
            'message' => [
                'label' => 'Pages.message',
                'rules' => 'required'
            ],
            'g-recaptcha-response' => [
                'label' => 'reCAPTCHA',
                'rules' => 'recaptcha',
            ]
        ];
    }
}
