<?php

use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\URI;
use CodeIgniter\Router\Exceptions\RouterException;
use Config\App;
use Config\Services;

// CodeIgniter URL Helpers

if (!function_exists('site_url')) {
    /**
     * Returns a site URL as defined by the App config.
     *
     * @param mixed    $relativePath URI string or array of URI segments
     * @param App|null $config       Alternate configuration to use
     */
    function site_url($relativePath = '', ?string $scheme = null, ?App $config = null): string
    {
        // Convert array of segments to a string
        if (is_array($relativePath)) {
            $relativePath = implode('/', $relativePath);
        }

        // $relativePath = strtr($relativePath, ['{locale}' => Services::request()->getLocale()]);

        $config = $config ?? config('App');

        // Jeżeli relativePath nie zaczyna się od :// lub od / to dodaj prefix lokalizacji.
        if (!preg_match('#^(\w+:)?//|^/#i', $relativePath)) {
            $relativePath = $config->localePrefix . '/' . $relativePath;
        }

        // Test 127.0.0.1 & 192.168.1.4
        $environment = env('CI_ENVIRONMENT');
        $appBaseURL = env('app.baseURL');   // https://127.0.0.1/ | https://leszeklabuda.com/
        if ($environment === 'development' && preg_match('/127.0.0.1/', $appBaseURL)) {
            $httpHost = Services::request()->getServer('HTTP_HOST');    // 127.0.0.1 | 192.168.1.4
            $config->baseURL = preg_replace('/127.0.0.1/', $httpHost, $config->baseURL);
        }

        $uri = _get_uri($relativePath, $config);

        return URI::createURIString($scheme ?? $uri->getScheme(), $uri->getAuthority(), $uri->getPath(), $uri->getQuery(), $uri->getFragment());
        // return URI::createURIString(null, '/', $uri->getPath(), $uri->getQuery(), $uri->getFragment());
    }
}

function lang_url($line, $args = [], ?string $locale = null)
{
    $config = config('App');

    $request = Services::request();
    $locale = $locale ?? $request->getLocale();

    if (!in_array($locale, $config->supportedLocales)) {
        return;
    }

    $localePrefix = '';
    if ($config->showDefaultLocale || $locale !== $config->defaultLocale) {
        $localePrefix = '/' . $locale;
    }

    return $localePrefix . '/' . lang($line, $args, $locale);
}

function page_anchor($item)
{
    return anchor($item['url'] ?? '', $item['title'] ?? '', $item['attributes'] ?? '');
}
