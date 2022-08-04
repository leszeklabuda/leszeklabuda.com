<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Result;

class Login extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $this->setLanguageSwitch('login');

        if($this->session->getFlashdata('success')) {
            return view(setting('Authentication.views')['loginMessage'], $this->data);
        }

        if($this->data['loggedIn']) {
            return redirect()->route('home');
        }

        return view(setting('Authentication.views')['login'], $this->data);
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

        // Attempt to login
        $credentials = $this->request->getPost();
        $result = $this->check($credentials);
        if (! $result->isOK()) {
            if(empty($result->reason)) {
                // Invalid password in validate error.
                return redirect()->route('login')->withInput();
            }
            else {
                // Other error in flash message.
                return redirect()->route('login')->withInput()->with('error', $result->reason());
            }
        }

        // Save session data.
        $user = $result->extraInfo();
        $sessionData = [
            'id'       => $user->id,
            'username' => $user->username,
            'email'    => $user->email,
            'loggedIn' => true
        ];
        $this->session->set($sessionData);

        $this->session->setFlashdata('success', true);
        return redirect()->route('login');
    }

    public function logout()
    {
        $this->setLanguageSwitch('login');

        if(!$this->data['loggedIn']) {
            return redirect()->route('home');
        }

        $session = $this->session;
        $session->destroy();

        return view(setting('Authentication.views')['logoutMessage'], $this->data);
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
                'rules' => 'required|is_not_unique[users.username]',
                'errors' => [
                    'is_not_unique' => 'Authentication.invalidUsername'
                ]
            ],
            'password' => [
                'label' => 'Authentication.password',
                'rules' => 'required'
            ]
        ];
    }

    public function check(array $credentials): Result
    {
        // Can't validate without a password.
        if (empty($credentials['password']) || count($credentials) < 2) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt'),
            ]);
        }

        $givenPassword = $credentials['password'];

        // Find the existing user
        $users = new UserModel();
        $user = $users->where('username', $credentials['username'])->first();
        if ($user === null) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt'),
            ]);
        }

        // Now, try matching the passwords.
        $passwords = service('passwords');
        if (! $passwords->verify($givenPassword, $user->password)) {
            $this->session->setFlashdata('errors', [
                'password' => lang('Authentication.invalidPassword')
            ]);

            return new Result([
                'success' => false
            ]);
        }

        return new Result([
            'success'   => true,
            'extraInfo' => $user,
        ]);
    }
}
