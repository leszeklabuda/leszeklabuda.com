<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PasswordResetModel;
use App\Models\UserModel;
use App\Result;
use CodeIgniter\I18n\Time;

class ResetPassword extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

    public function index($token)
    {
        $this->setLanguageSwitch('resetPassword');
        $this->data['token'] = $token;

        $result = $this->check($token);
        if (!$result->isOK()) {
            return redirect()->route('forgotPassword')->withInput()->with('error', $result->reason());
        }

        return view(setting('Authentication.views')['resetPassword'], $this->data);
    }

    public function action($token)
    {
        $rules = $this->getValidationRules();
        $this->session->setFlashdata('rules', $rules);

        /** @var Validation $validation */
        $validation = service('validation');

        if (!$this->validate($rules)) {
            return redirect()->route('resetPassword', [$token])->withInput()->with('errors', $validation->getErrors());
        }

        $this->session->remove('rules');

        $result = $this->check($token);
        if (!$result->isOK()) {
            return redirect()->route('forgotPassword')->with('error', $result->reason());
        }

        $reset = $result->extraInfo();
        $data = $this->request->getPost(['password']);
        
        $result = $this->changePassword($reset->user_id, $data['password']);
        if (!$result->isOK()) {
            return redirect()->route('forgotPassword')->with('error', $result->reason());
        }

        $user = $result->extraInfo();

        $resets = new PasswordResetModel();
        $result2 = $resets->delete($reset->id);

        return redirect()->route('login')->with('notice', lang('Authentication.resetPasswordSuccess'));
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return string[]
     */
    protected function getValidationRules(): array
    {
        return [
            'password' => [
                'label' => 'Authentication.password',
                'rules' => 'required|min_length[4]'
            ],
            'password-confirmation' => [
                'label' => 'Authentication.passwordConfirmation',
                'rules' => 'required|matches[password]'
            ]
        ];
    }

    public function check($token): Result
    {
        if (empty($token)) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt')    // empty string
            ]);
        }

        $resets = new PasswordResetModel();
        $reset = new \App\Entities\PasswordReset();
        $reset->token = $token;
        $reset = $resets->where('token', $reset->token)->first();

        if (empty($reset)) {
            return new Result([
                'success' => false,
                'reason'  => lang('Authentication.resetPasswordFailure')    // no token in database
            ]);
        }

        $now = Time::createFromTimestamp(time());
        $expire = Time::createFromTimestamp(strtotime($reset->updated_at) + 3600);
        $result = $now->isBefore($expire);

        if (!$result) {
            return new Result([
                'success' => false,
                'reason'  => lang('Authentication.resetPasswordFailure')    // invalid token
            ]);
        }

        return new Result([
            'success' => true,
            'extraInfo' => $reset
        ]);
    }

    public function changePassword($userId, $password): Result
    {
        if (empty($userId) || empty($password)) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt')    // empty string
            ]);
        }

        $users = new UserModel();
        $user = $users->where('id', $userId)->first();

        if ($user === null) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt') // no user
            ]);
        }

        $user->password = $password;
        $users->save($user);

        return new Result([
            'success' => true,
            'extraInfo' => $user
        ]);
    }
}
