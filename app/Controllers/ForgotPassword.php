<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasswordResetModel;
use App\Models\UserModel;
use App\Result;

class ForgotPassword extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index()
    {
        $this->setLanguageSwitch('forgotPassword');

        if ($this->session->getFlashdata('success')) {
            return view(setting('Authentication.views')['forgotPasswordMessage'], $this->data);
        }

        return view(setting('Authentication.views')['forgotPassword'], $this->data);
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

        $credentials = $this->request->getPost(['email']);
        $result = $this->check($credentials);
        // if (!$result->isOK()) {
        //     return redirect()->route('forgotPassword')->withInput()->with('error', $result->reason());
        // }

        if ($result->isOK()) {

            $user = $result->extraInfo();
            $resets = new PasswordResetModel();

            do {
                $token = bin2hex(openssl_random_pseudo_bytes(16)); // 128-bit
                $reset = $resets->where('token', $token)->first();
            } while (!empty($reset));

            $reset = $resets->where('user_id', $user->id)->first() ?? new \App\Entities\PasswordReset();
            $data = [
                'user_id' => $user->id,
                'token' => $token,
            ];
            $reset->fill($data);

            if (!$resets->save($reset)) {
                return redirect()->route('forgotPassword')->withInput()->with('errors', $resets->errors());
            }

            $link = base_url() . '/' . lang('Routes.resetPassword') . '/' . $token;

            // Sending an e-mail.
            $from = env('email.websiteEmail');
            $name = env('email.websiteName');
            $to = $user->email;
            $subject = lang('Authentication.emailResetPasswordTitle');
            $message = view(setting('Authentication.views')['forgotPasswordEmail'], ['link' => $link]);
            $result = $this->sendEmail($from, $name, $to, $subject, $message);

            if (!$result->isOK()) {
                return redirect()->back()->withInput()->with('error', $result->reason());
            }
        }

        $this->session->remove('rules');

        $this->session->setFlashdata('success', true);
        return redirect()->route('forgotPassword');
        // return redirect()->route('login')->with('notice', lang('Authentication.forgotPasswordSuccess'));
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return string[]
     */
    protected function getValidationRules(): array
    {
        return [
            'email' => [
                'label' => 'Authentication.email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'is_not_unique' => 'Authentication.invalidEmail'
                ]
            ],
            'g-recaptcha-response' => [
                'label' => 'reCAPTCHA',
                'rules' => 'recaptcha',
            ]
        ];
    }

    public function check(array $credentials): Result
    {
        // Can't validate without a email.
        if (empty($credentials['email']) || count($credentials) < 1) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt')
            ]);
        }

        // Find the existing user
        $users = new UserModel();
        $user = $users->where('email', $credentials['email'])->first();
        if ($user === null) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt')
            ]);
        }

        return new Result([
            'success' => true,
            'extraInfo' => $user,
        ]);
    }
}
