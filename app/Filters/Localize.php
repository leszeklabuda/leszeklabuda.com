<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Localize implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $config = $request->config;
        $defaultLocale = $request->getDefaultLocale();
        $uri = &$request->uri;
        $segments = array_filter($uri->getSegments());
        if (count($segments) > 0) {
            if ($config->showDefaultLocale) {
                // Redirect to a url with the default locale subdirectory, eg. '/...' => '/pl/...'
                if (!in_array($segments[0], $request->config->supportedLocales)) {
                    array_unshift($segments, $defaultLocale);
                    return redirect()->to('/' . implode('/', $segments));
                }
            } else {
                // Redirect to a url without the default locale subdirectory, eg. '/pl/...' => '/...'
                if ($segments[0] === $defaultLocale) {
                    array_shift($segments);
                    return redirect()->to('/' . implode('/', $segments));
                }
            }
        }
        // Redirect to a URL with a negotiated locale subdirectory, eg. '/' => '/en'
        else {
            if (
                $config->showDefaultLocale ||
                $config->negotiateLocale && $config->negotiatedLocale !== $defaultLocale
            ) {
                return redirect()->to("/{$config->negotiatedLocale}");
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
