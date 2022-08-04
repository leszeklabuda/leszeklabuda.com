<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Result;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    // Data for view templates.
    protected $data = [];

    protected $session = null;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();

        $this->session = \Config\Services::session();
        $this->initializeData();
    }

    public function initializeData()
    {
        helper('cookie');
        helper('setting');

        // Language detection.
        $this->data['locale'] = $this->request->getLocale();

        $theme = get_cookie('theme') ?? ''; // null | light | dark
        if ($theme === 'dark') {
            $this->data['theme'] = 'dark';
            $this->data['themeColor'] = '#000000';
        } else {
            $this->data['theme'] = 'light';
            $this->data['themeColor'] = '#ffffff';
        }

        // Session user data.
        $this->data['id'] = $this->session->get('id') ?? null;
        $this->data['username'] = $this->session->get('username') ?? lang('Authentication.guest');
        $this->data['email'] = $this->session->get('email') ?? null;
        $this->data['loggedIn'] = $this->session->get('loggedIn') ?? false;

        $this->data['success'] = $this->session->getFlashData('success');
        $this->data['message'] = $this->session->getFlashData('message');

        $navi = [
            'pl' => [
                'url' => '/pl',
                'title' => lang("Routes.pl.title")
            ],
            'en' => [
                'url' => '/en',
                'title' => lang("Routes.en.title")
            ]
        ];
        $this->data['navi'] = $navi;
    }

    public function setLanguageSwitch($prop)
    {
        $this->data['navi']['pl']['url'] = lang_url('Routes.' . $prop, [], 'pl');
        $this->data['navi']['en']['url'] = lang_url('Routes.' . $prop, [], 'en');
    }

    public function sendEmail($from, $name, $to, $subject, $message): Result
    {
        $from = $from ?: env('email.websiteEmail');

        /** @var Email $email */
        $email = service('email');

        $email->setFrom($from, $name);
        $email->setTo($to);
        $email->setSubject($subject);
        $email->setMessage($message);
        $email->mailType = 'html';
        $result = $email->send();

        if (!$result) {
            return new Result([
                'success' => false,
                'reason'  => lang('Pages.badAttempt'),
            ]);
        }

        return new Result([
            'success'   => true
        ]);
    }
}
