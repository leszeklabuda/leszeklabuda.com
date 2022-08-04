<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

$request = Services::request();
$config = $request->config;
$config->negotiatedLocale = $config->negotiatedLocale ?? $request->getLocale();

$uri = &$request->uri;
$segments = array_filter($uri->getSegments());
if (count($segments) && in_array($segments[0], $config->supportedLocales)) {
    $placeholder = '/{locale}';
    $config->localePrefix = '/' . $segments[0];
    $request->setLocale($segments[0]);
} else {
    $placeholder = '';
    $config->localePrefix = '';
    $request->setLocale($request->getDefaultLocale());
}

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Standard
$routes->get($placeholder . '/', 'Home::index', ['as' => 'home']);
$routes->get($placeholder . '/' . lang('Routes.about'), 'About::index', ['as' => 'about']);
$routes->get($placeholder . '/' . lang('Routes.contact'), 'Contact::index', ['as' => 'contact']);
$routes->post($placeholder . '/' . lang('Routes.contact'), 'Contact::action', ['as' => 'contact']);

// Authentication
$routes->get($placeholder . '/' . lang('Routes.login'), 'Login::index', ['as' => 'login']);
$routes->post($placeholder . '/' . lang('Routes.login'), 'Login::action', ['as' => 'login']);
$routes->get($placeholder . '/' . lang('Routes.logout'), 'Login::logout', ['as' => 'logout']);
$routes->get($placeholder . '/' . lang('Routes.register'), 'Register::index', ['as' => 'register']);
$routes->post($placeholder . '/' . lang('Routes.register'), 'Register::action', ['as' => 'register']);
$routes->get($placeholder . '/' . lang('Routes.forgotPassword'), 'ForgotPassword::index', ['as' => 'forgotPassword']);
$routes->post($placeholder . '/' . lang('Routes.forgotPassword'), 'ForgotPassword::action', ['as' => 'forgotPassword']);
$routes->get($placeholder . '/' . lang('Routes.resetPassword') . '/(:segment)', 'ResetPassword::index/$1', ['as' => 'resetPassword']);
$routes->post($placeholder . '/' . lang('Routes.resetPassword') . '/(:segment)', 'ResetPassword::action/$1', ['as' => 'resetPassword']);

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
