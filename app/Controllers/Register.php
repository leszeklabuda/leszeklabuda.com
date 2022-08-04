<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $this->setLanguageSwitch('register');

        if($this->session->getFlashdata('success')) {
            return view(setting('Authentication.views')['registerMessage'], $this->data);
        }

        if($this->data['loggedIn']) {
            return redirect()->route('home');
        }

        return view(setting('Authentication.views')['register'], $this->data);
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

        // Attempt to register
        $users = new UserModel();
        $user = new \App\Entities\User();
        $data = $this->request->getPost(['username', 'password', 'email']);
        $user->fill($data);
        if (! $users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        $this->session->remove('rules');

        $userId = $users->getInsertID();

        $this->session->setFlashdata('success', true);
        return redirect()->route('register');
        // return redirect()->route('login')->with('notice', lang('Authentication.registerSuccess'));
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return string[]
     */
    protected function getValidationRules(): array
    {
        return [
            'username' => [
                'label' => 'Authentication.username',
                'rules' => 'required|min_length[3]|max_length[26]|is_unique[users.username]|regex_match[/^[a-zA-Z0-9ąćęłńóśĄĆĘŁŃÓŚ]+([-]{1}[a-zA-Z0-9]+)*$/]|ci_not_in_list[admin,administrator,leszek,guest,gość]',
                'errors' => [
                    'is_unique' => 'Authentication.unavaliableUsername',
                    'regex_match' => 'Authentication.regexUsername'
                ]
            ],
            'password' => [
                'label' => 'Authentication.password',
                'rules' => 'required|min_length[4]'
            ],
            'email' => [
                'label' => 'Authentication.email',
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'is_unique' => 'Authentication.unavaliableEmail'
                ]
            ],
            'g-recaptcha-response' => [
                'label' => 'reCAPTCHA',
                'rules' => 'recaptcha',
            ]
        ];
    }
}
